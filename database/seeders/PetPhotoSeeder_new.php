<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pet;
use App\Models\PetPhoto;
use Illuminate\Support\Facades\File;

class PetPhotoSeeder extends Seeder
{
    public function run(): void
    {
        echo "🖼️  Sincronizando fotos de mascotas con archivos físicos...\n";
        
        // Limpiar fotos existentes para resincronizar
        PetPhoto::truncate();
        echo "🗑️  Fotos existentes eliminadas de BD\n";
        
        // Obtener todas las mascotas
        $pets = Pet::all();
        $totalPhotosAdded = 0;
        $petsWithPhotos = 0;
        
        foreach ($pets as $pet) {
            $petPhotoPath = storage_path("app/public/pets/{$pet->id}");
            
            // Verificar si existe la carpeta de fotos para esta mascota
            if (!File::exists($petPhotoPath)) {
                continue;
            }
            
            // Obtener todas las fotos de la carpeta
            $photoFiles = File::files($petPhotoPath);
            
            if (empty($photoFiles)) {
                continue;
            }
            
            echo "📁 Pet ID {$pet->id} ({$pet->name}): ";
            $photosForThisPet = 0;
            $isPrimarySet = false;
            
            foreach ($photoFiles as $photoFile) {
                $filename = $photoFile->getFilename();
                
                // Solo procesar archivos de imagen
                $extension = strtolower($photoFile->getExtension());
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    continue;
                }
                
                // Construir la ruta relativa desde storage/app/public
                $relativePath = "pets/{$pet->id}/{$filename}";
                
                // Crear registro en la base de datos
                PetPhoto::create([
                    'pet_id' => $pet->id,
                    'photo_path' => $relativePath,
                    'is_primary' => !$isPrimarySet, // La primera foto es principal
                ]);
                
                $photosForThisPet++;
                $totalPhotosAdded++;
                $isPrimarySet = true;
            }
            
            if ($photosForThisPet > 0) {
                echo "{$photosForThisPet} fotos añadidas\n";
                $petsWithPhotos++;
            }
        }
        
        echo "\n✅ Sincronización completada:\n";
        echo "   📊 Total fotos registradas: {$totalPhotosAdded}\n";
        echo "   🐕 Mascotas con fotos: {$petsWithPhotos} de " . $pets->count() . "\n";
        echo "   📂 Estructura: pets/{pet_id}/{foto.jpg}\n";
        
        // Verificar algunas fotos de ejemplo
        $this->showExamples();
    }
    
    private function showExamples()
    {
        echo "\n🔍 Ejemplos de fotos registradas:\n";
        
        $examples = PetPhoto::with('pet')
            ->select('pet_id', 'photo_path', 'is_primary')
            ->take(5)
            ->get();
            
        foreach ($examples as $photo) {
            $primary = $photo->is_primary ? '[PRINCIPAL]' : '[SECUNDARIA]';
            $petName = $photo->pet ? $photo->pet->name : 'Sin nombre';
            echo "   Pet {$photo->pet_id} ({$petName}): {$photo->photo_path} {$primary}\n";
        }
        
        // Mostrar estadísticas por mascota
        echo "\n📈 Distribución de fotos:\n";
        $distribution = PetPhoto::selectRaw('pet_id, COUNT(*) as foto_count')
            ->groupBy('pet_id')
            ->having('foto_count', '>', 1)
            ->orderBy('foto_count', 'desc')
            ->take(5)
            ->get();
            
        foreach ($distribution as $dist) {
            echo "   Pet {$dist->pet_id}: {$dist->foto_count} fotos\n";
        }
    }
}
