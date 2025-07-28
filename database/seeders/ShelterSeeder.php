<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shelter;

class ShelterSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar por 'name' porque es único, no por email
        Shelter::updateOrCreate(
            ['name' => 'Albergue Huellitas Felices'], // ✅ Buscar por name (único)
            [
                'address' => 'Calle de los Perros 123, Colonia Centro',
                'phone' => '+1234567800',
                'city' => 'Ciudad de México',
                'status' => 'active', // ✅ Valor correcto del enum
                'description' => 'Albergue dedicado al rescate y cuidado de perros abandonados.',
                'email' => 'huellitas@example.com',
                'capacity' => 150,
            ]
        );

        Shelter::updateOrCreate(
            ['name' => 'Refugio Patitas Amorosas'], // ✅ Buscar por name (único)
            [
                'address' => 'Avenida Libertad 456, Zona Norte',
                'phone' => '+1234567801',
                'city' => 'Guadalajara',
                'status' => 'active',
                'description' => 'Refugio con más de 10 años rescatando y rehabilitando perros.',
                'email' => 'patitas@example.com',
                'capacity' => 100,
            ]
        );

        Shelter::updateOrCreate(
            ['name' => 'Casa de Amor Animal'],
            [
                'address' => 'Boulevard Sur 789, Zona Industrial',
                'phone' => '+1234567802',
                'city' => 'Monterrey',
                'status' => 'active',
                'description' => 'Centro de rescate especializado en rehabilitación de perros maltratados.',
                'email' => 'casaamor@example.com',
                'capacity' => 80,
            ]
        );

        echo "✅ Albergues creados: 3 shelters\n";
    }
}