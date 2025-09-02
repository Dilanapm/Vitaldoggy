<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Pet;
use App\Models\PetPhoto;

class CachePhotosFromDogCeo extends Command
{
    // Ejemplos:
    // sail artisan pets:cache-photos --only-test --limit=30 --per-breed=2
    // sail artisan pets:cache-photos --limit=100 --force
    protected $signature = 'pets:cache-photos
        {--only-test : Solo pets external_source=kaggle_test}
        {--limit=0 : Máx. mascotas a procesar}
        {--per-breed=1 : Fotos a descargar por mascota}
        {--force : Reemplaza la foto primaria si ya existe}';

    protected $description = 'Descarga imágenes de Dog CEO (por raza si es posible; si no, aleatoria) y las guarda en storage + pet_photos.';

    public function handle()
    {
        $per   = max(1, (int)$this->option('per-breed'));
        $force = (bool)$this->option('force');

        // Query base
        $q = Pet::query()
            ->when($this->option('only-test'), fn($q) => $q->where('external_source', 'kaggle_test'))
            ->where('species', 'Perro');

        // Si no forzamos, evitar los que ya tienen primaria
        if (!$force) {
            $q->whereDoesntHave('photos', fn($qq) => $qq->where('is_primary', true));
        }

        $limit = (int)$this->option('limit');
        if ($limit > 0) $q->limit($limit);

        $pets = $q->get();
        if ($pets->isEmpty()) {
            $this->info('No hay mascotas para procesar.');
            return 0;
        }

        // Índice de razas/subrazas desde Dog CEO
        $breedIndex = $this->fetchBreedIndex();

        $ok = 0; $fail = 0;
        foreach ($pets as $pet) {
            // Si forzamos y ya tiene primaria, la desmarcamos para reemplazar
            if ($force) {
                $pet->photos()->where('is_primary', true)->update(['is_primary' => false]);
            }

            $downloaded = 0;

            for ($i = 0; $i < $per; $i++) {
                // 1) URL por raza o aleatoria
                $url = $this->getDogCeoImageUrlForBreed($pet->breed, $breedIndex) ?: $this->getRandomDogUrl();
                if (!$url) { $this->warn("❌ {$pet->id} {$pet->name} sin URL"); $fail++; break; }

                // 2) Descargar binario
                $bin = $this->downloadImage($url);
                if (!$bin) { $this->warn("❌ {$pet->id} {$pet->name} fallo descarga"); $fail++; continue; }

                // 3) Guardar en storage/app/public/pets/{id}/...
                $ext = $this->guessExtensionFromUrlOrHeaders($url, $bin['content_type']) ?: 'jpg';
                $filename = uniqid('dog_', true).'.'.$ext;
                $relativePath = "pets/{$pet->id}/{$filename}";

                Storage::disk('public')->makeDirectory("pets/{$pet->id}");
                Storage::disk('public')->put($relativePath, $bin['body']);

                // 4) Crear registro pet_photos
                $photo = PetPhoto::create([
                    'pet_id'     => $pet->id,
                    'photo_path' => $relativePath,
                    'is_primary' => false,
                ]);

                // 5) Marcar primaria si no existe todavía
                if (!$pet->photos()->where('is_primary', true)->exists()) {
                    $photo->update(['is_primary' => true]);
                }

                $downloaded++;
                usleep(200000); // 200 ms para no saturar la API
            }

            if ($downloaded > 0) {
                $ok++;
                $this->line("✅ Pet #{$pet->id} {$pet->name} → {$downloaded} foto(s)");
            }
        }

        $this->info("Listo. Mascotas con fotos: {$ok} | Fallas: {$fail}");
        $this->line('Revisa: storage/app/public/pets/{id}/ y la tabla pet_photos.');
        return 0;
    }

    /* ================= helpers ================= */

    private function fetchBreedIndex(): array
    {
        try {
            $resp = Http::timeout(8)->get('https://dog.ceo/api/breeds/list/all');
            if ($resp->ok() && $resp->json('status') === 'success') {
                // Ej: ["bulldog"=>["boston","english","french"], "retriever"=>["golden","labrador"], ...]
                return $resp->json('message') ?? [];
            }
        } catch (\Throwable $e) {}
        return [];
    }

