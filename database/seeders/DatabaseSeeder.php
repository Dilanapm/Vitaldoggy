<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // Ejecutar seeders en orden de dependencias
        $this->call([
            UserSeeder::class,       // 1. Usuarios primero
            ShelterSeeder::class,    // 2. Albergues
            CaretakerSeeder::class,  // 3. Cuidadores (necesita users y shelters)
            PetSeeder::class,        // 4. Mascotas (necesita shelters y caretakers)
        ]);

        $this->command->info('🎉 ¡Todos los seeders ejecutados exitosamente!');
    }
}
