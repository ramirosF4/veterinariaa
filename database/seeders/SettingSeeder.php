<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'clinic_name', 'value' => 'Veterinaria Pets', 'group' => 'general'],
            ['key' => 'clinic_email', 'value' => 'contacto@pets.com', 'group' => 'general'],
            ['key' => 'clinic_phone', 'value' => '1234567890', 'group' => 'general'],
            ['key' => 'clinic_address', 'value' => 'Calle Principal 123', 'group' => 'general'],
            
            // Horarios
            ['key' => 'schedule_monday', 'value' => '09:00 - 18:00', 'group' => 'horarios'],
            ['key' => 'schedule_tuesday', 'value' => '09:00 - 18:00', 'group' => 'horarios'],
            ['key' => 'schedule_wednesday', 'value' => '09:00 - 18:00', 'group' => 'horarios'],
            ['key' => 'schedule_thursday', 'value' => '09:00 - 18:00', 'group' => 'horarios'],
            ['key' => 'schedule_friday', 'value' => '09:00 - 18:00', 'group' => 'horarios'],
            ['key' => 'schedule_saturday', 'value' => '10:00 - 14:00', 'group' => 'horarios'],
            ['key' => 'schedule_sunday', 'value' => 'Cerrado', 'group' => 'horarios'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
