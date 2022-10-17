<?php

namespace App\Http\Controllers;

use App\Models\Persona\Persona;
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
        $this->middleware('auth');
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
            return redirect()->intended('/home');
        } else {
            return view('auth.login');
        }
    }

    public function dashboard()
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
}
