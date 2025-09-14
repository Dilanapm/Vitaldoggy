<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Shelter;
use App\Models\Pet;
use App\Models\AdoptionApplication;
use App\Models\Donation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar tablas relacionadas primero (orden importante por foreign keys)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Limpiar en orden inverso de dependencias
        AdoptionApplication::truncate();
        Donation::truncate();
        User::truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        echo "🗑️  Base de datos limpiada\n";
        
        // Obtener refugios existentes para asignar cuidadores
        $shelters = Shelter::all();
        if ($shelters->isEmpty()) {
            echo "⚠️  No hay refugios. Ejecuta ShelterSeeder primero.\n";
            return;
        }
        
        // 1. Crear usuarios base (solo roles principales)
        $this->createBaseUsers($shelters);
        
        // 2. Crear mascotas si no existen (necesarias para adopciones)
        $this->ensurePetsExist();
        
        // 3. Crear actividades que generan achievements
        $this->createAdoptionActivities();
        $this->createDonationActivities();
        
        // 4. Asignar achievements basados en actividades reales
        $this->assignAchievementsBasedOnActivities();
        
        echo "✅ UserSeeder completado con lógica de achievements\n";
    }
    
    private function createBaseUsers($shelters)
    {
        echo "👥 Creando usuarios base...\n";
        
        // Admin principal
        User::create([
            'name' => 'Administrador Principal',
            'email' => 'admin@vitaldoggy.com',
            'username' => 'admin',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'roles' => json_encode([]), // achievements van en roles
            'email_verified_at' => now(),
        ]);
        
        // Cuidadores (uno por refugio)
        foreach ($shelters->take(3) as $index => $shelter) {
            User::create([
                'name' => "Cuidador del Refugio {$shelter->name}",
                'email' => "cuidador{$index}@vitaldoggy.com", 
                'username' => "cuidador{$index}",
                'password' => Hash::make('password123'),
                'role' => 'caretaker',
                'shelter_id' => $shelter->id,
                'roles' => json_encode([]), // achievements van en roles
                'email_verified_at' => now(),
            ]);
        }
        
        // Usuarios normales (sin achievements inicialmente)
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Usuario Test {$i}",
                'email' => "user{$i}@test.com",
                'username' => "user{$i}",
                'password' => Hash::make('password123'),
                'role' => 'user',
                'roles' => json_encode([]), // achievements van en roles
                'email_verified_at' => now(),
            ]);
        }
        
        echo "👥 " . User::count() . " usuarios creados\n";
    }
    
    private function ensurePetsExist()
    {
        if (Pet::count() < 5) {
            echo "🐕 Creando mascotas para adopciones...\n";
            
            $shelters = Shelter::all();
            foreach ($shelters->take(3) as $shelter) {
                for ($i = 1; $i <= 3; $i++) {
                    Pet::create([
                        'name' => "Mascota Test {$i} - {$shelter->name}",
                        'shelter_id' => $shelter->id,
                        'species' => 'dog',
                        'breed' => 'Mestizo',
                        'age' => rand(1, 8),
                        'size' => ['small', 'medium', 'large'][array_rand(['small', 'medium', 'large'])],
                        'adoption_status' => 'available',
                        'description' => "Descripción de mascota de prueba",
                        'gender' => ['male', 'female'][array_rand(['male', 'female'])],
                        'health_status' => 'healthy',
                        'entry_date' => now()->subDays(rand(30, 180)),
                    ]);
                }
            }
            echo "🐕 " . Pet::count() . " mascotas disponibles\n";
        }
    }
    
    private function createAdoptionActivities()
    {
        echo "🏠 Creando adopciones exitosas...\n";
        
        $users = User::where('role', 'user')->take(5)->get();
        $pets = Pet::where('adoption_status', 'available')->take(5)->get();
        
        foreach ($users as $index => $user) {
            if (isset($pets[$index])) {
                $adoption = AdoptionApplication::create([
                    'user_id' => $user->id,
                    'pet_id' => $pets[$index]->id,
                    'resolved_by' => User::where('role', 'admin')->first()->id,
                    'status' => 'approved', // ¡CLAVE! Esto genera el achievement
                    'reason' => 'Quiero adoptar esta mascota para darle mucho amor',
                    'application_date' => now()->subDays(rand(1, 30)),
                    'resolution_date' => now()->subDays(rand(1, 10)),
                    'resolution_notes' => 'Adopción aprobada - cumple todos los requisitos',
                    'has_experience' => true,
                    'living_situation' => 'Casa propia con jardín',
                    'priority_score' => rand(70, 100),
                ]);
                
                // Marcar mascota como adoptada
                $pets[$index]->update(['adoption_status' => 'adopted']);
                
                echo "   ✅ {$user->name} adoptó a {$pets[$index]->name}\n";
            }
        }
    }
    
    private function createDonationActivities()
    {
        echo "💰 Creando donaciones...\n";
        
        $users = User::where('role', 'user')->skip(3)->take(7)->get();
        $shelters = Shelter::all();
        
        foreach ($users as $user) {
            // Algunos usuarios donan a múltiples refugios
            $donationCount = rand(1, 2);
            
            for ($i = 0; $i < $donationCount; $i++) {
                $shelter = $shelters->random();
                
                Donation::create([
                    'user_id' => $user->id,
                    'shelter_id' => $shelter->id,
                    'confirmed_by' => User::where('role', 'admin')->first()->id,
                    'amount' => rand(50, 500),
                    'currency' => 'USD',
                    'type' => ['money', 'goods'][array_rand(['money', 'goods'])],
                    'description' => 'Donación para ayudar a las mascotas',
                    'status' => 'completed', // ¡CLAVE! Esto genera el achievement
                    'donation_date' => now()->subDays(rand(1, 60)),
                    'confirmed_at' => now()->subDays(rand(1, 30)),
                    'payment_method' => 'PayPal',
                    'is_anonymous' => false,
                    'donor_message' => 'Espero que esto ayude a los animalitos',
                ]);
                
                echo "   💝 {$user->name} donó al refugio {$shelter->name}\n";
            }
        }
    }
    
    private function assignAchievementsBasedOnActivities()
    {
        echo "🏆 Asignando achievements basados en actividades reales...\n";
        
        // ADOPTANTES: Usuarios con adopciones aprobadas
        $adopters = User::whereHas('adoptionApplications', function($query) {
            $query->where('status', 'approved');
        })->get();
        
        foreach ($adopters as $user) {
            $achievements = json_decode($user->roles, true) ?? [];
            if (!in_array('adoptante', $achievements)) {
                $achievements[] = 'adoptante';
                $user->update(['roles' => json_encode($achievements)]);
                echo "   🏆 {$user->name} → Achievement: Adoptante\n";
            }
        }
        
        // DONADORES: Usuarios con donaciones completadas
        $donors = User::whereHas('donations', function($query) {
            $query->where('status', 'completed');
        })->get();
        
        foreach ($donors as $user) {
            $achievements = json_decode($user->roles, true) ?? [];
            if (!in_array('donador', $achievements)) {
                $achievements[] = 'donador';
                $user->update(['roles' => json_encode($achievements)]);
                echo "   🏆 {$user->name} → Achievement: Donador\n";
            }
        }
        
        // VOLUNTARIOS: Cuidadores activos con refugio asignado
        $volunteers = User::where('role', 'caretaker')
                         ->whereNotNull('shelter_id')
                         ->get();
        
        foreach ($volunteers as $user) {
            $achievements = json_decode($user->roles, true) ?? [];
            if (!in_array('voluntario', $achievements)) {
                $achievements[] = 'voluntario';
                $user->update(['roles' => json_encode($achievements)]);
                echo "   🏆 {$user->name} → Achievement: Voluntario\n";
            }
        }
        
        echo "🏆 Achievements asignados correctamente\n";
    }
}