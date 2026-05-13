<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Crea el usuario administrador del sistema.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin'],
            [
                'name'     => 'Administrador',
                'email'    => 'admin',
                'password' => Hash::make('admin'),
            ]
        );
    }
}
