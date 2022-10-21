<?php

namespace App\Http\Controllers\Consulta;
use App\Http\Controllers\Controller;
use App\Models\Medico\Medico;
use App\Models\Paciente\ControlPrenatal;
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

        if ($request->ajax()) {
            $data = ControlPrenatal::select(
                'control_prenatal.id',
                'control_prenatal.diagnostico',
                'control_prenatal.fecha',
                'persona.nombre',
                'persona.ap_paterno',
                'persona.ap_materno',
                'consulta_general.estatus',
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
                        $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="editar_consulta btn btn-success btn-xs btn-glow mr-1 mb-1"><i class="fa fa-list"></i> Detalles</button>';
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

}
