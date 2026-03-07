<?php

namespace App\Http\Controllers;

use App\Models\Medico\Medico;
use App\Models\Paciente\Cita;
use App\Models\Paciente\ConsultaGeneral;
use App\Models\Paciente\Paciente;
use App\Models\Persona\Persona;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('login');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usuario = auth()->user();
        $nombre = Persona::select('persona.nombre', 'persona.genero', 'tipo_usuario.nombre AS tipo_usuario')
            ->join('users', 'users.id_persona', 'persona.id')
            ->join('tipo_usuario', 'tipo_usuario.id', 'users.tipo_usuario')
            ->where('users.id', $usuario->id)
            ->first();


        return view('home')
            ->with('data', $nombre);
    }

    public function login()
    {
        if (auth()->check()) {
            return redirect()->intended('/dashboard');
        } else {
            return view('auth.login');
        }
    }

    public function dashboard()
    {
        $usuario = auth()->user();
        $hoy = Carbon::today()->toDateString();
        $mesActual = Carbon::now()->month;

        // 1. PERFIL DEL USUARIO (Común para ambos)
        $nombre = Persona::select('persona.nombre', 'persona.genero', 'tipo_usuario.nombre AS tipo_usuario')
            ->join('users', 'users.id_persona', 'persona.id')
            ->join('tipo_usuario', 'tipo_usuario.id', 'users.tipo_usuario')
            ->where('users.id', $usuario->id)
            ->first();

        // Variables por defecto que enviaremos a la vista
        $citasHoy = collect();
        $citasPendientes = 0;
        $pacientesHoy = 0;
        $consultasTotales = 0;
        $nuevosExpedientes = 0;

        // ========================================================
        // 2. LÓGICA BIFURCADA POR ROL
        // ========================================================

        if ($usuario->tipo_usuario == 2) {

            // --- MÉTRICAS PARA EL MÉDICO ---

            // A. Obtener el ID del médico logueado usando su id_persona
            $medico = Medico::where('id_persona', $usuario->id_persona)->first();
            $idMedico = $medico ? $medico->id : 0;

            // B. Su agenda de hoy (Solo las pendientes: estatus 1)
            $citasHoy = Cita::select('cita.*', 'persona.nombre as paciente_nom', 'persona.ap_paterno', 'persona.genero')
                ->join('paciente', 'paciente.id', '=', 'cita.id_paciente')
                ->join('persona', 'persona.id', '=', 'paciente.id_persona')
                ->whereDate('cita.fecha_proxima', $hoy)
                ->where('cita.estatus', 1)
                ->where('cita.id_medico', $idMedico) // <--- Filtro crucial: Solo SUS citas
                ->orderBy('cita.hora_proxima', 'asc')
                ->get();

            // C. Tarjetas del Médico
            $citasPendientes = $citasHoy->count();

            // Total de pacientes que verá hoy (Pendientes + Ya Atendidos)
            $pacientesHoy = Cita::whereDate('fecha_proxima', $hoy)
                ->where('id_medico', $idMedico)
                ->count();

            // Consultas históricas dadas por este médico
            $consultasTotales = ConsultaGeneral::where('id_usuario', $usuario->id)->count();

            // Nuevos pacientes de la clínica este mes
            $nuevosExpedientes = Paciente::whereMonth('fecha_registro', $mesActual)->count();
        } else {

            // --- MÉTRICAS PARA EL ADMINISTRADOR (tipo_usuario == 1) ---

            // A. Citas Globales de la clínica hoy (Pendientes + Atendidas de TODOS los médicos)
            $citasPendientes = Cita::whereDate('fecha_proxima', $hoy)->count();

            // B. Pacientes únicos agendados hoy (Para saber cuánta gente pisará la clínica)
            $pacientesHoy = Cita::whereDate('fecha_proxima', $hoy)->distinct('id_paciente')->count('id_paciente');

            // C. Ventas del Día (Ejemplo preparado para cuando tengas tu módulo de ventas)
            // $consultasTotales = Venta::whereDate('fecha_venta', $hoy)->sum('total_cobrado');
            $consultasTotales = 0; // Lo dejamos en 0 mientras creamos el módulo

            // D. Stock Bajo (Medicamentos que están por terminarse)
            // $nuevosExpedientes = Medicamento::where('cantidad', '<', 10)->count();
            $nuevosExpedientes = 0; // Lo dejamos en 0 mientras creamos el módulo
        }

        // ========================================================
        // 3. ENVIAR A LA VISTA
        // ========================================================
        return view('home')->with([
            'data'              => $nombre,
            'citasHoy'          => $citasHoy,          // El admin recibe esto vacío, el médico recibe su lista
            'citasPendientes'   => $citasPendientes,   // Admin: Total Clínica | Médico: Sus pendientes
            'pacientesHoy'      => $pacientesHoy,      // Admin: Total Clínica | Médico: Su carga laboral
            'consultasTotales'  => $consultasTotales,  // Admin: Ventas $      | Médico: Su historial
            'nuevosExpedientes' => $nuevosExpedientes  // Admin: Alertas Stock | Médico: Crecimiento
        ]);
    }
}
