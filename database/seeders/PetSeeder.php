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
        // Obtener shelters y caretakers existentes
        $shelters = Shelter::all();
        $caretakers = Caretaker::all();
        
        if ($shelters->isEmpty()) {
            echo "❌ Error: Ejecuta ShelterSeeder primero\n";
            return;
        }

        // Perros disponibles para adopción
        Pet::updateOrCreate(
            ['microchip' => 'MC001234567890'],
            [
                'shelter_id' => $shelters->first()->id,
                'caretaker_id' => $caretakers->isNotEmpty() ? $caretakers->first()->id : null,
                'name' => 'Max',
                'species' => 'Perro',
                'breed' => 'Golden Retriever',
                'age' => '3 años',
                'gender' => 'Macho',
                'description' => 'Perro muy amigable y juguetón, perfecto para familias con niños.',
                'health_status' => 'Saludable',
                'adoption_status' => 'available',
                'entry_date' => now()->subMonths(6)->format('Y-m-d'),
                'weight' => 28.50,
                'color' => 'Dorado',
                'is_sterilized' => true,
                'is_vaccinated' => true,
                'special_needs' => null,
            ]
        );

        Pet::updateOrCreate(
            ['microchip' => 'MC001234567891'],
            [
                'shelter_id' => $shelters->first()->id,
                'caretaker_id' => $caretakers->isNotEmpty() ? $caretakers->first()->id : null,
                'name' => 'Luna',
                'species' => 'Perro',
                'breed' => 'Pastor Alemán',
                'age' => '2 años',
                'gender' => 'Hembra',
                'description' => 'Perra inteligente y leal, necesita un hogar con experiencia.',
                'health_status' => 'Saludable',
                'adoption_status' => 'available',
                'entry_date' => now()->subMonths(4)->format('Y-m-d'),
                'weight' => 25.00,
                'color' => 'Negro y café',
                'is_sterilized' => true,
                'is_vaccinated' => true,
                'special_needs' => null,
            ]
        );

        // Perro en proceso de adopción
        Pet::updateOrCreate(
            ['microchip' => 'MC001234567892'],
            [
                'shelter_id' => $shelters->count() > 1 ? $shelters->skip(1)->first()->id : $shelters->first()->id,
                'caretaker_id' => $caretakers->count() > 1 ? $caretakers->skip(1)->first()->id : null,
                'name' => 'Bobby',
                'species' => 'Perro',
                'breed' => 'Mestizo',
                'age' => '5 años',
                'gender' => 'Macho',
                'description' => 'Perro senior muy tranquilo, ideal para personas mayores.',
                'health_status' => 'Tratamiento',
                'adoption_status' => 'pending',
                'entry_date' => now()->subYear()->format('Y-m-d'),
                'weight' => 18.75,
                'color' => 'Café',
                'is_sterilized' => true,
                'is_vaccinated' => true,
                'special_needs' => 'Medicación diaria para artritis',
            ]
        );

        // Gato disponible
        Pet::updateOrCreate(
            ['microchip' => 'MC001234567893'],
            [
                'shelter_id' => $shelters->first()->id,
                'caretaker_id' => null,
                'name' => 'Mimi',
                'species' => 'Gato',
                'breed' => 'Persa',
                'age' => '1 año',
                'gender' => 'Hembra',
                'description' => 'Gatita muy cariñosa y tranquila.',
                'health_status' => 'Saludable',
                'adoption_status' => 'available',
                'entry_date' => now()->subMonths(2)->format('Y-m-d'),
                'weight' => 3.20,
                'color' => 'Blanco',
                'is_sterilized' => false,
                'is_vaccinated' => true,
                'special_needs' => null,
            ]
        );

        echo "✅ Mascotas creadas: 4 pets (3 perros, 1 gato)\n";
    }
}