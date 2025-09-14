<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shelter;
use App\Models\Pet;
use App\Models\Caretaker;

class ShelterSeeder extends Seeder
{
    public function run(): void
    {
        echo "🏠 Mejorando datos de refugios...\n";
        
        $sheltersData = $this->getSheltersData();
        
        $updated = 0;
        $created = 0;
        
        foreach ($sheltersData as $shelterData) {
            $shelter = Shelter::where('name', $shelterData['name'])->first();
            
            if ($shelter) {
                // Actualizar datos existentes sin sobrescribir imagen si ya tiene
                $updateData = $shelterData;
                if (!empty($shelter->image_path)) {
                    unset($updateData['image_path']);
                    echo "⚠️  {$shelter->name} ya tiene imagen: {$shelter->image_path}\n";
                }
                
                $shelter->update($updateData);
                echo "✅ Refugio actualizado: {$shelter->name}\n";
                $updated++;
            } else {
                // Crear nuevo refugio
                Shelter::create($shelterData);
                echo "🆕 Refugio creado: {$shelterData['name']}\n";
                $created++;
            }
        }
        
        // Verificar refugios con información incompleta
        $this->validateAndCompleteData();
        
        echo "\n🎉 Proceso completado:\n";
        echo "   ✅ {$updated} refugios actualizados\n";
        echo "   🆕 {$created} refugios creados\n";
        echo "   📊 Total refugios: " . Shelter::count() . "\n";
        
        $this->showStatistics();
    }
    
    private function getSheltersData(): array
    {
        return [
            [
                'name' => 'Albergue Huellitas Felices',
                'address' => 'Calle de los Perros 123, Colonia Centro, CDMX 06000',
                'phone' => '+52 55 1234-5678',
                'city' => 'Ciudad de México',
                'status' => 'active',
                'description' => 'Albergue dedicado al rescate y cuidado de perros abandonados. Contamos con instalaciones modernas, un equipo de veterinarios especializados y programas de rehabilitación física y emocional. Fundado en 2015, hemos rescatado más de 500 perros.',
                'email' => 'info@huellitasfelices.org',
                'capacity' => 150,
                'is_active' => true,
                'image_path' => 'shelters/albergue1.jpg',
            ],
            [
                'name' => 'Refugio Patitas Amorosas',
                'address' => 'Avenida Libertad 456, Zona Norte, Guadalajara, Jalisco 44100',
                'phone' => '+52 33 2345-6789',
                'city' => 'Guadalajara',
                'status' => 'active',
                'description' => 'Refugio con más de 10 años rescatando y rehabilitando perros. Nos especializamos en casos de abandono y maltrato, ofreciendo terapia conductual y cuidados veterinarios especializados. Trabajamos estrechamente con familias adoptivas.',
                'email' => 'contacto@patitasamorosas.org',
                'capacity' => 100,
                'is_active' => true,
                'image_path' => 'shelters/albergue2.png',
            ],
            [
                'name' => 'Casa de Amor Animal',
                'address' => 'Boulevard Sur 789, Zona Industrial, Monterrey, Nuevo León 64000',
                'phone' => '+52 81 3456-7890',
                'city' => 'Monterrey',
                'status' => 'active',
                'description' => 'Centro de rescate especializado en rehabilitación de perros maltratados. Ofrecemos programas de adopción responsable, seguimiento post-adopción y educación comunitaria sobre bienestar animal. Instalaciones con áreas de juego y entrenamiento.',
                'email' => 'info@casadeamoranimal.org',
                'capacity' => 80,
                'is_active' => true,
                'image_path' => 'shelters/albergue3.jpg',
            ],
            [
                'name' => 'Fundación Corazones Peludos',
                'address' => 'Calle Esperanza 321, Centro Histórico, Puebla, Puebla 72000',
                'phone' => '+52 22 4567-8901',
                'city' => 'Puebla',
                'status' => 'active',
                'description' => 'Fundación sin fines de lucro dedicada al rescate de perros de la calle. Trabajamos con más de 50 voluntarios de toda la comunidad, ofrecemos programas de esterilización gratuita y campañas de concientización sobre tenencia responsable.',
                'email' => 'info@corazonespeludos.org',
                'capacity' => 120,
                'is_active' => true,
                'image_path' => 'shelters/albergue4.jpg',
            ],
            [
                'name' => 'Refugio Nueva Esperanza',
                'address' => 'Avenida Reforma 654, Colonia Del Valle, Tijuana, Baja California 22000',
                'phone' => '+52 664 5678-9012',
                'city' => 'Tijuana',
                'status' => 'active',
                'description' => 'Refugio moderno con amplias instalaciones y programas de educación sobre tenencia responsable de mascotas. Contamos con área de cuarentena, quirófano veterinario y espacios de socialización. Programa especial para perros de edad avanzada.',
                'email' => 'contacto@nuevaesperanza.org',
                'capacity' => 200,
                'is_active' => true,
                'image_path' => 'shelters/albergue5.jpg',
            ],
            [
                'name' => 'Refugio Patitas Felices',
                'address' => 'Carretera Nacional 987, Zona Metropolitana, Ecatepec, Estado de México 55000',
                'phone' => '+52 55 6789-0123',
                'city' => 'Ecatepec',
                'status' => 'active',
                'description' => 'Refugio especializado en rescate de perros en situación de calle. Ofrecemos servicios de rehabilitación física, entrenamiento básico y programas de socialización. Trabajamos con escuelas para educar sobre el cuidado animal.',
                'email' => 'info@patitasfelices.org',
                'capacity' => 90,
                'is_active' => true,
                'image_path' => 'shelters/albergue6.jpg',
            ],
            [
                'name' => 'Hogar Animal',
                'address' => 'Calzada de la Paz 432, Colonia Jardines, Querétaro, Querétaro 76000',
                'phone' => '+52 442 7890-1234',
                'city' => 'Querétaro',
                'status' => 'active',
                'description' => 'Hogar dedicado al bienestar animal con enfoque en perros rescatados. Ofrecemos programas de terapia asistida con animales, visitas educativas y campañas de adopción. Instalaciones eco-amigables con energía solar.',
                'email' => 'info@hogaranimal.org',
                'capacity' => 110,
                'is_active' => true,
                'image_path' => 'shelters/albergue7.jpg',
            ],
            [
                'name' => 'esperanza para los animales grecps',
                'address' => 'Avenida Central 159, Zona Comercial, Zapopan, Jalisco 45000',
                'phone' => '+52 33 8901-2345',
                'city' => 'Zapopan',
                'status' => 'active',
                'description' => 'Organización enfocada en el rescate y rehabilitación de animales en situación de abandono. Contamos con programa de adopción responsable, esterilización y campañas de concientización comunitaria.',
                'email' => 'info@esperanzagrecps.org',
                'capacity' => 75,
                'is_active' => true,
                'image_path' => 'shelters/albergue8.jpg',
            ],
        ];
    }
    
