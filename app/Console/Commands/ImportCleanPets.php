<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Models\Pet;

class ImportCleanPets extends Command
{
    // Ejemplo de uso:
    // sail artisan pets:import-clean storage/app/public/kaggle/mascotas_adop.csv --limit=20 --dry-run
    protected $signature = 'pets:import-clean {csv_path} {--limit=0} {--dry-run}';

    protected $description = 'Importa un CSV ya limpio (columnas compatibles con tabla pets) con normalización de nulls/booleans';

    public function handle()
    {
        $path = $this->argument('csv_path');
        if (!file_exists($path)) {
            $this->error("No existe el archivo: $path");
            return 1;
        }

        // Carga CSV con cabeceras
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);
        $rows = (new Statement())->process($csv);

        $limit = (int)$this->option('limit');
        $dry   = (bool)$this->option('dry-run');

        // columnas booleanas de tu tabla
        $boolCols = [
            'is_sterilized','is_vaccinated',
            'good_with_kids','good_with_dogs','good_with_cats','apartment_ok',
        ];

        // columnas int “suaves”
        $intCols = ['shelter_id','caretaker_id','age_months'];

        $i=0; $created=0; $updated=0;

        foreach ($rows as $r) {
            $i++; if ($limit>0 && $i>$limit) break;

            // "" => null
            foreach ($r as $k => $v) {
                if ($v === '') $r[$k] = null;
            }

            // booleans a 1/0/null
            foreach ($boolCols as $b) {
                if (!array_key_exists($b, $r)) continue;
                $r[$b] = $this->to01($r[$b]);
            }

            // ints
            foreach ($intCols as $c) {
                if (!array_key_exists($c, $r)) continue;
                $r[$c] = is_null($r[$c]) ? null : (int) $r[$c];
            }

            // upsert por (external_source, external_id) si están presentes
            $unique = [
                'external_source' => $r['external_source'] ?? null,
                'external_id'     => $r['external_id'] ?? null,
            ];

            if ($dry) {
                $this->line("DRY: {$r['name']} | breed={$r['breed']} | gender={$r['gender']} | size={$r['size']}");
                continue;
            }

            $pet = null;
            if ($unique['external_source'] && $unique['external_id']) {
                $pet = Pet::where($unique)->first();
            }

            if ($pet) {
                $pet->fill($r)->save();
                $updated++;
            } else {
                Pet::create($r);
                $created++;
            }
        }

        $this->info("Leídas: $i | Creadas: $created | Actualizadas: $updated");
        return 0;
    }

    private function to01($v)
    {
        if (is_null($v)) return null;
        $s = is_string($v) ? strtolower(trim($v)) : $v;
        if ($s===true || $s==='true' || $s==='1' || $s==='yes' || $s==='y' || $s==='si' || $s==='sí') return 1;
        if ($s===false|| $s==='false'|| $s==='0'|| $s==='no'  || $s==='n') return 0;
        if ($s===1 || $s===0) return $s;
        return null;
    }
}
