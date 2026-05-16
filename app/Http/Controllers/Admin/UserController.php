<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Veterinario;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Listado de todos los usuarios del sistema.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filtro por rol
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Búsqueda por nombre o email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(5)->withQueryString();

        $totalUsers       = \Illuminate\Support\Facades\DB::table('users')->count();
        $totalAdmins      = \Illuminate\Support\Facades\DB::table('users')->where('role', 'administrador')->count();
        $totalVeterinarios = \Illuminate\Support\Facades\DB::table('users')->where('role', 'veterinario')->count();

        return view('modules.admin.users.index', compact(
            'users',
            'totalUsers',
            'totalAdmins',
            'totalVeterinarios'
        ));
    }

    /**
     * Formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('modules.admin.users.create');
    }

    /**
     * Guardar nuevo usuario en BD.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        if ($request->role === 'veterinario') {
            Veterinario::create([
                'usuario_id'         => $user->id,
                'nombre_completo'    => $user->name,
                'especialidad'       => $request->especialidad,
                'cedula_profesional' => $request->cedula_profesional,
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Confirmar eliminación de usuario y verificar dependencias (Vista Show).
     */
    public function show(User $user)
    {
        $hasDependencies = false;
        $dependencyMessage = '';

        // Validar dependencias si es veterinario
        if ($user->role === 'veterinario' && $user->veterinario) {
            $consultasCount = $user->veterinario->consultas()->count();
            if ($consultasCount > 0) {
                $hasDependencies = true;
                $dependencyMessage = "Este veterinario tiene {$consultasCount} consulta(s) médica(s) asociada(s).";
            }
        }

        // Si hubiera más roles con dependencias, se agregarían aquí las validaciones adicionales

        return view('modules.admin.users.show', compact('user', 'hasDependencies', 'dependencyMessage'));
    }

    /**
     * Formulario para editar un usuario.
     */
    public function edit(User $user)
    {
        return view('modules.admin.users.edit', compact('user'));
    }

    /**
     * Actualizar datos del usuario.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'role'   => $request->role,
            'activo' => $request->activo,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Sincronizar perfil de veterinario
        if ($request->role === 'veterinario') {
            Veterinario::updateOrCreate(
                ['usuario_id' => $user->id],
                [
                    'nombre_completo'    => $user->name,
                    'especialidad'       => $request->especialidad,
                    'cedula_profesional' => $request->cedula_profesional,
                ]
            );
        } else {
            // Si cambia a administrador, eliminamos su perfil de veterinario
            $user->veterinario()->delete();
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar un usuario del sistema.
     */
    public function destroy(User $user)
    {
        // Evitar que el admin se elimine a sí mismo
        if ($user->id === Auth::id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        // Validación de backend por si intentan saltarse la vista show
        if ($user->role === 'veterinario' && $user->veterinario) {
            if ($user->veterinario->consultas()->exists()) {
                return back()->with('error', 'No se puede eliminar el usuario porque tiene consultas médicas asociadas.');
            }
        }

        User::destroy($user->id);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
