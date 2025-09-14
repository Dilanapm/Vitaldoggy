<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pet;
use App\Models\Shelter;
use App\Models\Caretaker;

class PetSeeder extends Seeder
{
    public function run(): void
    {
        echo "🐾 Asignando cuidadores a mascotas existentes...\n";
        
        // Obtener shelters y caretakers existentes
        $shelters = Shelter::all();
        $caretakers = Caretaker::with('shelter')->get();
        
        if ($shelters->isEmpty()) {
            echo "❌ Error: Ejecuta ShelterSeeder primero\n";
            return;
        }

        if ($caretakers->isEmpty()) {
            echo "❌ Error: Ejecuta CaretakerSeeder primero\n";
            return;
        }

        $this->assignCaretakersToPets();
        $this->createSamplePets($shelters, $caretakers);
    }

    private function assignCaretakersToPets(): void
    {
        echo "\n📋 ASIGNANDO CUIDADORES A MASCOTAS EXISTENTES:\n";
        
        // Obtener mascotas sin cuidador agrupadas por refugio
        $petsWithoutCaretaker = Pet::whereNull('caretaker_id')
            ->with('shelter')
            ->get()
            ->groupBy('shelter_id');

        $totalAssigned = 0;
        $refugiosWithoutCaretakers = [];

        foreach ($petsWithoutCaretaker as $shelterId => $pets) {
            $shelter = $pets->first()->shelter;
            $shelterName = $shelter ? $shelter->name : "Refugio ID: {$shelterId}";
            
            // Buscar cuidadores del mismo refugio
            $caretakers = Caretaker::where('shelter_id', $shelterId)->get();
            
            if ($caretakers->isEmpty()) {
                $refugiosWithoutCaretakers[] = $shelterName;
                echo "  ⚠️  {$shelterName}: {$pets->count()} mascotas SIN cuidadores disponibles\n";
                continue;
            }

            // Distribuir mascotas entre los cuidadores del refugio
            $petsPerCaretaker = $pets->chunk(ceil($pets->count() / $caretakers->count()));
            $caretakerIndex = 0;

            foreach ($petsPerCaretaker as $petChunk) {
                if ($caretakerIndex >= $caretakers->count()) {
                    $caretakerIndex = 0; // Reiniciar si hay más chunks que cuidadores
                }
                
                $caretaker = $caretakers[$caretakerIndex];
                $petIds = $petChunk->pluck('id')->toArray();
                
                // Actualizar mascotas con el cuidador
                Pet::whereIn('id', $petIds)->update(['caretaker_id' => $caretaker->id]);
                
                $caretakerUser = $caretaker->user;
                $caretakerName = $caretakerUser ? $caretakerUser->name : "Cuidador ID: {$caretaker->id}";
                
                echo "  ✅ {$shelterName}: {$petChunk->count()} mascotas → {$caretakerName} ({$caretaker->position})\n";
                
                $totalAssigned += $petChunk->count();
                $caretakerIndex++;
            }
        }

        echo "\n🎉 RESULTADO DE ASIGNACIONES:\n";
        echo "   ✅ Total mascotas asignadas: {$totalAssigned}\n";
        
        if (!empty($refugiosWithoutCaretakers)) {
            echo "   ⚠️  Refugios sin cuidadores: " . implode(', ', $refugiosWithoutCaretakers) . "\n";
            echo "   💡 Considera ejecutar CaretakerSeeder para crear más cuidadores\n";
        }
    }

    private function createSamplePets($shelters, $caretakers): void
    {
        echo "\n🆕 CREANDO MASCOTAS DE EJEMPLO:\n";
        
        // Solo crear mascotas de ejemplo si no existen ya con estos microchips
        $samplePets = [
            [
                'microchip' => 'MC001234567890',
                'name' => 'Max',
                'species' => 'Perro',
                'breed' => 'Golden Retriever',
                'age' => '3 años',
                'gender' => 'Macho',
                'description' => 'Perro muy amigable y juguetón, perfecto para familias con niños.',
                'health_status' => 'Saludable',
                'adoption_status' => 'available',
                'weight' => 28.50,
                'color' => 'Dorado',
                'is_sterilized' => true,
                'is_vaccinated' => true,
            ],
            [
                'microchip' => 'MC001234567891',
                'name' => 'Luna',
                'species' => 'Perro',
                'breed' => 'Pastor Alemán',
                'age' => '2 años',
                'gender' => 'Hembra',
                'description' => 'Perra inteligente y leal, necesita un hogar con experiencia.',
                'health_status' => 'Saludable',
                'adoption_status' => 'available',
                'weight' => 25.00,
                'color' => 'Negro y café',
                'is_sterilized' => true,
                'is_vaccinated' => true,
            ],
            [
                'microchip' => 'MC001234567892',
                'name' => 'Bobby',
                'species' => 'Perro',
                'breed' => 'Mestizo',
                'age' => '5 años',
                'gender' => 'Macho',
                'description' => 'Perro senior muy tranquilo, ideal para personas mayores.',
                'health_status' => 'Tratamiento',
                'adoption_status' => 'pending',
                'weight' => 18.75,
                'color' => 'Café',
                'is_sterilized' => true,
                'is_vaccinated' => true,
                'special_needs' => 'Medicación diaria para artritis',
            ],
            [
                'microchip' => 'MC001234567893',
                'name' => 'Mimi',
                'species' => 'Gato',
                'breed' => 'Persa',
                'age' => '1 año',
                'gender' => 'Hembra',
                'description' => 'Gatita muy cariñosa y tranquila.',
                'health_status' => 'Saludable',
                'adoption_status' => 'available',
                'weight' => 3.20,
                'color' => 'Blanco',
                'is_sterilized' => false,
                'is_vaccinated' => true,
            ]
        ];

        $created = 0;
        $existing = 0;

        foreach ($samplePets as $index => $petData) {
            $existingPet = Pet::where('microchip', $petData['microchip'])->first();
            
            if ($existingPet) {
                $existing++;
                continue;
            }

            // Asignar refugio y cuidador de forma inteligente
            $shelterIndex = $index % $shelters->count();
            $shelter = $shelters[$shelterIndex];
            
            // Buscar cuidador del mismo refugio
            $caretaker = $caretakers->where('shelter_id', $shelter->id)->first();
            
            $petData['shelter_id'] = $shelter->id;
            $petData['caretaker_id'] = $caretaker ? $caretaker->id : null;
            $petData['entry_date'] = now()->subMonths(rand(1, 12))->format('Y-m-d');

            Pet::create($petData);
            
            $caretakerName = $caretaker && $caretaker->user ? $caretaker->user->name : 'Sin cuidador';
            echo "  ✅ Creado: {$petData['name']} → {$shelter->name} (Cuidador: {$caretakerName})\n";
            
            $created++;
        }

        echo "\n📊 RESUMEN DE MASCOTAS DE EJEMPLO:\n";
        echo "   🆕 Nuevas mascotas creadas: {$created}\n";
        echo "   ♻️  Mascotas ya existentes: {$existing}\n";
    }
}