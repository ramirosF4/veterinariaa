<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Crea los usuarios de prueba del sistema:
     * - Administrador (admin@gmail.com / admin)
     * - Veterinario   (veterinario@gmail.com / veterinario)
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Administrador',
                'email'    => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role'     => 'administrador',
            ]
        );

        User::updateOrCreate(
            ['email' => 'veterinario@gmail.com'],
            [
                'name'     => 'Veterinario',
                'email'    => 'veterinario@gmail.com',
                'password' => Hash::make('veterinario'),
                'role'     => 'veterinario',
            ]
        );
    }
}

