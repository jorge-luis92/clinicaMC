<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use App\Models\Medicamento\Medicamento;
use App\Models\Medico\Medico;
use App\Models\Paciente\AntecendenteGO;
use App\Models\Paciente\ControlPrenatal;
use App\Models\Paciente\ExpedienteCP;
use App\Models\Paciente\ExpedienteInicio;
use App\Models\Paciente\Paciente;
use App\Models\Paciente\RecetaSeguimiento;
use App\Models\Paciente\Seguimiento;
use App\Models\Paciente\TipoConsulta;
use App\Models\Paciente\TipoSangre;
use App\Models\Persona\Persona;
use App\Models\Usuario\TipoUsuario;
use App\Models\Usuario\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use DateTime;

class ControlPrenatalController extends Controller
{
    public function index(Request $request)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;
        $id_persona = $usuario->id_persona;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

        if ($request->ajax()) {
            $data = ControlPrenatal::select(
                'control_prenatal.id',
                'control_prenatal.fecha',
                'control_prenatal.estatus',
                'paciente.id AS id_paciente',
                'expediente_cp.id AS id_expediente',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
                DB::raw('(CASE WHEN control_prenatal.estatus = "1" THEN "Gestando"  
                WHEN control_prenatal.estatus= "2" THEN "Embarazo Finalizado"
                WHEN control_prenatal.estatus= "0" THEN "NO SE LLEVO ACABO" END) AS estatus_c'),
            )
                ->join('paciente', 'paciente.id', 'control_prenatal.id_paciente')
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->join('expediente_cp', 'expediente_cp.id', 'control_prenatal.id_expediente')
                ->where('control_prenatal.id_medico', $medico->id)
                ->where('control_prenatal.estatus', '=', '1')
                ->orderBy('control_prenatal.fecha', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    if ($data->estatus == 1) {
                        $button = '&nbsp;
                        <button type="button" class="btn btn-warning btn-sm btn-glow mr-1 mb-1 dropdown-toggle"
                        data-toggle="dropdown">
                        <i class="fas fa-list"></i> Opciones
                        </button>
                        <ul class="dropdown-menu">
                        <li>&nbsp;&nbsp;<button type="button" name="' . $data->id_expediente . '" id="' . $data->id . '" class="exp_emb btn btn-warning btn-sm btn-glow mr-1 mb-1"><i class="fa fa-history fa-1x"></i> Seguimiento</button></li>
                        <li>&nbsp;&nbsp;<button type="button" name="' . $data->id_expediente . '" id="' . $data->id . '" class="ver_antecedente btn btn-primary btn-sm btn-glow mr-1 mb-1"><i class="fa fa-envelope-open"></i> Datos Inicio</button></li>
                        <li>&nbsp;&nbsp;<button type="button" name="' . $data->id_expediente . '" id="' . $data->id . '" class="finalizar_cp btn btn-danger btn-sm btn-glow mr-1 mb-1"><i class="fas fa-save fa-1x"></i> Finalizar</button></li>
                        </ul>
                         </div>';
                        return $button;
                    }
                })
                ->rawColumns(['accion'])
                ->editColumn('fecha', function (ControlPrenatal $dat) {
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
        return view('ControlEmbarazadas.listado')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre)
            ->with('med', $medicamentos);
    }

