<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StandardizeShelterImagePaths extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:shelter-image-paths {--dry-run : Show what would be changed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Standardize shelter image paths to use the shelters/ prefix';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        $this->info('🔧 ' . ($dryRun ? 'Simulando' : 'Ejecutando') . ' estandarización de rutas de imágenes...');
        $this->newLine();

        try {
            // Get all shelters with image paths that don't start with 'shelters/'
            $sheltersToUpdate = DB::table('shelters')
                ->whereNotNull('image_path')
                ->where('image_path', 'NOT LIKE', 'shelters/%')
                ->get(['id', 'name', 'image_path']);

            if ($sheltersToUpdate->isEmpty()) {
                $this->info('✅ Todas las rutas de imagen ya están estandarizadas.');
                return 0;
            }

            $this->info("📊 Refugios que necesitan actualización: {$sheltersToUpdate->count()}");
            $this->newLine();

            $this->table(
                ['ID', 'Nombre', 'Ruta Actual', 'Nueva Ruta'],
                $sheltersToUpdate->map(function ($shelter) {
                    return [
                        $shelter->id,
                        $shelter->name,
                        $shelter->image_path,
                        'shelters/' . $shelter->image_path
                    ];
                })->toArray()
            );

            if ($dryRun) {
                $this->warn('🔍 Modo dry-run: No se realizaron cambios.');
                $this->info('💡 Ejecuta sin --dry-run para aplicar los cambios.');
                return 0;
            }

            if ($this->confirm('¿Deseas continuar con la actualización?')) {
                $updated = 0;
                
                foreach ($sheltersToUpdate as $shelter) {
                    $newPath = 'shelters/' . $shelter->image_path;
                    
                    DB::table('shelters')
                        ->where('id', $shelter->id)
                        ->update(['image_path' => $newPath]);
                    
                    $updated++;
                }

                $this->info("✅ Se actualizaron {$updated} registros exitosamente.");
                $this->newLine();
                $this->info('🎉 ¡Estandarización completada!');
            } else {
                $this->info('❌ Operación cancelada.');
            }

        } catch (\Exception $e) {
            $this->error("❌ Error durante la estandarización: {$e->getMessage()}");
            return 1;
        }

        return 0;
    }
}
