<?php

namespace Database\Seeders;

use App\Models\Consulta;
use App\Models\Dueno;
use App\Models\Mascota;
use App\Models\User;
use App\Models\Veterinario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ExpedienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Obtener o crear un usuario veterinario
        $userVeterinario = User::firstOrCreate(
            ['email' => 'veterinario@gmail.com'],
            [
                'name'     => 'Veterinario',
                'password' => Hash::make('veterinario'),
                'role'     => 'veterinario',
            ]
        );

        // 2. Obtener o crear el perfil de Veterinario para ese usuario
        $veterinario = Veterinario::firstOrCreate(
            ['usuario_id' => $userVeterinario->id],
            [
                'nombre_completo' => 'Dr. Carlos Mendoza',
                'especialidad' => 'Medicina Interna',
                'cedula_profesional' => 'CED-123456',
            ]
        );

        // 3. Crear un Dueño
        $dueno = Dueno::firstOrCreate(
            ['telefono' => '555-123-4567'],
            [
                'nombre_completo' => 'María Fernanda López',
                'direccion' => 'Av. Siempre Viva 742, CDMX',
            ]
        );

        // 4. Crear una Mascota asociada al dueño
        $mascota = Mascota::firstOrCreate(
            [
                'dueno_id' => $dueno->id,
                'nombre' => 'Firulais',
            ],
            [
                'especie' => 'Perro',
                'raza' => 'Mestizo',
                'fecha_nacimiento' => Carbon::now()->subYears(3),
                'tipo_sangre' => 'DEA 1.1',
                'comportamiento' => 'Tranquilo',
                'es_adoptado' => true,
            ]
        );

        // 5. Crear 2 Consultas para esa mascota
        Consulta::firstOrCreate(
            [
                'mascota_id' => $mascota->id,
                'fecha_consulta' => Carbon::now()->subMonths(2),
            ],
            [
                'veterinario_id' => $veterinario->id,
                'peso' => 15.5,
                'talla' => 45.0,
                'diagnostico' => 'Chequeo general de rutina. El paciente se encuentra en óptimas condiciones.',
                'tratamiento' => 'Continuar con la misma dieta y realizar desparasitación en 3 meses.',
            ]
        );

        Consulta::firstOrCreate(
            [
                'mascota_id' => $mascota->id,
                'fecha_consulta' => Carbon::now()->subDays(5),
            ],
            [
                'veterinario_id' => $veterinario->id,
                'peso' => 15.8,
                'talla' => 45.0,
                'diagnostico' => 'Leve infección gastrointestinal por ingesta de alimento indebido.',
                'tratamiento' => 'Administrar antibiótico oral cada 12 horas por 5 días y dieta blanda.',
            ]
        );
    }
}
