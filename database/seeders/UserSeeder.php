<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Principal
        User::create([
            'name' => 'Admin VitalDoggy',
            'email' => 'admin@vitaldoggy.com',
            'password' => Hash::make('password123'),
            'role' => 'admin', // ✅ Correcto
            'shelter_id' => null,
            'is_active' => true,
            'phone' => '+1234567890',
            'address' => 'Oficina Central VitalDoggy',
            'email_verified_at' => now(),
        ]);

        // Usuario adoptante
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user', // ✅ Corregido de 'adopter' a 'user'
            'shelter_id' => null,
            'is_active' => true,
            'phone' => '+1234567891',
            'address' => 'Calle Principal 123',
            'email_verified_at' => now(),
        ]);

        // Otro usuario adoptante
        User::create([
            'name' => 'María García',
            'email' => 'maria@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user', // ✅ Corregido
            'shelter_id' => null,
            'is_active' => true,
            'phone' => '+1234567892',
            'address' => 'Avenida Central 456',
            'email_verified_at' => now(),
        ]);

        // Usuario donante
        User::create([
            'name' => 'Carlos López',
            'email' => 'carlos@example.com',
            'password' => Hash::make('password123'),
            'role' => 'donor', // ✅ Usuario tipo donante
            'shelter_id' => null,
            'is_active' => true,
            'phone' => '+1234567893',
            'address' => 'Boulevard Norte 789',
            'email_verified_at' => now(),
        ]);

        echo "✅ Usuarios creados: 1 Admin, 2 Users, 1 Donor\n";
    }
}