<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shelter;

class UpdateShelterImagesSeeder extends Seeder
{
    /**
     * Seeder específico para actualizar solo las imágenes de shelters existentes
     * Útil para casos de rollback donde se pierden solo las imágenes
     */
    public function run(): void
    {
        // Mapeo directo de ID a imagen (más rápido para updates)
        $imageUpdates = [
            1 => 'albergue6.jpg',  // Refugio Patitas Felices
            2 => 'albergue7.jpg',  // Hogar Animal
            3 => 'albergue1.jpg',  // Albergue Huellitas Felices
            4 => 'albergue2.png',  // Refugio Patitas Amorosas
            5 => 'albergue3.jpg',  // Casa de Amor Animal
            6 => 'albergue4.jpg',  // Fundación Corazones Peludos
            7 => 'albergue5.jpg',  // Refugio Nueva Esperanza
        ];

        foreach ($imageUpdates as $shelterId => $imagePath) {
            $updated = Shelter::where('id', $shelterId)
                ->whereNull('image_path') // Solo actualizar si no tiene imagen
                ->update(['image_path' => $imagePath]);
            
            if ($updated) {
                echo "✅ Imagen actualizada para Shelter ID {$shelterId}: {$imagePath}\n";
            } else {
                echo "⚠️  Shelter ID {$shelterId} ya tiene imagen o no existe\n";
            }
        }

        echo "\n🎉 Actualización de imágenes completada\n";
    }
}
