<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Usuario\TipoUsuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $tipoU = TipoUsuario::all();
        return view('auth.listado')->with('tipoU', $tipoU);
    }
}
