<?php

namespace App\Console\Commands;

use App\Models\Shelter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FixShelterImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:shelter-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix shelter image paths and clean up inconsistent data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Iniciando corrección de rutas de imágenes...');
        $this->newLine();

        try {
            // Get shelters with images
            $shelters = Shelter::whereNotNull('image_path')->get();
            
            if ($shelters->isEmpty()) {
                $this->info('✅ No se encontraron refugios con imágenes para corregir.');
                return;
            }

            $this->info("📊 Encontrados {$shelters->count()} refugios con imágenes:");
            $this->newLine();

            $fixed = 0;
            $errors = 0;

            foreach ($shelters as $shelter) {
                $this->line("🔍 Procesando: {$shelter->name}");
                $this->line("   Ruta actual: {$shelter->image_path}");
                
                // Check if path starts with 'shelters/'
                if (strpos($shelter->image_path, 'shelters/') === 0) {
                    // Path is correct
                    $correctPath = $shelter->image_path;
                } else {
                    // Path needs to be corrected
                    $correctPath = 'shelters/' . $shelter->image_path;
                }

                // Check if file exists in storage
                if (Storage::disk('public')->exists($correctPath)) {
                    if ($shelter->image_path !== $correctPath) {
                        $shelter->update(['image_path' => $correctPath]);
                        $this->line("   ✅ <fg=green>Ruta corregida a:</fg=green> {$correctPath}");
                        $fixed++;
                    } else {
                        $this->line("   ✅ <fg=green>Ruta ya es correcta</fg=green>");
                    }
                } else {
                    $this->line("   ❌ <fg=red>Archivo no encontrado en storage</fg=red>");
                    
                    // Check if file exists in the wrong location
                    $alternativePath = str_replace('shelters/shelters/', 'shelters/', $shelter->image_path);
                    if (Storage::disk('public')->exists($alternativePath)) {
                        $shelter->update(['image_path' => $alternativePath]);
                        $this->line("   ✅ <fg=green>Archivo encontrado y ruta corregida a:</fg=green> {$alternativePath}");
                        $fixed++;
                    } else {
                        // File not found, mark for cleanup
                        $shelter->update(['image_path' => null]);
                        $this->line("   🧹 <fg=yellow>Imagen no encontrada, referencia eliminada</fg=yellow>");
                        $errors++;
                    }
                }
                $this->newLine();
            }

            $this->info("📈 Resumen:");
            $this->line("   ✅ Rutas corregidas: <fg=green>{$fixed}</fg=green>");
            $this->line("   ❌ Referencias eliminadas: <fg=yellow>{$errors}</fg=yellow>");
            $this->newLine();

            $this->info('🎉 ¡Corrección completada!');
            
        } catch (\Exception $e) {
            $this->error("❌ Error durante la corrección: {$e->getMessage()}");
            return 1;
        }

        return 0;
    }
}
