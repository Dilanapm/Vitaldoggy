<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'name' => 'Administrador',
                'username' => 'admin',
                'email' => 'admin@vitaldoggy.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'roles' => ['admin'],
                'is_active' => true,
                'email_verified_at' => now(),
                'phone' => '1234567890',
                'address' => 'Oficina Principal',
            ]);

            $this->command->info('Usuario administrador creado exitosamente');
            $this->command->info('Email: admin@vitaldoggy.com');
            $this->command->info('Password: password');
        } else {
            $this->command->info('Ya existe un usuario administrador');
        }
    }
}
