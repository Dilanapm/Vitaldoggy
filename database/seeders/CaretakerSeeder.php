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
        // Obtener usuarios y shelters existentes
        $users = User::all();
        $shelters = Shelter::all();
        
        // Verificar que existan datos
        if ($users->isEmpty() || $shelters->isEmpty()) {
            echo "❌ Error: Necesitas ejecutar UserSeeder y ShelterSeeder primero\n";
            return;
        }

        // Crear algunos cuidadores con usuarios existentes
        Caretaker::updateOrCreate(
            [
                'user_id' => $users->where('role', 'admin')->first()->id,
                'shelter_id' => $shelters->first()->id
            ],
            [
                'position' => 'Director General',
                'phone' => '+1234567810',
                'start_date' => now()->subYears(2)->format('Y-m-d'),
                'notes' => 'Supervisor general del albergue, encargado de operaciones.',
            ]
        );

        // Crear cuidador con usuario normal
        if ($users->where('role', 'user')->count() > 0) {
            Caretaker::updateOrCreate(
                [
                    'user_id' => $users->where('role', 'user')->first()->id,
                    'shelter_id' => $shelters->first()->id
                ],
                [
                    'position' => 'Cuidador Veterinario',
                    'phone' => '+1234567811',
                    'start_date' => now()->subMonths(8)->format('Y-m-d'),
                    'notes' => 'Especialista en cuidado médico de los animales.',
                ]
            );
        }

        // Otro cuidador en diferente shelter
        if ($shelters->count() > 1 && $users->where('role', 'user')->count() > 1) {
            Caretaker::updateOrCreate(
                [
                    'user_id' => $users->where('role', 'user')->skip(1)->first()->id,
                    'shelter_id' => $shelters->skip(1)->first()->id
                ],
                [
                    'position' => 'Coordinador de Adopciones',
                    'phone' => '+1234567812',
                    'start_date' => now()->subMonths(6)->format('Y-m-d'),
                    'notes' => 'Encargado del proceso de adopción y seguimiento.',
                ]
            );
        }

        echo "✅ Cuidadores creados exitosamente\n";
    }
}