    public function select_embarazada(Request $request)
    {

        if ($request->ajax()) {
            $data = Paciente::select(
                'paciente.id',
                'paciente.celular',
                'tipo_sangre.tipo',
                'persona.edad',
                'persona.nombre',
                'persona.ap_paterno',
                'persona.ap_materno',
                'persona.fecha_nacimiento',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
            )
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->join('tipo_sangre', 'tipo_sangre.id', 'paciente.id_tiposangre')
                ->where('persona.genero', '=', 'M')
                ->where('persona.edad', '>=', '11')
                ->orderBy('persona.id', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="seleccionar_paciente btn btn-primary btn-min-width btn-glow mr-1 mb-1"> Seleccionar</button>';
                    /*$button = '&nbsp;<div class="btn-group">
                    <button type="button" class="btn btn-primary btn-min-width btn-glow mr-1 mb-1 dropdown-toggle"
                            data-toggle="dropdown">
                            <i class="fas fa-list"></i> Opciones
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                      <li><button type="button" name="del" id="'.$data->id.'" class="baja btn btn-danger btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-user-times fa-1x"></i> Eliminar</button></li>
                      <li><button type="button" name="del" id="'.$data->id.'" class="baja btn btn-danger btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-user-times fa-1x"></i> Detalles</button></li>
                    </ul>
                  </div>';*/
                    return $button;
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        $tipoConsulta = TipoConsulta::all();
        $tipoSangre = TipoSangre::all();
        return view('Paciente.General')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre);
    }

    public function regExp(Request $request)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;
        $id_persona = $usuario->id_persona;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

        $data = $request;

        $data->validate([
            'gesta' => 'required|numeric|min:0|not_in:-1',
            'parto' => 'required|numeric|min:0|not_in:-1',
            'cesarea' => 'required|numeric|min:0|not_in:-1',
            'aborto' => 'required|numeric|min:0|not_in:-1',
        ]);

        $id_paciente = $data->id_paciente;
        $id_medico = $medico->id;
        $gesta = $data->gesta;
        $parto = $data->parto;
        $cesarea = $data->cesarea;
        $aborto = $data->aborto;

        //return $data;

        /*ControlPrenatal::create([
            'id_paciente' => $id_paciente,
            'id_usuario' => $id_usuario,
            'id_medico' => $id_medico,
            'estatus' => '1',
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),
        ]);

        $le = ControlPrenatal::latest('id')->first();
        $id_exp = $le->id;*/

        ExpedienteCP::create([
            'id_paciente' => $id_paciente,
            'id_medico' => $id_medico,
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),
        ]);

        $le = ExpedienteCP::latest('id')->first();
        $id_exp = $le->id;