    private function getDogCeoImageUrlForBreed(?string $breed, array $breedIndex): ?string
    {
        if (!$breed) return null;

        // Normaliza: minúsculas, sin acentos, sin "mix", corta en coma, sin paréntesis
        $raw = Str::of($breed)->lower()->replace(['(',')'], '')
            ->before(',')->replace('mix','')->squish()->toString();
        if ($raw === '') return null;

        $norm = $this->normalizeBreed($raw);

        // Mapeos manuales para razas comunes / sub-razas
        $maps = [
            'golden retriever'   => ['retriever','golden'],
            'labrador retriever' => ['retriever','labrador'],
            'chesapeake retriever'=>['retriever','chesapeake'],
            'flat coated retriever'=>['retriever','flatcoated'],
            'german shepherd'    => ['germanshepherd'],        // breed plano
            'border collie'      => ['collie','border'],
            'french bulldog'     => ['bulldog','french'],
            'english bulldog'    => ['bulldog','english'],
            'boston bulldog'     => ['bulldog','boston'],
            'staffordshire bull terrier' => ['bullterrier','staffordshire'],
            'american staffordshire terrier' => ['bullterrier','staffordshire'],
            'jack russell terrier'=> ['terrier','russell'],
            'american pit bull terrier'=> ['pitbull'],          // aproximación
            'australian shepherd'=> ['australianshepherd'],
            'old english sheepdog'=> ['sheepdog','english'],
            'miniature pinscher' => ['pinscher','miniature'],
        ];

        foreach ($maps as $key => $slug) {
            if (Str::contains($norm, $key)) {
                return $this->fetchDogCeoBySlug($slug);
            }
        }

        // Razas "planas" (sin sub-breed) — atajos
        $flat = $this->flatBreeds();
        $flatKey = str_replace(' ', '', $norm);
        if (array_key_exists($flatKey, $flat)) {
            return $this->fetchDogCeoBySlug([$flat[$flatKey]]);
        }

        // Usar índice oficial: exacto sin subrazas
        foreach ($breedIndex as $root => $subs) {
            if (empty($subs) && $root === $flatKey) {
                return $this->fetchDogCeoBySlug([$root]);
            }
        }

        // Intentar subrazas buscando coincidencia "root sub"
        foreach ($breedIndex as $root => $subs) {
            if (!empty($subs)) {
                foreach ($subs as $sub) {
                    $candidate = $root.' '.$sub;
                    if (Str::contains($norm, $candidate) || Str::contains($candidate, $norm)) {
                        return $this->fetchDogCeoBySlug([$root, $sub]);
                    }
                }
            }
        }

        // Último intento: por raíz
        foreach ($breedIndex as $root => $subs) {
            if (Str::contains($norm, $root)) {
                return $this->fetchDogCeoBySlug([$root]);
            }
        }

        return null;
    }

    private function fetchDogCeoBySlug(array $slug): ?string
    {
        try {
            $url = count($slug) === 1
                ? "https://dog.ceo/api/breed/{$slug[0]}/images/random"
                : "https://dog.ceo/api/breed/{$slug[0]}/{$slug[1]}/images/random";

            $resp = Http::timeout(8)->get($url);
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

    private function downloadImage(string $url): ?array
    {
        try {
            $resp = Http::timeout(12)->get($url);
            if (!$resp->ok()) return null;

            $ct = $resp->header('Content-Type');
            if ($ct && !Str::startsWith($ct, 'image/')) return null;

            return ['body' => $resp->body(), 'content_type' => $ct];
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function guessExtensionFromUrlOrHeaders(?string $url, ?string $ct): ?string
    {
        if ($ct) {
            if (str_contains($ct, 'jpeg')) return 'jpg';
            if (str_contains($ct, 'png'))  return 'png';
            if (str_contains($ct, 'webp')) return 'webp';
        }
        if ($url) {
            $p = parse_url($url, PHP_URL_PATH) ?: '';
            if (preg_match('/\.(jpe?g|png|webp)$/i', $p, $m)) {
                $ext = strtolower($m[1]);
                return $ext === 'jpeg' ? 'jpg' : $ext;
            }
        }
        return null;
    }

    private function normalizeBreed(string $s): string
    {
        $s = Str::ascii($s);                 // quita acentos
        $s = str_replace(['/', '\\'], ' ', $s);
        $s = preg_replace('/[^a-z\s-]/', '', $s);
        return trim(preg_replace('/\s+/', ' ', $s));
    }

    private function flatBreeds(): array
    {
        // Map rápidos para razas comunes sin sub-breed (clave sin espacios → slug dog.ceo)
        return [
            'boxer'=>'boxer','husky'=>'husky','beagle'=>'beagle','dachshund'=>'dachshund','chihuahua'=>'chihuahua',
            'pug'=>'pug','doberman'=>'doberman','rottweiler'=>'rottweiler','pomeranian'=>'pomeranian','samoyed'=>'samoyed',
            'akita'=>'akita','shiba'=>'shiba','whippet'=>'whippet','malamute'=>'malamute','newfoundland'=>'newfoundland',
            'greyhound'=>'greyhound','weimaraner'=>'weimaraner','pointer'=>'pointer','bloodhound'=>'bloodhound',
            'airedale'=>'airedale','basenji'=>'basenji','borzoi'=>'borzoi','bouvier'=>'bouvier','collie'=>'collie',
            'kelpie'=>'kelpie','dalmatian'=>'dalmatian','ridgeback'=>'ridgeback','saluki'=>'saluki','keeshond'=>'keeshond',
        ];
    }
}
