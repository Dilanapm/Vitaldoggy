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
            ['name' => 'Albergue Huellitas Felices'],
            [
                'address' => 'Calle de los Perros 123, Colonia Centro',
                'phone' => '+1234567800',
                'city' => 'Ciudad de México',
                'status' => 'active',
                'description' => 'Albergue dedicado al rescate y cuidado de perros abandonados. Contamos con instalaciones modernas y un equipo de veterinarios especializados.',
                'email' => 'huellitas@example.com',
                'capacity' => 150,
                'image_path' => 'albergue1.jpg',
            ]
        );

        Shelter::updateOrCreate(
            ['name' => 'Refugio Patitas Amorosas'],
            [
                'address' => 'Avenida Libertad 456, Zona Norte',
                'phone' => '+1234567801',
                'city' => 'Guadalajara',
                'status' => 'active',
                'description' => 'Refugio con más de 10 años rescatando y rehabilitando perros. Nos especializamos en casos de abandono y maltrato.',
                'email' => 'patitas@example.com',
                'capacity' => 100,
                'image_path' => 'albergue2.png',
            ]
        );

        Shelter::updateOrCreate(
            ['name' => 'Casa de Amor Animal'],
            [
                'address' => 'Boulevard Sur 789, Zona Industrial',
                'phone' => '+1234567802',
                'city' => 'Monterrey',
                'status' => 'active',
                'description' => 'Centro de rescate especializado en rehabilitación de perros maltratados. Ofrecemos programas de adopción responsable.',
                'email' => 'casaamor@example.com',
                'capacity' => 80,
                'image_path' => 'albergue3.jpg',
            ]
        );

        Shelter::updateOrCreate(
            ['name' => 'Fundación Corazones Peludos'],
            [
                'address' => 'Calle Esperanza 321, Centro Histórico',
                'phone' => '+1234567803',
                'city' => 'Puebla',
                'status' => 'active',
                'description' => 'Fundación sin fines de lucro dedicada al rescate de perros de la calle. Trabajamos con voluntarios de toda la comunidad.',
                'email' => 'corazones@example.com',
                'capacity' => 120,
                'image_path' => 'albergue4.jpg',
            ]
        );

        Shelter::updateOrCreate(
            ['name' => 'Refugio Nueva Esperanza'],
            [
                'address' => 'Avenida Reforma 654, Colonia Del Valle',
                'phone' => '+1234567804',
                'city' => 'Tijuana',
                'status' => 'active',
                'description' => 'Refugio moderno con amplias instalaciones y programas de educación sobre tenencia responsable de mascotas.',
                'email' => 'esperanza@example.com',
                'capacity' => 200,
                'image_path' => 'albergue5.jpg',
            ]
        );

        echo "✅ Albergues creados: 5 shelters con imágenes\n";
    }
}