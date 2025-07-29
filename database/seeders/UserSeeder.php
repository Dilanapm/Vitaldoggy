<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Shelter;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear albergues de ejemplo
        $shelter1 = Shelter::create([
            'name' => 'Refugio Patitas Felices',
            'address' => 'Calle Principal 123, Ciudad',
            'phone' => '+1234567890',
            'email' => 'contacto@patitasfelices.com',
            'description' => 'Refugio para perros y gatos abandonados',
            'is_active' => true,
        ]);
        
        $shelter2 = Shelter::create([
            'name' => 'Hogar Animal',
            'address' => 'Avenida Central 456, Ciudad',
            'phone' => '+1234567891',
            'email' => 'contacto@hogaranimal.com',
            'description' => 'Centro de rescate y adopción de mascotas',
            'is_active' => true,
        ]);
        
        // Admin Principal
        User::create([
            'name' => 'Admin VitalDoggy',
            'email' => 'admin@vitaldoggy.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'shelter_id' => null,
            'is_active' => true,
            'phone' => '+1234567890',
            'address' => 'Oficina Central VitalDoggy',
            'email_verified_at' => now(),
        ]);

        // Usuario regular (puede ser adoptante y/o donador)
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'shelter_id' => null,
            'is_active' => true,
            'phone' => '+1234567891',
            'address' => 'Calle Principal 123',
            'email_verified_at' => now(),
        ]);

        // Otro usuario regular
        User::create([
            'name' => 'María García',
            'email' => 'maria@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'shelter_id' => null,
            'is_active' => true,
            'phone' => '+1234567892',
            'address' => 'Avenida Central 456',
            'email_verified_at' => now(),
        ]);

        // Cuidador principal del primer albergue
        User::create([
            'name' => 'Carlos López',
            'email' => 'carlos@example.com',
            'password' => Hash::make('password123'),
            'role' => 'caretaker',
            'shelter_id' => $shelter1->id,
            'is_active' => true,
            'phone' => '+1234567893',
            'address' => 'Boulevard Norte 789',
            'email_verified_at' => now(),
        ]);
        
        // Cuidador principal del segundo albergue
        User::create([
            'name' => 'Ana Martínez',
            'email' => 'ana@example.com',
            'password' => Hash::make('password123'),
            'role' => 'caretaker',
            'shelter_id' => $shelter2->id,
            'is_active' => true,
            'phone' => '+1234567894',
            'address' => 'Calle Sur 321',
            'email_verified_at' => now(),
        ]);

        echo "✅ Usuarios creados: 1 Admin, 2 Users, 2 Caretakers\n";
        echo "✅ Albergues creados: Refugio Patitas Felices, Hogar Animal\n";
    }
}