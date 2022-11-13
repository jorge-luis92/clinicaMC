<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use App\Mail\RecetaMedica as MailRecetaMedica;
use App\Models\Medicamento\Medicamento;
use App\Models\Medico\Medico;
use App\Models\Paciente\Cita;
use App\Models\Paciente\ConsultaGeneral;
use App\Models\Paciente\ExpedienteCG;
use App\Models\Paciente\Paciente;
use App\Models\Paciente\RecetaMedica;
use App\Models\Paciente\TipoConsulta;
use App\Models\Paciente\TipoSangre;
use App\Models\Persona\Persona;
use App\Models\Usuario\TipoUsuario;
use App\Models\Usuario\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Laravel\Facades\Telegram;
use PDF;
//use Mail;

class ConsultaGeneralController extends Controller
{
    public function index(Request $request)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        if ($request->ajax()) {
            $data = ConsultaGeneral::select(
                'consulta_general.id',
                'consulta_general.diagnostico',
                'consulta_general.fecha',
                'persona.nombre',
                'persona.ap_paterno',
                'persona.ap_materno',
                'consulta_general.estatus',
                'paciente.correo',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
                DB::raw('(CASE WHEN consulta_general.estatus = "1" THEN "En Proceso"  
                WHEN consulta_general.estatus= "2" THEN "Por Finalizar"
                WHEN consulta_general.estatus= "3" THEN "FInalizada"
                WHEN consulta_general.estatus= "0" THEN "NO SE LLEVO ACABO" END) AS estatus_c'),
            )
                ->join('paciente', 'paciente.id', 'consulta_general.id_paciente')
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->where('consulta_general.id_usuario', $id_usuario)
                ->orderBy('consulta_general.fecha', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    if ($data->estatus == 1) {
                        $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="editar_consulta btn btn-primary btn-xs btn-glow mr-1 mb-1"><i class="fa fa-list"></i> Notas</button>';
                        return $button;
                    }
                    if ($data->estatus == 2) {
                        $button = '&nbsp;
                        <button type="button" class="btn btn-warning btn-xs btn-glow mr-1 mb-1 dropdown-toggle"
                        data-toggle="dropdown">
                        <i class="fas fa-list"></i> Opciones
                        </button>
                        <ul class="dropdown-menu">
                        <li>&nbsp;&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="receta_medica btn btn-primary btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-prescription-bottle fa-1x"></i> Receta Médica</button></li>
                        <li>&nbsp;&nbsp;<button type="button" name="del" id="' . $data->id . '" class="finalizar_consulta btn btn-danger btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-save fa-1x"></i> Finalizar</button></li>
                        </ul>
                         </div>';
                        return $button;
                    }
                    if ($data->estatus == 3) {

                        $button = '&nbsp;
                        <button type="button" class="btn btn-warning btn-xs btn-glow mr-1 mb-1 dropdown-toggle"
                        data-toggle="dropdown">
                        <i class="fas fa-list"></i> Ver
                        </button>
                        <ul class="dropdown-menu">
                        <li>&nbsp;&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="ver_pdf btn btn-secondary btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-print fa-1x"></i> Imprimir</button></li>
                        <li>&nbsp;&nbsp;<button type="button" name="del" id="' . $data->id . '" class="detalles_consulta btn btn-primary btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-list fa-1x"></i> Detalles</button></li>
                        <li>&nbsp;&nbsp;<button type="button" name="' . $data->correo . '" id="' . $data->id . '" class="enviar_email btn btn-success btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-email fa-1x"></i> Enviar Receta por Correo</button></li>
                        </ul>
                         </div>';
                        return $button;
                    }
                    if ($data->estatus == 0) {
                        $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="ver_cancelacion btn btn-primary btn-xs btn-glow mr-1 mb-1"><i class="fa fa-list"></i> Ver</button>';
                        return $button;
                    }
                })
                ->rawColumns(['accion'])
                ->editColumn('fecha', function (ConsultaGeneral $dat) {
                    return date('d/m/Y', strtotime($dat->fecha));
                })
                ->make(true);
        }

        $tipoConsulta = TipoConsulta::all();
        $tipoSangre = TipoSangre::all();
        $medicamentos = Medicamento::select(
            'medicamento.id',
            'medicamento.activo',
            'stock_medicamento.cantidad',
            'medicamento.precio_venta',
            'medicamento.fecha_cad',
            DB::raw("CONCAT(medicamento.nombre,' ',medicamento.presentacion) AS descripcion"),
            //DB::raw("CONCAT('Fecha Caducidad: ',medicamento.fecha_cad) AS caducidad"),
        )
            ->join('stock_medicamento', 'stock_medicamento.id_medicamento', 'medicamento.id')
            ->where('medicamento.activo', '=', '1')
            ->orderBy('medicamento.nombre', 'asc')
            ->get();

        return view('ConsultaGeneral.listado')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre)
            ->with('med', $medicamentos);
    }

    public function create_expediente(Request $data)
    {

        $usuario = auth()->user();
        $id_usuario = $usuario->id;
        $id_persona = $usuario->id_persona;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

        $id_paciente = $data->id;
        $id_medico = $medico->id;

        if ($usuario->tipo_usuario == 2) {
            $datos_medico = Medico::select('id')
                ->where('id_persona', $usuario->id_persona)
                ->first();
        } else {
            return response()->json('Error: Usuario no Identificado como Médico, Favor de Validar', 442);
        }

        $busqueda_exp = ExpedienteCG::where('id_paciente', $id_paciente)->first();

        if ($busqueda_exp) {
            return response()->json('Existe un expediente ya creado con el paciente que seleccionó.', 442);
        }

        $registrarC = ExpedienteCG::create([
            'id_paciente' => $id_paciente,
            'id_medico' => $id_medico,
            'estatus' => '1',
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),

        ]);

        if ($registrarC != '') {
            return response()->json('¡Se ha creado el expediente correctamente!, Un momento será redirigido al panel de Consultas', 200);
        }
    }

    public function create_consulta(Request $data)
    {

        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        //return $data;
        $data->validate([
            'tipo_consulta' => ['required', 'string', 'max:255'],
        ]);

        $id_paciente = $data->id;
        $id_expediente = $data->id_expediente;
        $tipo_consulta = $data->tipo_consulta;
        if ($usuario->tipo_usuario == 2) {
            $datos_medico = Medico::select('id')
                ->where('id_persona', $usuario->id_persona)
                ->first();
        } else {
            return response()->json('Error: Usuario no Identificado como Médico, Favor de Validar', 442);
        }

        $registrarC = ConsultaGeneral::create([
            'id_expediente' => $id_expediente,
            'id_paciente' => $id_paciente,
            'id_tipoconsulta' => $tipo_consulta,
            'id_usuario' => $id_usuario,
            'id_medico' => $datos_medico->id,
            'estatus' => '1',
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),

        ]);

        if ($registrarC != '') {
            return response()->json('Se ha creado la Consulta', 200);
        }
    }

    public function data_consultag($id)
    {
        $data = ConsultaGeneral::select(
            'persona.edad',
            'tipo_sangre.tipo',
            'tipo_consulta.nombre AS tipo_consulta',
            'tipo_sangre.tipo AS tipo_sangre',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
        )
            ->join('paciente', 'paciente.id', 'consulta_general.id_paciente')
            ->join('tipo_consulta', 'tipo_consulta.id', 'consulta_general.id_tipoconsulta')
            ->join('persona', 'persona.id', 'paciente.id_persona')
            ->join('tipo_sangre', 'tipo_sangre.id', 'paciente.id_tiposangre')
            ->where('consulta_general.id', $id)
            ->first();

        return $data;
    }

    public function save_EditConsulta(Request $v)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        $data = $v;
        $id = $data->id;
        $peso = $data->peso;
        $temperatura = $data->temperatura;
        $diagnostico = $data->diagnostico;
        $ta = $data->ta_c;
        $glucosa = $data->glucosa;
        $motivo_consulta = $data->motivo_consulta;
        $exploracion = $data->exploracion;

        $data->validate([
            'peso' => 'required|numeric|min:1|not_in:-1',
            'temperatura' => 'required|numeric|min:30|not_in:-1',
            'diagnostico' => ['required', 'string', 'max:255'],
            'motivo_consulta' => ['required', 'string', 'max:255'],
            'exploracion' => ['required', 'string', 'max:255'],
            'realiza_procedimiento' => ['required', 'string', 'max:255'],
        ]);

        $proce= $data->realiza_procedimiento;
        $procedimiento= $data->procedimiento;

        if($proce == "Si"){
            $data->validate([
                'procedimiento' => ['required', 'string', 'max:255'],
            ]);
        }

        $updateC = ConsultaGeneral::where('id', $id)->update([
            'temperatura' => $temperatura,
            'peso' => $peso,
            'diagnostico' => $diagnostico,
            'estatus' => '2',
            'motivo_consulta' => $motivo_consulta,
            'examen_fisico' => $exploracion,
            'ta' => $ta,
            'glucosa' => $glucosa,
            'procedimiento' => $procedimiento,
        ]);

        if ($updateC != '') {
            return response()->json('Diagnóstico guardado Correctamente', 200);
        } else {
            return response()->json('Error: Sin cambios', 500);
        }
    }

    public function expediente_CG(Request $request)
    {
        $usuario = auth()->user();
        $id_persona = $usuario->id_persona;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

        $id_medico = $medico->id;

        if ($request->ajax()) {
            $data = ExpedienteCG::select(
                'expediente_cg.id',
                'paciente.id AS id_paciente',
                'paciente.celular',
                'tipo_sangre.tipo',
                'persona.edad',
                'persona.fecha_nacimiento',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
            )
                ->join('paciente', 'paciente.id', 'expediente_cg.id_paciente')
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->join('tipo_sangre', 'tipo_sangre.id', 'paciente.id_tiposangre')
                ->where('expediente_cg.id_medico', $id_medico)
                ->orderBy('persona.nombre', 'asc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    $button = '&nbsp;<button type="button" name="' . $data->id_paciente . '" id="' . $data->id . '" class="expediente_paciente btn btn-success btn-sm btn-glow mr-1 mb-1"><i class="fa fa-history"></i></i> Historial</button>';

                    return $button;
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        $tipoConsulta = TipoConsulta::all();
        $tipoSangre = TipoSangre::all();
        return view('Expedientes.ListadoExpedienteGeneral')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre);
    }

    public function expediente_CG_pa(Request $request, $id, $id2)
    {
        $id_paciente = $id;
        $id_expediente = $id2;
        if ($request->ajax()) {
            $data = ConsultaGeneral::select(
                'consulta_general.id',
                'consulta_general.diagnostico',
                'consulta_general.fecha',
                'persona.nombre',
                'persona.ap_paterno',
                'persona.ap_materno',
                'consulta_general.estatus',
                'consulta_general.motivo_consulta',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
                DB::raw('(CASE WHEN consulta_general.estatus = "1" THEN "Proceso"  
                WHEN consulta_general.estatus= "3" THEN "FInalizada"
                WHEN consulta_general.estatus= "0" THEN "NO SE LLEVO ACABO" END) AS estatus_c'),
            )
                ->join('paciente', 'paciente.id', 'consulta_general.id_paciente')
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->join('expediente_cg', 'expediente_cg.id', 'consulta_general.id_expediente')
                ->where('paciente.id', $id_paciente)
                ->where('consulta_general.id_expediente', $id_expediente)
                ->where('consulta_general.estatus',  '3')
                ->orderBy('consulta_general.fecha', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="detalles_consulta btn btn-success btn-xs btn-glow mr-1 mb-1"><i class="fa fa-list"></i> Detalles</button>';
                    return $button;
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        return view('Expedientes.ListadoExpedienteGeneral');
    }

    public function med_pacienteRec(Request $request, $id)
    {
        $id_consulta = $id;
        if ($request->ajax()) {
            $data = RecetaMedica::select(
                'receta_medica.id',
                'receta_medica.cantidad',
                'receta_medica.tratamiento',
                DB::raw("CONCAT(medicamento.clave,' ',medicamento.nombre,' ',medicamento.presentacion) AS descripcion"),
            )
                ->join('consulta_general', 'consulta_general.id', 'receta_medica.id_consulta')
                ->join('medicamento', 'medicamento.id', 'receta_medica.id_medicamento')
                ->where('consulta_general.id', $id_consulta)
                ->orderBy('receta_medica.id', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {

                    /* $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="delete_medicamento btn btn-danger btn-xs btn-glow mr-1 mb-1"><i class="fas fa-trash"></i> Eliminar</button>';
                    return $button;*/

                    $button = '&nbsp;
                        <button type="button" class="btn btn-primary btn-xs btn-glow mr-1 mb-1 dropdown-toggle"
                        data-toggle="dropdown">
                        <i class="fas fa-list"></i>
                        </button>
                        <ul class="dropdown-menu">
                        <li>&nbsp;&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="delete_medicamento btn btn-danger btn-xs btn-glow mr-1 mb-1"><i class="fas fa-trash"></i> Eliminar</button></li>
                        <li>&nbsp;&nbsp;<button type="button" name="del" id="' . $data->id . '" class="editar_tratamiento btn btn-warning btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-edit fa-1x"></i> Editar</button></li>
                        </ul>
                         </div>';
                    return $button;
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        return view('ConsultaGeneral.Listado');
    }

    public function vistapreviaC($id)
    {

        $usuario = auth()->user();
        $id_usuario = $usuario->id;
        $id_persona = $usuario->id_persona;
        $id_consulta = $id;

        $datos_medico = Medico::select(
            'medico.cedula',
            'medico.celular',
            'persona.genero',
            'medico.especialidad',
            'medico.institutos',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_p"),
            DB::raw('(CASE WHEN persona.genero = "H" THEN "Dr."  
            WHEN persona.genero= "M" THEN "Dra." END) AS doc')
        )
            ->join('persona', 'persona.id', 'medico.id_persona')
            ->where('medico.id_persona', $id_persona)
            ->first();

        $data = ConsultaGeneral::select(
            'consulta_general.id',
            'consulta_general.temperatura',
            'consulta_general.peso',
            'tipo_consulta.nombre',
            'consulta_general.fecha',
            'consulta_general.estatus',
            'paciente.talla',
            'consulta_general.glucosa',
            'consulta_general.fecha',
            'consulta_general.diagnostico',
            'persona.edad',
            'consulta_general.ta',
            'consulta_general.motivo_consulta',
            'consulta_general.examen_fisico',
            'consulta_general.observaciones',
            'consulta_general.procedimiento',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_p")
        )
            ->join('paciente', 'paciente.id', 'consulta_general.id_paciente')
            ->join('persona', 'persona.id', 'paciente.id_persona')
            ->join('tipo_consulta', 'tipo_consulta.id', 'consulta_general.id_tipoconsulta')
            ->where('consulta_general.id', $id_consulta)
            ->first();

        $data_medicamentos = RecetaMedica::select(
            'receta_medica.id',
            'receta_medica.cantidad',
            'receta_medica.tratamiento',
            DB::raw("CONCAT(medicamento.nombre,' ',medicamento.presentacion) AS descripcion"),
        )
            ->join('consulta_general', 'consulta_general.id', 'receta_medica.id_consulta')
            ->join('medicamento', 'medicamento.id', 'receta_medica.id_medicamento')
            ->where('consulta_general.id', $id_consulta)
            ->orderBy('receta_medica.id', 'desc')
            ->get();


        view()->share('data', $data);
        view()->share('medico', $datos_medico);
        view()->share('medicamentos', $data_medicamentos);
        $pdf = PDF::loadView('ConsultaGeneral.Vista_dos', array('medicamentos' => $data_medicamentos));
        //$pdf = PDF::loadView('ConsultaGeneral.vista2', array('medicamentos' => $data_medicamentos));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream();
    }

    public function verDataCon($id)
    {

        $id_consulta = $id;
        $data = ConsultaGeneral::select(
            'consulta_general.id',
            'consulta_general.temperatura',
            'consulta_general.diagnostico',
            'consulta_general.motivo_consulta',
            'consulta_general.peso',
            'consulta_general.fecha',
            'consulta_general.estatus',
            'paciente.talla',
            'consulta_general.fecha',
            'paciente.id AS id_paciente',
            'consulta_general.observaciones',
            'tipo_sangre.tipo',
            'consulta_general.glucosa',
            'consulta_general.ta',
            'consulta_general.examen_fisico',
            'tipo_consulta.nombre AS tipo_consulta',
            'persona.edad',
            'consulta_general.procedimiento',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_p")
        )
            ->join('paciente', 'paciente.id', 'consulta_general.id_paciente')
            ->join('persona', 'persona.id', 'paciente.id_persona')
            ->join('tipo_consulta', 'tipo_consulta.id', 'consulta_general.id_tipoconsulta')
            ->join('tipo_sangre', 'tipo_sangre.id', 'paciente.id_tiposangre')
            ->where('consulta_general.id', $id_consulta)
            ->first();

        return $data;
    }

    public function end_consultaGeneral(Request $v)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        $data = $v;
        $id = $data->id;
        $observaciones = $data->recomendaciones;

        $v->validate([
            'recomendaciones' => ['required', 'string', 'max:255'],
        ]);

        $updateC = ConsultaGeneral::where('id', $id)->update([
            'estatus' => '3',
            'observaciones' => $observaciones,
        ]);

        if ($updateC != '') {
            return response()->json('Se ha Finalizado la Consulta correctamente', 200);
        } else {
            return response()->json('Error: Sin cambios', 500);
        }
    }

    public function verDataPac($id)
    {

        $id_paciente = $id;
        $data = ConsultaGeneral::select(
            'consulta_general.id',
            'consulta_general.temperatura',
            'consulta_general.diagnostico',
            'consulta_general.motivo_consulta',
            'consulta_general.peso',
            'tipo_consulta.nombre',
            'consulta_general.fecha',
            'consulta_general.estatus',
            'paciente.talla',
            'consulta_general.fecha',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_p")
        )
            ->join('paciente', 'paciente.id', 'consulta_general.id_paciente')
            ->join('persona', 'persona.id', 'paciente.id_persona')
            ->join('tipo_consulta', 'tipo_consulta.id', 'consulta_general.id_tipoconsulta')
            ->join('expediente_cg', 'expediente_cg.id_paciente', 'consulta_general.id_paciente')
            ->where('consulta_general.id_paciente', $id_paciente)
            ->where('consulta_general.estatus', '=', '3')
            ->first();

        return $data;
    }

    public function enviarPdfcg(Request $v)
    {
        $usuario = auth()->user();
        $id_persona = $usuario->id_persona;

        $data = $v;
        //return $data;
        $correo = $data->email;
        $id_consulta = $data->id_con;

        $datos_medico = Medico::select(
            'medico.cedula',
            'medico.celular',
            'persona.genero',
            'medico.especialidad',
            'medico.institutos',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_p"),
            DB::raw('(CASE WHEN persona.genero = "H" THEN "Dr."  
            WHEN persona.genero= "M" THEN "Dra." END) AS doc')
        )
            ->join('persona', 'persona.id', 'medico.id_persona')
            ->where('medico.id_persona', $id_persona)
            ->first();

        $data = ConsultaGeneral::select(
            'consulta_general.id',
            'consulta_general.temperatura',
            'consulta_general.peso',
            'tipo_consulta.nombre',
            'consulta_general.fecha',
            'consulta_general.estatus',
            'paciente.talla',
            'consulta_general.glucosa',
            'consulta_general.fecha',
            'consulta_general.diagnostico',
            'persona.edad',
            'consulta_general.ta',
            'consulta_general.motivo_consulta',
            'consulta_general.examen_fisico',
            'consulta_general.observaciones',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_p")
        )
            ->join('paciente', 'paciente.id', 'consulta_general.id_paciente')
            ->join('persona', 'persona.id', 'paciente.id_persona')
            ->join('tipo_consulta', 'tipo_consulta.id', 'consulta_general.id_tipoconsulta')
            ->where('consulta_general.id', $id_consulta)
            ->first();

        $data_medicamentos = RecetaMedica::select(
            'receta_medica.id',
            'receta_medica.cantidad',
            'receta_medica.tratamiento',
            DB::raw("CONCAT(medicamento.nombre,' ',medicamento.presentacion) AS descripcion"),
        )
            ->join('consulta_general', 'consulta_general.id', 'receta_medica.id_consulta')
            ->join('medicamento', 'medicamento.id', 'receta_medica.id_medicamento')
            ->where('consulta_general.id', $id_consulta)
            ->orderBy('receta_medica.id', 'desc')
            ->get();


        view()->share('data', $data);
        view()->share('medico', $datos_medico);
        view()->share('medicamentos', $data_medicamentos);
        $pdf = PDF::loadView('ConsultaGeneral.Consulta_VistaPrevia', array('medicamentos' => $data_medicamentos));

        $data_paciente = ConsultaGeneral::select(
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c")
        )
            ->join('paciente', 'paciente.id', 'consulta_general.id_paciente')
            ->join('persona', 'persona.id', 'paciente.id_persona')
            ->where('consulta_general.id', $id_consulta)
            ->first();


        $mensaje = "Estimado (a): " . $data_paciente->nombre_c . " se adjunta en el correo el archivo PDF de su receta médica";

        $fecha = date('Y-m-d');
        $date = date('H:i:s');
        $fecha = date('d/m/Y', strtotime($fecha));
        $date = date('h:i A', strtotime($date));

        $mensaje2 = "Se ha enviado correctamente la receta medica al paciente: $data_paciente->nombre_c a las " . $date . " del " . $fecha . ".";

        $datos = array(
            'mensaje' => $mensaje
        );

        $npdf = $data_paciente->nombre_c . "_recetamedica.pdf";

        //return $correo;
        Mail::send('ConsultaGeneral.Email', $datos, function ($mail) use ($correo, $pdf, $npdf) {
            $mail->to($correo);
            $mail->subject('Receta Médica');
            $mail->attachData($pdf->output(), $npdf);
        });

        Telegram::sendMessage([
            'chat_id' => '-1001726685878',
            'parse_mode' => 'HTML',
            'text' =>  $mensaje2
        ]);

        return response()->json('Se ha enviado correctamente el archivo', 200);
    }

    public function expediente_selPaciente(Request $request)
    {
        $usuario = auth()->user();
        $id_persona = $usuario->id_persona;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

        $id_medico = $medico->id;

        if ($request->ajax()) {
            $data = ExpedienteCG::select(
                'expediente_cg.id',
                'paciente.id AS id_paciente',
                'paciente.celular',
                'tipo_sangre.tipo',
                'persona.edad',
                'persona.fecha_nacimiento',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
            )
                ->join('paciente', 'paciente.id', 'expediente_cg.id_paciente')
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->join('tipo_sangre', 'tipo_sangre.id', 'paciente.id_tiposangre')
                ->where('expediente_cg.id_medico', $id_medico)
                ->orderBy('persona.nombre', 'asc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    $button = '&nbsp;<button type="button" name="' . $data->id_paciente . '" id="' . $data->id . '" class="seleccionar_paciente btn btn-secondary btn-sm btn-glow mr-1 mb-1"><i class="fa fa-check"></i> Seleccionar</button>';

                    return $button;
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        $tipoConsulta = TipoConsulta::all();
        $tipoSangre = TipoSangre::all();
        return view('Expedientes.ListadoExpedienteGeneral')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre);
    }


}
