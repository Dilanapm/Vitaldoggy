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
        'shelter_id','caretaker_id','name','species','breed','age','gender','description',
        'health_status','adoption_status','microchip','entry_date','exit_date','weight','color',
        'is_sterilized','is_vaccinated','special_needs',
        'age_months','size','energy_level','trainability','good_with_kids','good_with_dogs',
        'good_with_cats','shedding_level','apartment_ok','external_source','external_id',
        'photo_url','city','state',
    ];

    // 2) Casts para tipos correctos
    protected $casts = [
        'entry_date'     => 'date',
        'exit_date'      => 'date',
        'weight'         => 'decimal:2',
        'is_sterilized'  => 'boolean',
        'is_vaccinated'  => 'boolean',
        'age_months'     => 'integer',
        'energy_level'   => 'integer',
        'trainability'   => 'integer',
        'shedding_level' => 'integer',
        'good_with_kids' => 'boolean',
        'good_with_dogs' => 'boolean',
        'good_with_cats' => 'boolean',
        'apartment_ok'   => 'boolean',
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

    public function adoptionApplications()
    {
        return $this->hasMany(AdoptionApplication::class);
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
