<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){
        return view("modules/auth/login");
    }

    public function logear(Request $request) {
        $credenciales = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credenciales)) {
            $role = Auth::user()->role;

            if ($role === 'administrador') {
                return to_route('admin.home');
            }

            return to_route('home');
        } else {
            return back()->withErrors(['email' => 'Credenciales incorrectas.'])->onlyInput('email');
        }
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return to_route('login');
    }

    public function home() {
        $stats = [
            'pacientes' => \App\Models\Mascota::count('*'),
            'consultas_hoy' => \App\Models\Consulta::whereDate('fecha_consulta', '=', \Carbon\Carbon::today(), 'and')->count(),
            'propietarios' => \App\Models\Dueno::count('*'),
            'citas_pendientes' => \App\Models\Consulta::where('fecha_consulta', '>', \Carbon\Carbon::now(), 'and')->count(),
        ];
        
        $user = Auth::user()->load('veterinario');
        $veterinario = $user->veterinario;

        return view('modules/dashboard/home', compact('stats', 'veterinario'));
    }

    public function adminHome() {
        return view('modules/admin/dashboard');
    }
}
