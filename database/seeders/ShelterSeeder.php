<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shelter;

class ShelterSeeder extends Seeder
{
    public function run(): void
    {
        // Definir array de imágenes para asignar a shelters existentes
        $shelterImages = [
            'Albergue Huellitas Felices' => 'albergue1.jpg',
            'Refugio Patitas Amorosas' => 'albergue2.png', 
            'Casa de Amor Animal' => 'albergue3.jpg',
            'Fundación Corazones Peludos' => 'albergue4.jpg',
            'Refugio Nueva Esperanza' => 'albergue5.jpg',
            'Refugio Patitas Felices' => 'albergue6.jpg',
            'Hogar Animal' => 'albergue7.jpg',
        ];

        // Actualizar shelters existentes agregando las imágenes
        foreach ($shelterImages as $shelterName => $imagePath) {
            $shelter = Shelter::where('name', $shelterName)->first();
            
            if ($shelter) {
                // Solo actualizar si no tiene imagen
                if (empty($shelter->image_path)) {
                    $shelter->update(['image_path' => $imagePath]);
                    echo "✅ Imagen actualizada para: {$shelterName} -> {$imagePath}\n";
                } else {
                    echo "⚠️  {$shelterName} ya tiene imagen: {$shelter->image_path}\n";
                }
            } else {
                // Si el shelter no existe, crearlo completo
                $shelterData = $this->getShelterData($shelterName, $imagePath);
                if ($shelterData) {
                    Shelter::create($shelterData);
                    echo "🆕 Shelter creado: {$shelterName}\n";
                }
            }
        }

        echo "\n🎉 Proceso completado: Imágenes agregadas a shelters existentes\n";
    }

    /**
     * Obtiene los datos completos del shelter por nombre
     */
    private function getShelterData(string $name, string $imagePath): ?array
    {
        $sheltersData = [
            'Albergue Huellitas Felices' => [
                'name' => 'Albergue Huellitas Felices',
                'address' => 'Calle de los Perros 123, Colonia Centro',
                'phone' => '+1234567800',
                'city' => 'Ciudad de México',
                'status' => 'active',
                'description' => 'Albergue dedicado al rescate y cuidado de perros abandonados. Contamos con instalaciones modernas y un equipo de veterinarios especializados.',
                'email' => 'huellitas@example.com',
                'capacity' => 150,
                'image_path' => $imagePath,
            ],
            'Refugio Patitas Amorosas' => [
                'name' => 'Refugio Patitas Amorosas',
                'address' => 'Avenida Libertad 456, Zona Norte',
                'phone' => '+1234567801',
                'city' => 'Guadalajara',
                'status' => 'active',
                'description' => 'Refugio con más de 10 años rescatando y rehabilitando perros. Nos especializamos en casos de abandono y maltrato.',
                'email' => 'patitas@example.com',
                'capacity' => 100,
                'image_path' => $imagePath,
            ],
            'Casa de Amor Animal' => [
                'name' => 'Casa de Amor Animal',
                'address' => 'Boulevard Sur 789, Zona Industrial',
                'phone' => '+1234567802',
                'city' => 'Monterrey',
                'status' => 'active',
                'description' => 'Centro de rescate especializado en rehabilitación de perros maltratados. Ofrecemos programas de adopción responsable.',
                'email' => 'casaamor@example.com',
                'capacity' => 80,
                'image_path' => $imagePath,
            ],
            'Fundación Corazones Peludos' => [
                'name' => 'Fundación Corazones Peludos',
                'address' => 'Calle Esperanza 321, Centro Histórico',
                'phone' => '+1234567803',
                'city' => 'Puebla',
                'status' => 'active',
                'description' => 'Fundación sin fines de lucro dedicada al rescate de perros de la calle. Trabajamos con voluntarios de toda la comunidad.',
                'email' => 'corazones@example.com',
                'capacity' => 120,
                'image_path' => $imagePath,
            ],
            'Refugio Nueva Esperanza' => [
                'name' => 'Refugio Nueva Esperanza',
                'address' => 'Avenida Reforma 654, Colonia Del Valle',
                'phone' => '+1234567804',
                'city' => 'Tijuana',
                'status' => 'active',
                'description' => 'Refugio moderno con amplias instalaciones y programas de educación sobre tenencia responsable de mascotas.',
                'email' => 'esperanza@example.com',
                'capacity' => 200,
                'image_path' => $imagePath,
            ],
        ];

        return $sheltersData[$name] ?? null;
    }
}