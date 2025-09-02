<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Pet;

class FillPhotosFromDogCeo extends Command
{
    // Ejemplos:
    // sail artisan pets:fill-photos --only-test --limit=50
    // sail artisan pets:fill-photos --limit=200
    protected $signature = 'pets:fill-photos
        {--only-test : Solo pets external_source=kaggle_test}
        {--limit=0 : Máximo de mascotas a procesar}
        {--force : Reemplaza photo_url aunque ya tenga}';

    protected $description = 'Asigna photo_url desde Dog CEO (por raza si es posible; sino, aleatoria)';

    public function handle()
    {
        $q = Pet::query()
            ->when($this->option('only-test'), fn($q) => $q->where('external_source', 'kaggle_test'))
            ->where('species', 'Perro');

        if (!$this->option('force')) {
            $q->whereNull('photo_url');
        }

        $limit = (int)$this->option('limit');
        if ($limit > 0) $q->limit($limit);

        $pets = $q->get();
        if ($pets->isEmpty()) {
            $this->info('No hay mascotas a procesar.');
            return 0;
        }

        // Cargar listado de razas/subrazas válidas para mejor matching
        $breedIndex = $this->fetchBreedIndex();

        $ok=0; $fail=0;
        foreach ($pets as $pet) {
            $url = $this->getDogCeoImageUrlForBreed($pet->breed, $breedIndex);

            if (!$url) {
                // fallback aleatorio
                $url = $this->getRandomDogUrl();
            }

            if ($url) {
                $pet->photo_url = $url;
                $pet->save();
                $ok++;
                $this->line("✅ {$pet->id} {$pet->name} ← {$url}");
            } else {
                $fail++;
                $this->warn("❌ {$pet->id} {$pet->name} sin URL");
            }

            // Pequeño sleep para no spamear
            usleep(200000); // 200ms
        }

        $this->info("Listo. OK: {$ok} | Fallas: {$fail}");
        return 0;
    }

    private function fetchBreedIndex(): array
    {
        try {
            $resp = Http::timeout(8)->get('https://dog.ceo/api/breeds/list/all');
            if ($resp->ok() && $resp->json('status') === 'success') {
                // Retorna ["bulldog" => ["boston","english","french"], "retriever" => ["golden","chesapeake",...], ...]
                return $resp->json('message') ?? [];
            }
        } catch (\Throwable $e) {}
        return [];
    }

