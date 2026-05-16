<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Veterinario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

        $users = $query->latest()->paginate(10)->withQueryString();

        $totalUsers       = User::count();
        $totalAdmins      = User::where('role', 'administrador')->count();
        $totalVeterinarios = User::where('role', 'veterinario')->count();

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
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', Rule::in(['administrador', 'veterinario'])],
            'especialidad' => ['nullable', 'string', 'max:255'],
            'cedula_profesional' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'El formato del correo no es válido.',
            'email.unique'       => 'Este correo ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'role.required'      => 'Debes seleccionar un rol.',
            'role.in'            => 'El rol seleccionado no es válido.',
        ]);

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
     * Formulario para editar un usuario.
     */
    public function edit(User $user)
    {
        return view('modules.admin.users.edit', compact('user'));
    }

    /**
     * Actualizar datos del usuario.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'  => ['required', Rule::in(['administrador', 'veterinario'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'especialidad' => ['nullable', 'string', 'max:255'],
            'cedula_profesional' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'El formato del correo no es válido.',
            'email.unique'       => 'Este correo ya está registrado por otro usuario.',
            'role.required'      => 'Debes seleccionar un rol.',
            'role.in'            => 'El rol seleccionado no es válido.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
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
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
