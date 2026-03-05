<?php

namespace App\Http\Controllers\Medicamento;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Medicamento\Medicamento;
use App\Models\Medicamento\StockMedicamento;
use App\Models\Paciente\ConsultaGeneral;
use App\Models\Paciente\RecetaMedica;
use App\Models\Paciente\RecetaSeguimiento;
use App\Models\Paciente\TipoConsulta;
use App\Models\Paciente\TipoSangre;
use DB;
use DataTables;

class MedicamentoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Quitamos ->get() para que DataTables pagine directamente en la BD
            $query = Medicamento::select(
                'medicamento.id',
                'medicamento.activo',
                'stock_medicamento.cantidad',
                'medicamento.precio_venta',
                DB::raw("CONCAT(medicamento.clave,' ',medicamento.nombre,' ',medicamento.presentacion) AS descripcion"),
                DB::raw("CONCAT('Lote: ', medicamento.lote,' Fecha Caducidad: ',medicamento.fecha_cad) AS caducidad"),
                DB::raw('(CASE WHEN medicamento.activo = "1" THEN "Activo" WHEN medicamento.activo= "0" THEN "Inactivo" END) AS estatus')
            )
                ->join('stock_medicamento', 'stock_medicamento.id_medicamento', '=', 'medicamento.id')
                ->orderBy('medicamento.nombre', 'asc');

            return DataTables::of($query)
                ->addColumn('accion', function ($data) {
                    if ($data->activo == 0) {
                        return '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="editar_consulta btn btn-primary btn-xs btn-glow mr-1 mb-1"><i class="fa fa-lock_open"></i> Activar</button>';
                    }

                    if ($data->activo == 1) {
                        return '<div class="btn-group">&nbsp;
                        <button type="button" class="btn btn-primary btn-xs btn-glow mr-1 mb-1 dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-list"></i> Opciones
                        </button>
                        <ul class="dropdown-menu">
                        <li>&nbsp;&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="ag_stock btn btn-primary btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-upload fa-1x"></i> Stock </button></li>
                        <li>&nbsp;&nbsp;<button type="button" name="del" id="' . $data->id . '" class="edit_medicamento btn btn-warning btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-edit fa-1x"></i> Editar </button></li>
                        <li>&nbsp;&nbsp;<button type="button" name="del" id="' . $data->id . '" class="baja_medicamento btn btn-danger btn-min-width btn-glow mr-1 mb-1"><i class="fas fa-lock fa-1x"></i> Desactivar </button></li>
                        </ul>
                        </div>';
                    }
                })
                ->rawColumns(['accion'])
                ->make(true);
        }

        $tipoConsulta = TipoConsulta::all();
        $tipoSangre = TipoSangre::all();
        return view('Medicamento.Listado')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre);
    }

    public function registerMedicamento(Request $request)
    {

        $request->validate([
            'clave' => ['required', 'string', 'max:255', 'unique:medicamento'],
            'nombre' => ['required', 'string', 'max:255'],
            'fecha_cad' => ['required', 'string', 'max:255'],
            'lote' => ['required', 'string', 'max:255'],
            'presentacion' => ['required', 'string', 'max:255'],
            'costo_unitario' => 'required|numeric|min:1|not_in:-1',
            'precio_venta' => 'required|numeric|min:1|not_in:-1',
        ]);


        try {
            DB::beginTransaction();

            $medicamento = Medicamento::create([
                'clave'          => $request->clave,
                'sustancia'      => $request->sustancia,
                'nombre'         => $request->nombre,
                'descripcion'    => $request->descripcion,
                'fecha_cad'      => $request->fecha_cad,
                'lote'           => $request->lote,
                'presentacion'   => $request->presentacion,
                'costo_unitario' => $request->costo,
                'precio_venta'   => $request->precio_v,
                'observaciones'  => $request->observaciones,
                'id_usuario'     => auth()->id(),
                'activo'         => 1,
                'fecha'          => date('Y-m-d'),
                'hora'           => date('H:i:s'),
            ]);

            StockMedicamento::create([
                'id_medicamento' => $medicamento->id,
                'clave_med'      => $request->clave,
                'cantidad'       => $request->cantidad,
                'activo'         => 1,
                'fecha'          => date('Y-m-d'),
                'hora'           => date('H:i:s'),
            ]);

            DB::commit();

            return response()->json('Medicamento registrado correctamente', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al registrar el medicamento: ' . $e->getMessage()], 500);
        }
    }

    public function data_medicamentos(Request $request)
    {
        if ($request->ajax()) {
            $data = Medicamento::select(
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

            return DataTables::of($data)
                ->addColumn('accion', function ($data) {
                    $button = '&nbsp;<button type="button" name="' . $data->id . '" id="' . $data->id . '" class="select_medicamento btn btn-primary btn-xs btn-glow mr-1 mb-1"><i class="fas fa-shopping-cart"></i> Seleccionar</button>';
                    return $button;
                })
                ->rawColumns(['accion'])
                ->editColumn('fecha_cad', function (Medicamento $dat) {
                    return date('d-m-Y', strtotime($dat->fecha_cad));
                })
                ->make(true);
        }


        $tipoConsulta = TipoConsulta::all();
        $tipoSangre = TipoSangre::all();
        return view('Medicamento.Listado')
            ->with('tipoC', $tipoConsulta)
            ->with('tipoS', $tipoSangre);
    }

    public function med_select($id)
    {
        $data = Medicamento::select(
            'medicamento.id',
            'medicamento.activo',
            'stock_medicamento.cantidad',
            'medicamento.precio_venta',
            'medicamento.fecha_cad',
            DB::raw("CONCAT(medicamento.nombre,' ',medicamento.presentacion) AS descripcion")
        )
            ->join('stock_medicamento', 'stock_medicamento.id_medicamento', 'medicamento.id')
            ->where('medicamento.activo', '=', '1')
            ->where('medicamento.id', $id)
            ->first();

        return $data;
    }

    public function regMed_RecetaM(Request $data)
    {

        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        //return $data;
        $data->validate([
            'cantidad' => 'required|numeric|min:1|not_in:-1',
            'tratamiento' => ['required', 'string', 'max:255'],
        ]);

        $id_consulta = $data->id_consulta;
        $id_medicamento = $data->id_medicamento;
        $cantidad = $data->cantidad;
        $tratamiento = $data->tratamiento;

        $busqueda = RecetaMedica::select('cantidad')
            ->where('id_consulta', $id_consulta)
            ->where('id_medicamento', $id_medicamento)
            ->first();

        if ($busqueda != '') {
            $updateM = RecetaMedica::where('id_consulta', $id_consulta)
                ->where('id_medicamento', $id_medicamento)
                ->update([
                    'cantidad' => $busqueda->cantidad + $cantidad,
                ]);
            if ($updateM != '') {
                return response()->json('Se ha actualizado la cantidad del medicamento', 200);
            }
        } else {
            $registrarRM = RecetaMedica::create([
                'id_consulta' => $id_consulta,
                'id_medicamento' => $id_medicamento,
                'cantidad' => $cantidad,
                'tratamiento' => $tratamiento,
                'id_usuario' => $id_usuario,
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s'),
            ]);
            if ($registrarRM != '') {
                return response()->json('Se ha agregado correctamente el Medicamento', 200);
            }
        }
    }

    public function regMed_RecetaSeg(Request $data)
    {

        $usuario = auth()->user();
        $id_usuario = $usuario->id;

        //return $data;
        $data->validate([
            'cantidad' => 'required|numeric|min:1|not_in:-1',
            'tratamiento' => ['required', 'string', 'max:255'],
        ]);

        $id_control = $data->id_control;
        $id_seguimiento = $data->id_seguimiento;
        $id_medicamento = $data->id_medicamento;
        $cantidad = $data->cantidad;
        $tratamiento = $data->tratamiento;

        $busqueda = RecetaSeguimiento::select('cantidad')
            ->where('id_control', $id_control)
            ->where('id_seguimiento', $id_seguimiento)
            ->where('id_medicamento', $id_medicamento)
            ->first();

        if ($busqueda != '') {
            $updateM = RecetaSeguimiento::where('id_control', $id_control)
                ->where('id_seguimiento', $id_seguimiento)
                ->where('id_medicamento', $id_medicamento)
                ->update([
                    'cantidad' => $busqueda->cantidad + $cantidad,
                ]);
            if ($updateM != '') {
                return response()->json('Se ha actualizado la cantidad del medicamento', 200);
            }
        } else {
            $registrarRM = RecetaSeguimiento::create([
                'id_control' => $id_control,
                'id_seguimiento' => $id_seguimiento,
                'id_medicamento' => $id_medicamento,
                'cantidad' => $cantidad,
                'tratamiento' => $tratamiento,
                'id_usuario' => $id_usuario,
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s'),
            ]);
            if ($registrarRM != '') {
                return response()->json('Se ha agregado correctamente el Medicamento', 200);
            }
        }
    }
}
