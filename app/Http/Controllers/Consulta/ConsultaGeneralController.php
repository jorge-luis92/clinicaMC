<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use App\Models\Medico\Medico;
use App\Models\Paciente\ConsultaGeneral;
use App\Models\Paciente\Paciente;
use App\Models\Paciente\TipoConsulta;
use App\Models\Paciente\TipoSangre;
use App\Models\Persona\Persona;
use App\Models\Usuario\TipoUsuario;
use App\Models\Usuario\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;

class ConsultaGeneralController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = ConsultaGeneral::select(
                'consulta_general.id',
                'consulta_general.diagnostico',
                'consulta_general.fecha',
                'persona.nombre',
                'persona.ap_paterno',
                'persona.ap_materno',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
                //DB::raw('(CASE WHEN users.activo = "1" THEN "Activo" WHEN users.activo= "0" THEN "Desactivado" END) AS estatus_u'),
            )
                ->join('paciente', 'paciente.id', 'consulta_general.id_paciente')
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->orderBy('consulta_general.fecha', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="editar btn btn-primary btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-user-edit fa-1x"></i> Detalles</button>';
                    //$button .= '&nbsp;<button type="button" name="del" id="'.$data->id.'" class="baja btn btn-danger btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-user-times fa-1x"></i> Eliminar</button>';
                    //$button .= '&nbsp;<button type="button" name="'.$data->id.'" id="'.$data->id.'" class="reset btn btn-success btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-user-lock fa-1x"></i> Reseteo</button>';

                    return $button;
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        $tipoConsulta = TipoConsulta::all();
        $tipoSangre = TipoSangre::all();
        return view('ConsultaGeneral.listado')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre);
    }

    public function regPaciente(Request $v)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        $nombre = $v->nombre;
        $ap_pat = $v->ap_pat;
        $ap_mat = $v->ap_mat;
        $usuario = $v->usuario;
        $fecha_nacimiento = $v->fecha_nacimiento;
        $edad= $v->edad;
        $tipo_sangre = $v->tipo_sangre;
        $celular = $v->celular;
        $email = $v->email;
        $contacto_emergencia = $v->contacto_emergencia;
        $genero = $v->genero;

        $v->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'ap_pat' => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['required', 'string', 'max:255'],
            'edad' => 'required|numeric|min:0|not_in:-1',
            'tipo_sangre' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        Persona::create([
            'nombre' => $nombre,
            'ap_paterno' => $ap_pat,
            'ap_materno' => $ap_mat,
            'edad' => $edad,
            'genero' => $genero,
            'fecha_nacimiento' => $fecha_nacimiento,
            'id_usuario' => $id_usuario,
            'fecha_registro' => date('Y-m-d'),
            'hora_registro' => date('H:i:s'),

        ]);

        $lp = Persona::latest('id')->first();

        $registrarP = Paciente::create([
            'id_persona' => $lp->id,
            'id_tiposangre' => $tipo_sangre,
            'celular' => $celular,
            'contacto_emergencia' => $contacto_emergencia,
            'correo' => $email,
            'id_usuario' => $id_usuario,
            'fecha_registro' => date('Y-m-d'),
            'hora_registro' => date('H:i:s'),
        ]);
        
        if ($registrarP != '') {
            return response()->json('Paciente creado satisfactoriamente', 200);
        }
    }
}
