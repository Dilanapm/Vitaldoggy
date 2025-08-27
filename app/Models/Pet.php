<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Pet extends Model
{
    use HasFactory;

    // 1) Permitir asignación masiva de TODAS las columnas que usas
    protected $fillable = [
        'shelter_id',
        'caretaker_id',
        'name',
        'species',
        'breed',
        'age',
        'gender',
        'description',
        'health_status',
        'adoption_status',
        'microchip',
        'entry_date',
        'exit_date',
        'weight',
        'color',
        'is_sterilized',
        'is_vaccinated',
        'special_needs',

        // ===== Nuevos campos de tu migración =====
        'age_months',
        'size',              // 'S','M','L','XL'
        'energy_level',      // 1-5
        'trainability',      // 1-5
        'good_with_kids',
        'good_with_dogs',
        'good_with_cats',
        'shedding_level',    // 1-5
        'apartment_ok',
        'external_source',   // p.ej. 'kaggle'
        'external_id',
        'photo_url',
        'city',
        'state',
    ];

    // 2) Casts para tipos correctos
    protected $casts = [
        'entry_date'       => 'date',
        'exit_date'        => 'date',
        'weight'           => 'decimal:2',
        'is_sterilized'    => 'boolean',
        'is_vaccinated'    => 'boolean',

        // Nuevos
        'age_months'       => 'integer',
        'energy_level'     => 'integer',
        'trainability'     => 'integer',
        'shedding_level'   => 'integer',
        'good_with_kids'   => 'boolean',
        'good_with_dogs'   => 'boolean',
        'good_with_cats'   => 'boolean',
        'apartment_ok'     => 'boolean',
    ];

    /* ===================== Relaciones ===================== */
    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    public function caretaker()
    {
        return $this->belongsTo(Caretaker::class);
    }

    /* ===================== Scopes útiles (opcional) ===================== */

    // Solo disponibles
    public function scopeAvailable($q)
    {
        return $q->where('adoption_status', 'available');
    }

    // Filtrar por tamaño si se pasa un valor válido
    public function scopeSizeIs($q, ?string $size)
    {
        return $size ? $q->where('size', $size) : $q;
    }

    // Edad máxima en meses
    public function scopeMaxAgeMonths($q, ?int $months)
    {
        return $months ? $q->where('age_months', '<=', $months) : $q;
    }

    // Apto para departamento
    public function scopeApartmentOk($q, ?bool $flag = true)
    {
        return $flag ? $q->where('apartment_ok', true) : $q;
    }

    /* ===================== Accessors (opcional) ===================== */

    // Edad humana legible (por si quieres mostrarla en la UI)
    public function getAgeHumanAttribute(): ?string
    {
        if (!$this->age_months) return $this->age; // si ya tienes el texto original
        if ($this->age_months < 12) return $this->age_months.' meses';
        $years = intdiv($this->age_months, 12);
        $rest  = $this->age_months % 12;
        return $years.' año'.($years>1?'s':'').($rest ? " {$rest} mes".($rest>1?'es':'') : ''); // lo que se hace en esta linea es para que si es 1 año no ponga la s y si es mas de 1 año ponga la s
    }

    // Nivel de energía en texto (útil en cards)
    public function getEnergyLevelLabelAttribute(): ?string
    {
        return match((int) $this->energy_level) {
            1 => 'Muy baja', 2 => 'Baja', 3 => 'Media', 4 => 'Alta', 5 => 'Muy alta',
            default => null, // esta linea sirve para manejar casos no esperados
        };
    }
    public function photos()
{
    return $this->hasMany(PetPhoto::class);
}
    public function primaryPhoto()
    {
        return $this->hasOne(PetPhoto::class)->where('is_primary', true);
    }

    public function getPhotoUrlComputedAttribute(): ?string
{
    // 1) ¿tiene primaria?
    $p = $this->relationLoaded('primaryPhoto')
        ? $this->primaryPhoto
        : $this->primaryPhoto()->first();

    $path = $p?->photo_path ?? $this->photo_url;

    if (!$path) return null;

    // Si es URL absoluta (http/https), devuélvela tal cual:
    if (preg_match('#^https?://#i', $path)) {
        return $path;
    }

    // Si es ruta local (storage/app/public/...), conviértela:
    return Storage::url($path);
}
}
