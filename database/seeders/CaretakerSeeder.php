<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Caretaker;
use App\Models\User;
use App\Models\Shelter;

class CaretakerSeeder extends Seeder
{
    public function run(): void
    {
        echo "🐾 Sincronizando cuidadores con usuarios caretaker...\n";
        
        // Limpiar registros existentes de manera segura
        $deletedCount = Caretaker::count();
        Caretaker::query()->delete();
        echo "🗑️  {$deletedCount} registros de cuidadores eliminados\n";
        
        // Obtener todos los usuarios con rol caretaker que tienen shelter asignado
        $caretakerUsers = User::where('role', 'caretaker')
                             ->whereNotNull('shelter_id')
                             ->with('shelter')
                             ->get();
                             
        if ($caretakerUsers->isEmpty()) {
            echo "⚠️  No hay usuarios con rol 'caretaker' y shelter asignado\n";
            echo "   💡 Ejecuta UserSeeder primero para crear cuidadores\n";
            return;
        }
        
        $positions = [
            'Director de Refugio',
            'Coordinador de Adopciones', 
            'Especialista Veterinario',
            'Cuidador Principal',
            'Responsable de Voluntarios',
            'Coordinador de Rescates',
            'Especialista en Rehabilitación'
        ];
        
        $createdCount = 0;
        
        foreach ($caretakerUsers as $index => $user) {
            $position = $positions[$index % count($positions)];
            
            $caretaker = Caretaker::create([
                'user_id' => $user->id,
                'shelter_id' => $user->shelter_id,
                'position' => $position,
                'phone' => $this->generatePhone(),
                'start_date' => $this->generateStartDate(),
                'notes' => $this->generateNotes($position, $user->shelter->name),
            ]);
            
            echo "   ✅ {$user->name} -> {$position} en {$user->shelter->name}\n";
            $createdCount++;
        }
        
        // Crear algunos cuidadores adicionales para refugios sin cuidador principal
        $this->createAdditionalCaretakers($caretakerUsers);
        
        echo "\n✅ Sincronización completada:\n";
        echo "   🐾 {$createdCount} cuidadores principales creados\n";
        echo "   🏠 " . Shelter::whereHas('caretakers')->count() . " refugios con cuidadores asignados\n";
        echo "   📊 Total registros en tabla caretakers: " . Caretaker::count() . "\n";
        
        $this->showSummary();
    }
    
    private function createAdditionalCaretakers($existingCaretakers)
    {
        echo "\n🔄 Creando cuidadores adicionales...\n";
        
        // Refugios que aún no tienen cuidadores
        $sheltersWithoutCaretakers = Shelter::whereNotIn('id', $existingCaretakers->pluck('shelter_id'))
                                           ->take(3)
                                           ->get();
                                           
        if ($sheltersWithoutCaretakers->isEmpty()) {
            echo "   ℹ️  Todos los refugios activos ya tienen cuidadores asignados\n";
            return;
        }
        
        // Crear usuarios caretaker para estos refugios
        foreach ($sheltersWithoutCaretakers as $shelter) {
            $user = User::create([
                'name' => "Cuidador Principal de {$shelter->name}",
                'email' => "cuidador.{$shelter->id}@{$this->generateEmailDomain()}",
                'username' => "cuidador_shelter_{$shelter->id}",
                'password' => bcrypt('password123'),
                'role' => 'caretaker',
                'shelter_id' => $shelter->id,
                'roles' => json_encode(['voluntario']), // Achievement de voluntario
                'email_verified_at' => now(),
            ]);
            
            $caretaker = Caretaker::create([
                'user_id' => $user->id,
                'shelter_id' => $shelter->id,
                'position' => 'Cuidador Principal',
                'phone' => $this->generatePhone(),
                'start_date' => $this->generateStartDate(),
                'notes' => "Cuidador principal responsable de las operaciones diarias en {$shelter->name}",
            ]);
            
            echo "   ➕ {$user->name} creado para {$shelter->name}\n";
        }
    }
    
    private function generatePhone(): string
    {
        return '+1234567' . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
    }
    
    private function generateStartDate(): string
    {
        $months = rand(1, 36); // Entre 1 mes y 3 años
        return now()->subMonths($months)->format('Y-m-d');
    }
    
    private function generateEmailDomain(): string
    {
        $domains = ['vitaldoggy.com', 'refugio.org', 'cuidadores.net'];
        return $domains[array_rand($domains)];
    }
    
    private function generateNotes(string $position, string $shelterName): string
    {
        $notes = [
            'Director de Refugio' => "Responsable de la gestión general y supervisión de todas las actividades en {$shelterName}.",
            'Coordinador de Adopciones' => "Encargado del proceso de adopción, evaluación de familias adoptivas y seguimiento post-adopción en {$shelterName}.",
            'Especialista Veterinario' => "Responsable del cuidado médico, vacunación y tratamientos veterinarios en {$shelterName}.",
            'Cuidador Principal' => "Encargado del cuidado diario, alimentación y bienestar general de los animales en {$shelterName}.",
            'Responsable de Voluntarios' => "Coordina y supervisa el programa de voluntariado y actividades comunitarias en {$shelterName}.",
            'Coordinador de Rescates' => "Responsable de las operaciones de rescate y rehabilitación de animales en {$shelterName}.",
            'Especialista en Rehabilitación' => "Especializado en rehabilitación física y comportamental de animales rescatados en {$shelterName}."
        ];
        
        return $notes[$position] ?? "Cuidador especializado en {$shelterName}.";
    }
    
    private function showSummary()
    {
        echo "\n📊 RESUMEN FINAL:\n";
        
        $summary = Caretaker::selectRaw('shelter_id, COUNT(*) as caretaker_count')
            ->with('shelter:id,name')
            ->groupBy('shelter_id')
            ->get();
            
        foreach ($summary as $item) {
            echo "   🏠 {$item->shelter->name}: {$item->caretaker_count} cuidador(es)\n";
        }
        
        echo "\n🎯 ESTRUCTURA FINAL:\n";
        echo "   ✅ Tabla users: rol 'caretaker' + shelter_id\n";
        echo "   ✅ Tabla caretakers: detalles específicos del puesto\n";
        echo "   ✅ Relaciones: User->shelter, Caretaker->user, Caretaker->shelter\n";
        echo "   ✅ Achievements: cuidadores tienen 'voluntario'\n";
    }
}