    private function getDogCeoImageUrlForBreed(?string $breed, array $breedIndex): ?string
    {
        if (!$breed) return null;

        // Toma la primera parte antes de coma / "Mix"
        $raw = Str::of($breed)->lower()->replace(['(',')'], '')
              ->before(',')->replace('mix','')->squish()->toString();
        if ($raw === '') return null;

        // Normalizaciones comunes
        $norm = $this->normalizeBreed($raw);

        // Mapeos mano para razas frecuentes con sub-breed
        $maps = [
            'golden retriever'   => ['retriever','golden'],
            'labrador retriever' => ['retriever','labrador'],
            'chesapeake retriever'=>['retriever','chesapeake'],
            'flat coated retriever'=>['retriever','flatcoated'],
            'german shepherd'    => ['germanshepherd'], // breed “plano”
            'border collie'      => ['collie','border'],
            'french bulldog'     => ['bulldog','french'],
            'english bulldog'    => ['bulldog','english'],
            'boston bulldog'     => ['bulldog','boston'],
            'staffordshire bull terrier' => ['bullterrier','staffordshire'],
            'american staffordshire terrier' => ['bullterrier','staffordshire'], // aproximación
            'jack russell terrier'=> ['terrier','russell'],
            'american pit bull terrier'=> ['pitbull'], // aproximación
            'australian shepherd'=> ['australianshepherd'],
            'old english sheepdog'=> ['sheepdog','english'],
            'miniature pinscher' => ['pinscher','miniature'],
        ];

        // 1) Intentar con mapping manual
        foreach ($maps as $key => $slug) {
            if (Str::contains($norm, $key)) {
                return $this->fetchDogCeoBySlug($slug);
            }
        }

        // 2) Buscar coincidencia exacta como breed “plano”
        // Ej: 'boxer', 'husky', 'pomeranian', 'dachshund', 'beagle', 'chihuahua', ...
        if (array_key_exists(str_replace(' ', '', $norm), $this->flatBreeds())) {
            $slug = $this->flatBreeds()[str_replace(' ', '', $norm)];
            return $this->fetchDogCeoBySlug([$slug]);
        }
        // o si el índice lo tiene sin sub-breeds:
        $flatKey = str_replace(' ', '', $norm);
        foreach ($breedIndex as $root => $subs) {
            if (empty($subs) && $root === $flatKey) {
                return $this->fetchDogCeoBySlug([$root]);
            }
        }

        // 3) Intentar heurística en índice (sub-breeds)
        foreach ($breedIndex as $root => $subs) {
            if (!empty($subs)) {
                // 'retriever' -> ['golden','labrador',...]
                foreach ($subs as $sub) {
                    $candidate = ($root.' '.$sub);
                    if (Str::contains($norm, $candidate) || Str::contains($candidate, $norm)) {
                        return $this->fetchDogCeoBySlug([$root, $sub]);
                    }
                }
            }
        }

        // 4) Último intento: prueba raíz que contenga el nombre
        foreach ($breedIndex as $root => $subs) {
            if (Str::contains($norm, $root)) {
                return $this->fetchDogCeoBySlug([$root]);
            }
        }

        return null;
    }

    private function fetchDogCeoBySlug(array $slug)
    {
        try {
            if (count($slug) === 1) {
                // /breed/{breed}/images/random
                $resp = Http::timeout(8)->get("https://dog.ceo/api/breed/{$slug[0]}/images/random");
            } else {
                // /breed/{breed}/{subbreed}/images/random
                $resp = Http::timeout(8)->get("https://dog.ceo/api/breed/{$slug[0]}/{$slug[1]}/images/random");
            }
            if ($resp->ok() && $resp->json('status') === 'success') {
                return $resp->json('message');
            }
        } catch (\Throwable $e) {}
        return null;
    }

    private function getRandomDogUrl(): ?string
    {
        try {
            $resp = Http::timeout(8)->get('https://dog.ceo/api/breeds/image/random');
            if ($resp->ok() && $resp->json('status') === 'success') {
                return $resp->json('message');
            }
        } catch (\Throwable $e) {}
        return null;
    }

    private function normalizeBreed(string $s): string
    {
        $s = Str::ascii($s);                  // quita acentos
        $s = str_replace(['/', '\\'], ' ', $s);
        $s = preg_replace('/[^a-z\s-]/', '', $s);
        return trim(preg_replace('/\s+/', ' ', $s));
    }

    private function flatBreeds(): array
    {
        // map rápidos para razas sin sub-breed con espacios → slug válido de dog.ceo
        return [
            'boxer' => 'boxer',
            'husky' => 'husky',
            'beagle' => 'beagle',
            'dachshund' => 'dachshund',
            'chihuahua' => 'chihuahua',
            'pug' => 'pug',
            'doberman' => 'doberman',
            'rottweiler' => 'rottweiler',
            'pomeranian' => 'pomeranian',
            'samoyed' => 'samoyed',
            'akita' => 'akita',
            'shiba' => 'shiba',
            'whippet' => 'whippet',
            'malamute' => 'malamute',
            'newfoundland' => 'newfoundland',
            'greyhound' => 'greyhound',
            'weimaraner' => 'weimaraner',
            'pointer' => 'pointer',
            'bloodhound' => 'bloodhound',
            'airedale' => 'airedale',
            'basenji' => 'basenji',
            'borzoi' => 'borzoi',
            'bouvier' => 'bouvier',
            'boxer' => 'boxer',
            // agrega más si lo necesitas
        ];
    }
}
