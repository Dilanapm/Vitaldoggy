<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Pet;
use App\Models\PetPhoto;

class AttachLocalPhotos extends Command
{
    // Ejemplos:
    // sail artisan pets:attach-local --only-test --limit=20 --per-pet=1
    // sail artisan pets:attach-local --per-pet=3 --force
    protected $signature = 'pets:attach-local
        {--only-test : Solo external_source=kaggle_test}
        {--limit=0 : Máx. mascotas a procesar}
        {--per-pet=1 : Fotos aleatorias a asignar por mascota}
        {--source=storage/app/public/pets : Carpeta con imágenes sueltas}
        {--force : Reemplaza foto primaria si ya existe}';

    protected $description = 'Copia imágenes locales a storage/app/public/pets/{id}/ y crea pet_photos';

    public function handle()
    {
        $per   = max(1, (int)$this->option('per-pet'));
        $force = (bool)$this->option('force');

        // 1) Archivos fuente (jpg/png) en carpeta plana
        $sourceAbs = base_path($this->option('source'));
        if (!is_dir($sourceAbs)) {
            $this->error("No existe: {$sourceAbs}");
            return 1;
        }
        $files = collect(glob($sourceAbs.'/*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE));
        if ($files->isEmpty()) {
            $this->error("No se encontraron imágenes en {$sourceAbs}");
            return 1;
        }

        // 2) Query de mascotas
        $q = Pet::query()
            ->when($this->option('only-test'), fn($q)=>$q->where('external_source','kaggle_test'))
            ->where('species','Perro');

        if (!$force) {
            $q->whereDoesntHave('photos', fn($qq)=>$qq->where('is_primary', true));
        }

        $limit = (int)$this->option('limit');
        if ($limit > 0) $q->limit($limit);

        $pets = $q->get();
        if ($pets->isEmpty()) {
            $this->info('No hay mascotas para procesar.');
            return 0;
        }

        // 3) Procesar
        $ok=0; $skipped=0;
        foreach ($pets as $pet) {
            if (!$force && $pet->photos()->where('is_primary', true)->exists()) {
                $skipped++; continue;
            }

            $pick = $files->shuffle()->take($per);
            foreach ($pick as $src) {
                $ext  = strtolower(pathinfo($src, PATHINFO_EXTENSION));
                $name = uniqid('local_', true).'.'.$ext;
                $rel  = "pets/{$pet->id}/{$name}";

                Storage::disk('public')->makeDirectory("pets/{$pet->id}");
                copy($src, Storage::disk('public')->path($rel));

                $photo = PetPhoto::create([
                    'pet_id'     => $pet->id,
                    'photo_path' => $rel,
                    'is_primary' => false,
                ]);

                if (!$pet->photos()->where('is_primary', true)->exists()) {
                    $photo->update(['is_primary'=>true]);
                }
            }

            $ok++;
            $this->line("✅ Pet #{$pet->id} → {$per} foto(s)");
        }

        $this->info("Listo. Con fotos: {$ok} | Omitidos: {$skipped}");
        $this->line('Revisa: storage/app/public/pets/{id}/ y pet_photos.');
        return 0;
    }
}
