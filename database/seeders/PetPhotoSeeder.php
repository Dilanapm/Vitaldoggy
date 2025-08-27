<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pet;
use App\Models\PetPhoto;

class PetPhotoSeeder extends Seeder
{
    public function run(): void
    {

        // Fotos locales para perros
        $dogPhotos = [
            'storage/pets/perro1.jpg',
            'storage/pets/perro2.jpg',
            'storage/pets/perro3.jpg',
            'storage/pets/perro4.jpg',
            'storage/pets/perro5.jpg',
            'storage/pets/perro6.jpg',
        ];
        $dogs = Pet::query()->where('species', 'Perro')->get();
        $dogIndex = 0;
        foreach ($dogs as $pet) {
            if ($pet->photos()->exists()) continue;
            // Asignar foto principal y hasta 2 extras si hay
            $main = $dogPhotos[$dogIndex % count($dogPhotos)];
            PetPhoto::create([
                'pet_id'     => $pet->id,
                'photo_path' => $main,
                'is_primary' => true,
            ]);
            // Fotos extra
            $extra1 = $dogPhotos[($dogIndex+1) % count($dogPhotos)];
            $extra2 = $dogPhotos[($dogIndex+2) % count($dogPhotos)];
            PetPhoto::create([
                'pet_id'     => $pet->id,
                'photo_path' => $extra1,
                'is_primary' => false,
            ]);
            PetPhoto::create([
                'pet_id'     => $pet->id,
                'photo_path' => $extra2,
                'is_primary' => false,
            ]);
            $dogIndex++;
        }

        // Fotos locales para gatos
        $catPhotos = [
            'storage/pets/gato1.jpg',
            'storage/pets/gato2.jpg',
            'storage/pets/gato3.jpg',
        ];
        $cats = Pet::query()->where('species', 'Gato')->get();
        $catIndex = 0;
        foreach ($cats as $pet) {
            if ($pet->photos()->exists()) continue;
            $main = $catPhotos[$catIndex % count($catPhotos)];
            PetPhoto::create([
                'pet_id'     => $pet->id,
                'photo_path' => $main,
                'is_primary' => true,
            ]);
            $catIndex++;
        }

        $count = PetPhoto::count();
        echo "✅ Fotos sembradas. Total pet_photos: {$count}\n";
    }
}
