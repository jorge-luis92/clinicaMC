<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use App\Models\Medicamento\Medicamento;
use App\Models\Medico\Medico;
use App\Models\Paciente\AntecendenteGO;
use App\Models\Paciente\ControlPrenatal;
use App\Models\Paciente\ExpedienteInicio;
use App\Models\Paciente\Paciente;
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
                DB::raw("CONCAT(persona.nombre,' ',persona.ap_paterno,' ',persona.ap_materno) AS nombre_c"),
                DB::raw('(CASE WHEN control_prenatal.estatus = "1" THEN "Gestando"  
                WHEN control_prenatal.estatus= "2" THEN "Embarazo Finalizado"
                WHEN control_prenatal.estatus= "0" THEN "NO SE LLEVO ACABO" END) AS estatus_c'),
            )
                ->join('paciente', 'paciente.id', 'control_prenatal.id_paciente')
                ->join('persona', 'persona.id', 'paciente.id_persona')
                ->where('control_prenatal.id_medico', $medico->id)
                ->where('control_prenatal.estatus', '=', '1')
                ->orderBy('control_prenatal.fecha', 'desc')
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
                    if ($data->estatus == 0) {
                        $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="ver_cancelacion btn btn-primary btn-xs btn-glow mr-1 mb-1"><i class="fa fa-list"></i> Ver</button>';
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
            'fur' =>  ['required', 'string', 'max:255'],
            'fpp' =>  ['required', 'string', 'max:255'],
        ]);

        $id_paciente = $data->id_paciente;
        $id_medico = $medico->id;
        $gesta = $data->gesta;
        $parto = $data->parto;
        $cesarea = $data->cesarea;
        $aborto = $data->aborto;
        $fur = $data->fur;
        $fpp = $data->fpp;
        $estudio = $data->estudio_laboratorio;

        //return $data;

        ControlPrenatal::create([
            'id_paciente' => $id_paciente,
            'id_usuario' => $id_usuario,
            'id_medico' => $id_medico,
            'estatus' => '1',
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),
        ]);

        $le = ControlPrenatal::latest('id')->first();
        $id_exp = $le->id;

        AntecendenteGO::create([
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

        $regAnt = ExpedienteInicio::create([
            'id_expediente' => $id_exp,
            'id_paciente' => $id_paciente,
            'fur' => $fur,
            'fpp' => $fpp,
            'estudio_lab' => $estudio,
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),
        ]);

        if ($regAnt != '') {
            return response()->json('Expediente Creado Correctamente', 200);
        }
    }
}