    private function validateAndCompleteData(): void
    {
        echo "\n🔍 Validando datos de refugios...\n";
        
        $shelters = Shelter::all();
        foreach ($shelters as $shelter) {
            $needsUpdate = false;
            $updates = [];
            
            // Validar campos importantes
            if (empty($shelter->description) || strlen($shelter->description) < 50) {
                $updates['description'] = $this->generateDescription($shelter->name);
                $needsUpdate = true;
            }
            
            if (empty($shelter->email)) {
                $updates['email'] = $this->generateEmail($shelter->name);
                $needsUpdate = true;
            }
            
            if (empty($shelter->capacity) || $shelter->capacity == 0) {
                $updates['capacity'] = rand(50, 200);
                $needsUpdate = true;
            }
            
            if ($needsUpdate) {
                $shelter->update($updates);
                echo "   🔧 Datos completados para: {$shelter->name}\n";
            }
        }
    }
    
    private function generateDescription(string $name): string
    {
        return "Refugio dedicado al rescate, cuidado y rehabilitación de animales en situación de abandono. {$name} trabaja incansablemente para brindar una segunda oportunidad a perros que han sido maltratados o abandonados, ofreciendo cuidado veterinario, alimentación adecuada y amor hasta encontrarles un hogar definitivo.";
    }
    
    private function generateEmail(string $name): string
    {
        $slug = strtolower(str_replace([' ', 'ó', 'á', 'é', 'í', 'ú'], ['', 'o', 'a', 'e', 'i', 'u'], $name));
        return "info@{$slug}.org";
    }
    
    private function showStatistics(): void
    {
        echo "\n📊 ESTADÍSTICAS DE REFUGIOS:\n";
        
        $total = Shelter::count();
        $active = Shelter::where('is_active', true)->count();
        $withCaretakers = Shelter::whereHas('caretakers')->count();
        $withImages = Shelter::whereNotNull('image_path')->count();
        
        echo "   🏠 Total refugios: {$total}\n";
        echo "   ✅ Refugios activos: {$active}\n";
        echo "   🐾 Con cuidadores: {$withCaretakers}\n";
        echo "   📸 Con imágenes: {$withImages}\n";
        
        $capacityStats = Shelter::selectRaw('SUM(capacity) as total_capacity, COUNT(*) as total_shelters')->first();
        if ($capacityStats) {
            // Contamos mascotas en refugios para aproximar ocupación
            $totalPets = Pet::whereNotNull('shelter_id')->count();
            $occupancyRate = $capacityStats->total_capacity > 0 ? round(($totalPets / $capacityStats->total_capacity) * 100, 1) : 0;
            echo "   📊 Capacidad total: {$capacityStats->total_capacity}\n";
            echo "   🏠 Mascotas en refugios: {$totalPets} perros\n";
            echo "   📈 Ocupación aproximada: {$occupancyRate}%\n";
        }
    }
}