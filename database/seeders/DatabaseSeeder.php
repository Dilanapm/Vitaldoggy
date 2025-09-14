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
         // Ejecutar seeders en orden de dependencias correcto
        $this->call([
            ShelterSeeder::class,    // 1. Refugios primero (UserSeeder los necesita)
            UserSeeder::class,       // 2. Usuarios con lógica de achievements
            // CaretakerSeeder::class,  // Ya no necesario (UserSeeder crea cuidadores)
            // PetSeeder::class,        // Ya no necesario (UserSeeder crea mascotas)
        ]);

        $this->command->info('🎉 ¡Base de datos sembrada con nueva lógica de achievements!');
        $this->command->info('   ✅ Refugios creados');
        $this->command->info('   ✅ Usuarios con roles únicos (admin/user/caretaker)');
        $this->command->info('   ✅ Achievements basados en actividades reales');
        $this->command->info('   ✅ Adopciones y donaciones de ejemplo');
        $this->command->info('   ✅ Sistema completamente funcional');
    }
}