        $regAnt = AntecendenteGO::create([
            'id_expediente' => $id_exp,
            'id_paciente' => $id_paciente,
            'id_medico' => $id_medico,
            'gesta' => $gesta,
            'parto' => $parto,
            'cesarea' => $cesarea,
            'aborto' => $aborto,
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),
        ]);

        /*$regAnt = ExpedienteInicio::create([
            'id_expediente' => $id_exp,
            'id_paciente' => $id_paciente,
            'fur' => $fur,
            'fpp' => $fpp,
            'estudio_lab' => $estudio,
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),
        ]);*/

        if ($regAnt != '') {
            return response()->json('¡Se ha creado el expediente correctamente!, Un momento será redirigido al panel de Consultas', 200);
        }
    }

    public function data_ant($id)
    {
        $data = ExpedienteCP::select(
            'expediente_cp.fecha',
            'antecedentes_go.gesta',
            'antecedentes_go.parto',
            'antecedentes_go.cesarea',
            'antecedentes_go.aborto',
            'persona.fecha_nacimiento',
            'expediente_inicio.fur',
            'expediente_inicio.fpp',
            'expediente_inicio.estudio_lab',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
        )
            ->join('antecedentes_go', 'antecedentes_go.id_expediente', 'expediente_cp.id')
            ->join('paciente', 'paciente.id', 'expediente_cp.id_paciente')
            ->join('persona', 'persona.id', 'paciente.id_persona')
            ->join('expediente_inicio', 'expediente_inicio.id_expediente', 'expediente_cp.id')
            ->where('antecedentes_go.id_expediente', $id)
            ->first();

        return $data;
    }

    public function data_antdos($id)
    {
        $data = ExpedienteCP::select(
            'expediente_cp.fecha',
            'antecedentes_go.gesta',
            'antecedentes_go.parto',
            'antecedentes_go.cesarea',
            'antecedentes_go.aborto',
            'persona.fecha_nacimiento',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
        )
            ->join('antecedentes_go', 'antecedentes_go.id_expediente', 'expediente_cp.id')
            ->join('paciente', 'paciente.id', 'expediente_cp.id_paciente')
            ->join('persona', 'persona.id', 'paciente.id_persona')
            ->where('antecedentes_go.id_expediente', $id)
            ->first();

        return $data;
    }

    public function expediente_CE_pa(Request $request, $id)
    {
        $id_exp = $id;
        if ($request->ajax()) {
            $data = Seguimiento::select(
                'seguimiento.id',
                'seguimiento.exploracion_fisica',
                'seguimiento.semana_gesta',
                'seguimiento.peso',
                'seguimiento.fondo_uterino',
                'seguimiento.fecha',
                'seguimiento.id_expediente',
            )
                ->where('seguimiento.id_expediente', $id_exp)
                ->orderBy('seguimiento.fecha', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {

                    $button = '&nbsp;<div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm btn-glow mr-1 mb-1 dropdown-toggle"
                            data-toggle="dropdown">
                            <i class="fas fa-list"></i> Opciones
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                    <li>&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="ver_detalles btn btn-success btn-sm btn-glow mr-1 mb-1"><i class="fa fa-list"></i> Detalles</button></li>
                      <li>&nbsp;<button type="button" name="' . $data->id_expediente . '" id="' . $data->id . '" class="receta_medica btn btn-warning btn-sm btn-glow mr-1 mb-1"><i class="fas fa-prescription-bottle fa-1x"></i> Medicamentos</button></li>
                      <li>&nbsp;<button type="button" name="del" id="' . $data->id . '" class="imprimir_seguimiento btn btn-secondary btn-sm btn-glow mr-1 mb-1"><i class="fas fa-print fa-1x"></i> Imprimir</button></li>
                    </ul>
                  </div>';
                    return $button;
                })
                ->rawColumns(['accion']) 
                ->editColumn('fecha', function (Seguimiento $data) {
                    return date('d/m/Y', strtotime($data->fecha));
                })
                ->make(true);
        }

        return view('Expedientes.ListadoExpedienteGeneral');
    }

    public function regConEmb(Request $request)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;
        $id_persona = $usuario->id_persona;
        $data = $request;
        $id_exp = $data->id_exp;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

        $paciente = ControlPrenatal::select('id_paciente')
            ->where('id', $id_exp)
            ->first();

        $data->validate([
            'peso' => 'required|numeric|min:0|not_in:-1',
            'semana_gesta' => 'required|numeric|min:0|not_in:-1',
            'exploracion_fisica' =>  ['required', 'string', 'max:255'],
            'presentacion' =>  ['required', 'string', 'max:255'],
            'tension_arterial' =>  ['required', 'string', 'max:255'],
            'frecuencia_cardiaca' =>  ['required', 'string', 'max:255'],
            'fondo_uterino' =>  ['required', 'string', 'max:255'],
            'movimiento_fetal' =>  ['required', 'string', 'max:255'],
            'padecimiento' =>  ['required', 'string', 'max:255'],
        ]);

        if ($data->padecimiento == "Si") {
            $data->validate([
                'padecimiento_actual' =>  ['required', 'string', 'max:255'],
            ]);
        }

        $id_medico = $medico->id;
        $id_paciente = $paciente->id_paciente;
        $peso = $data->peso;
        $semana_gesta = $data->semana_gesta;
        $exploracion_fisica = $data->exploracion_fisica;
        $presentacion = $data->presentacion;
        $tension_arterial = $data->tension_arterial;
        $frecuencia_cardiaca = $data->frecuencia_cardiaca;
        $fondo_uterino = $data->fondo_uterino;
        $movimiento_fetal = $data->movimiento_fetal;
        $observaciones = $data->recomendaciones;
        $padecimiento_actual = $data->padecimiento_actual;
        $procedimiento_realizado = $data->procedimiento_realizado;

        //return $data;

        $seg = Seguimiento::create([
            'id_expediente' => $id_exp,
            'id_paciente' => $id_paciente,
            'id_medico' => $id_medico,
            'exploracion_fisica' => $exploracion_fisica,
            'semana_gesta' => $semana_gesta,
            'peso' => $peso,
            'ta' => $tension_arterial,
            'fondo_uterino' => $fondo_uterino,
            'presentacion' => $presentacion,
            'frecuencia_cardiaca' => $frecuencia_cardiaca,
            'otro' => $movimiento_fetal,
            'estatus' => '1',
            'padecimiento' => $padecimiento_actual,
            'procedimiento' => $procedimiento_realizado,
            'observaciones' => $observaciones,
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),
        ]);

        $le = ControlPrenatal::latest('id')->first();
        $id_exp = $le->id;

        if ($seg != '') {
            return response()->json('Seguimiento creado correctamente', 200);
        }
    }

    public function data_existe($id)
    {
        $data = ControlPrenatal::select('control_prenatal.id')
            ->where('control_prenatal.id_paciente', $id)
            ->where('estatus', '=', '1')
            ->first();

        return $data;
    }

    public function data_ante($id)
    {
        $data = AntecendenteGO::select(
            'antecedentes_go.gesta',
            'antecedentes_go.parto',
            'antecedentes_go.cesarea',
            'antecedentes_go.aborto',
        )
            ->where('antecedentes_go.id_paciente', $id)
            ->first();

        return $data;
    }

    public function index_expCP(Request $request)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;
        $id_persona = $usuario->id_persona;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

        if ($request->ajax()) {
            $data = ExpedienteCP::select(
                'expediente_cp.id',
                'expediente_cp.fecha',
                //'control_prenatal.id AS id_control',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
            )
                ->join('paciente', 'paciente.id', 'expediente_cp.id_paciente')
                ->join('persona', 'persona.id', 'paciente.id_persona')
                //->join('control_prenatal', 'control_prenatal.id_expediente', 'expediente_cp.id')
                ->where('expediente_cp.id_medico', $medico->id)
                ->orderBy('expediente_cp.fecha', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    $button = '&nbsp;
                        <button type="button" class="btn btn-warning btn-xs btn-glow mr-1 mb-1 dropdown-toggle"
                        data-toggle="dropdown">
                        <i class="fas fa-list"></i> Opciones
                        </button>
                        <ul class="dropdown-menu">
                        <li>&nbsp;&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="exp_emb btn btn-primary btn-min-width btn-glow mr-1 mb-1"><i class="fa fa-history fa-1x"></i> Historial</button></li>     
                        <li>&nbsp;&nbsp;<button type="button" name="name" id="' . $data->id . '" class="ver_antecedente btn btn-warning btn-min-width btn-glow mr-1 mb-1"><i class="fa fa-envelope-open"></i> Antecedentes GO</button></li>
                        </ul>
                         </div>';
                    return $button;
                })
                ->rawColumns(['accion'])
                ->editColumn('fecha', function (ExpedienteCP $dat) {
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
        return view('Expedientes.ListadoExpedienteEmbarazadas')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre)
            ->with('med', $medicamentos);
    }

    public function endCP(Request $request)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;
        $id_persona = $usuario->id_persona;
        $data = $request;
        $id_exp = $data->id_exp;

        return $data;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

        $paciente = ControlPrenatal::select('id_paciente')
            ->where('id', $id_exp)
            ->first();

        $data->validate([
            'peso' => 'required|numeric|min:0|not_in:-1',
            'semana_gesta' => 'required|numeric|min:0|not_in:-1',
            'exploracion_fisica' =>  ['required', 'string', 'max:255'],
            'presentacion' =>  ['required', 'string', 'max:255'],
            'tension_arterial' =>  ['required', 'string', 'max:255'],
            'frecuencia_cardiaca' =>  ['required', 'string', 'max:255'],
            'fondo_uterino' =>  ['required', 'string', 'max:255'],
            'otro' =>  ['required', 'string', 'max:255'],
        ]);

        $id_medico = $medico->id;
        $id_paciente = $paciente->id_paciente;
        $peso = $data->peso;
        $semana_gesta = $data->semana_gesta;
        $exploracion_fisica = $data->exploracion_fisica;
        $presentacion = $data->presentacion;
        $tension_arterial = $data->tension_arterial;
        $frecuencia_cardiaca = $data->frecuencia_cardiaca;
        $fondo_uterino = $data->fondo_uterino;
        $otro = $data->otro;
        $observaciones = $data->observaciones;

        //return $data;

        $seg = Seguimiento::create([
            'id_expediente' => $id_exp,
            'id_paciente' => $id_paciente,
            'id_medico' => $id_medico,
            'exploracion_fisica' => $exploracion_fisica,
            'semana_gesta' => $semana_gesta,
            'peso' => $peso,
            'ta' => $tension_arterial,
            'fondo_uterino' => $fondo_uterino,
            'presentacion' => $presentacion,
            'frecuencia_cardiaca' => $frecuencia_cardiaca,
            'otro' => $otro,
            'estatus' => '1',
            'observaciones' => $observaciones,
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),
        ]);

        $le = ControlPrenatal::latest('id')->first();
        $id_exp = $le->id;

        if ($seg != '') {
            return response()->json('Seguimiento creado correctamente', 200);
        }
    }

    public function expediente_existe($id)
    {
        $id_paciente = $id;
        $data = ExpedienteCP::select('expediente_cp.id')
            ->where('expediente_cp.id_paciente', $id_paciente)
            ->first();

        return $data;
    }

    public function edit_antgo(Request $request)
    {
        $usuario = auth()->user();
        $data = $request;
        $id_exp = $data->id;

        $data->validate([
            'gesta' => 'required|numeric|min:0|not_in:-1',
            'parto' => 'required|numeric|min:0|not_in:-1',
            'cesarea' => 'required|numeric|min:0|not_in:-1',
            'aborto' =>  'required|numeric|min:0|not_in:-1',
        ]);


        $gesta = $data->gesta;
        $parto = $data->parto;
        $cesarea = $data->cesarea;
        $aborto = $data->aborto;

        $updateAntGO = AntecendenteGO::where('id_expediente', $id_exp)->update([
            'gesta' => $gesta,
            'parto' => $parto,
            'cesarea' => $cesarea,
            'aborto' => $aborto,
        ]);


        if ($updateAntGO != '') {
            return response()->json('Se han actualizado correctamente los antecedentes ginecoobstréticos', 200);
        }
    }

    public function index_expCPd(Request $request)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;
        $id_persona = $usuario->id_persona;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

        if ($request->ajax()) {
            $data = ExpedienteCP::select(
                'expediente_cp.id',
                'expediente_cp.fecha',
                'persona.fecha_nacimiento',
                'paciente.id AS id_paciente',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
            )
                ->join('paciente', 'paciente.id', 'expediente_cp.id_paciente')
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->where('expediente_cp.id_medico', $medico->id)
                ->orderBy('expediente_cp.fecha', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    $button = '<button type="button" name="' . $data->id_paciente . '" id="' . $data->id . '" class="seleccionar_paciente btn btn-primary btn-sm btn-glow mr-1 mb-1"><i class="fa fa-check fa-1x"></i> Seleccionar</button>';
                    return $button;
                })
                ->rawColumns(['accion'])
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
        return view('ControlEmbarazadas.Listado')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre)
            ->with('med', $medicamentos);
    }

    public function regControl(Request $request)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;
        $id_persona = $usuario->id_persona;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

        $data = $request;

        $data->validate([
            'fum' => 'required',
            'fpp' => 'required',
            'estudio_laboratorio' => 'required',
            //'tipo_consulta' => ['required', 'string', 'max:255'],
        ]);

        $id_paciente = $data->id_paciente;
        $id_expediente = $data->id_expediente;
        $id_medico = $medico->id;
        $fum = $data->fum;
        $fpp = $data->fpp;
        $estudio_laboratorio = $data->estudio_laboratorio;
        $con = 0;

        $contador = ControlPrenatal::where('id_expediente', $id_expediente)
            ->where('id_paciente', $id_paciente)
            ->where('estatus', '=', '2')
            ->count();

        $con += 1;

        //return $contador;

        ControlPrenatal::create([
            'id_expediente' => $id_expediente,
            'id_paciente' => $id_paciente,
            'id_usuario' => $id_usuario,
            'id_medico' => $id_medico,
            'registro' => $con,
            'estatus' => '1',
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),
        ]);

        $le = ControlPrenatal::latest('id')->first();
        $id_exp = $le->id;

        $regAnt = ExpedienteInicio::create([
            'id_expediente' => $id_expediente,
            'id_paciente' => $id_paciente,
            'id_control' => $id_exp,
            'fur' => $fum,
            'fpp' => $fpp,
            'estudio_lab' => $estudio_laboratorio,
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),
        ]);

        if ($regAnt != '') {
            return response()->json('¡Se ha creado el expediente correctamente!, Un momento será redirigido al panel de Consultas', 200);
        }
    }

    public function calcular_fpp($fecha)
    {
        $fecha_c = $fecha;
        $suma = 280;
        $fecha = date("Y-m-d", strtotime($fecha_c . "+ " . $suma . " days"));
        return $fecha;
    }

    public function index_exp(Request $request)
    {
        $usuario = auth()->user();
        $id_usuario = $usuario->id;
        $id_persona = $usuario->id_persona;

        $medico = Medico::select('id')
            ->where('id_persona', $id_persona)
            ->first();

        if ($request->ajax()) {
            $data = ControlPrenatal::select(
                'control_prenatal.id',
                'control_prenatal.fecha',
                'control_prenatal.estatus',
                'paciente.id AS id_paciente',
                'expediente_cp.id AS id_expediente',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
                DB::raw('(CASE WHEN control_prenatal.estatus = "1" THEN "Gestando"  
                WHEN control_prenatal.estatus= "2" THEN "Embarazo Finalizado"
                WHEN control_prenatal.estatus= "0" THEN "NO SE LLEVO ACABO" END) AS estatus_c'),
            )
                ->join('paciente', 'paciente.id', 'control_prenatal.id_paciente')
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->join('expediente_cp', 'expediente_cp.id', 'control_prenatal.id_expediente')
                ->where('control_prenatal.id_medico', $medico->id)
                ->where('control_prenatal.estatus', '=', '2')
                ->orderBy('control_prenatal.fecha', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    $button = '&nbsp;<button type="button" name="' . $data->id_expediente . '" id="' . $data->id . '" class="exp_emb btn btn-success btn-min-width btn-glow mr-1 mb-1"><i class="fa fa-history fa-1x"></i> Historial</button>';
                    return $button;
                })
                ->rawColumns(['accion'])
                ->editColumn('fecha', function (ControlPrenatal $dat) {
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
        return view('ControlEmbarazadas.listado')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre)
            ->with('med', $medicamentos);
    }

    public function data_expEmb(Request $request, $id)
    {
        $id_expediente = $id;
        if ($request->ajax()) {
            $data = ControlPrenatal::select(
                'control_prenatal.id',
                'control_prenatal.fecha',
                'control_prenatal.estatus',
                'paciente.id AS id_paciente',
                'expediente_cp.id AS id_expediente',
                'control_prenatal.registro',
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
                DB::raw('(CASE WHEN control_prenatal.estatus = "1" THEN "Gestando"  
                WHEN control_prenatal.estatus= "2" THEN "Embarazo Finalizado"
                WHEN control_prenatal.estatus= "0" THEN "NO SE LLEVO ACABO" END) AS estatus_c'),
            )
                ->join('paciente', 'paciente.id', 'control_prenatal.id_paciente')
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->join('expediente_cp', 'expediente_cp.id', 'control_prenatal.id_expediente')
                ->where('control_prenatal.id_expediente', $id_expediente)
                ->where('control_prenatal.estatus', '=', '2')
                ->orderBy('control_prenatal.fecha', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    if ($data->estatus == 2) {
                        $button = '&nbsp;<button type="button" name="' . $data->id_expediente . '" id="' . $data->id . '" class="exp_emba btn btn-warning btn-sm btn-glow mr-1 mb-1"><i class="fa fa-history fa-1x"></i> Seguimiento</button>';
                        return $button;
                    }
                })
                ->rawColumns(['accion'])
                ->editColumn('fecha', function (ControlPrenatal $dat) {
                    return date('d/m/Y', strtotime($dat->fecha));
                })
                ->make(true);
            return $data;
        }
    }

    public function detalles_seguimiento($id)
    {
        $id_seg = $id;
        $data = Seguimiento::select(
            'seguimiento.id',
            'seguimiento.exploracion_fisica',
            'seguimiento.semana_gesta',
            'seguimiento.peso',
            'seguimiento.ta',
            'seguimiento.fondo_uterino',
            'seguimiento.presentacion',
            'seguimiento.frecuencia_cardiaca',
            'seguimiento.otro',
            'seguimiento.padecimiento',
            'seguimiento.procedimiento',
            'seguimiento.observaciones',
            'seguimiento.fecha',
            DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
        )
            ->join('paciente', 'paciente.id', 'seguimiento.id_paciente')
            ->join('persona', 'persona.id', 'paciente.id_persona')
            ->where('seguimiento.id', $id_seg)
            ->first();

        return $data;
    }

    public function med_pacienteRecSeg(Request $request, $id, $id2)
    {
        $id_control = $id;
        $id_seguimiento = $id2;

        if ($request->ajax()) {
            $data = RecetaSeguimiento::select(
                'receta_seguimiento.id',
                'receta_seguimiento.cantidad',
                'receta_seguimiento.tratamiento',
                DB::raw("CONCAT(medicamento.clave,' ',medicamento.nombre,' ',medicamento.presentacion) AS descripcion"),
            )
                ->join('control_prenatal', 'control_prenatal.id', 'receta_seguimiento.id_control')
                ->join('medicamento', 'medicamento.id', 'receta_seguimiento.id_medicamento')
                ->where('receta_seguimiento.id_seguimiento', $id_seguimiento)
                ->where('receta_seguimiento.id_control', $id_control)
                ->orderBy('receta_seguimiento.id', 'desc')
                ->get();

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="delete_medicamento btn btn-danger btn-sm btn-glow mr-1 mb-1"><i class="fas fa-trash"></i> Eliminar</button>';
                    return $button;
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        return view('ControlEmbarazadas.Listado');
    }

    public function delete_medicamentoSeg($id){

        $id_registro = $id;

        $deleted = RecetaSeguimiento::where('id', $id_registro)->delete();

        if ($deleted != '') {
            return response()->json('Medicamento eliminado correctamente', 200);
        } else {
            return response()->json('Error: Sin cambios', 442);
        }
    }
}
