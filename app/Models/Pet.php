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
        'city','state',
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

    protected $with = ['primaryPhoto'];

    protected $appends = ['display_photo_url', 'thumbnail_url', 'has_primary_photo'];
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


    public function getDisplayPhotoUrlAttribute(): ?string
    {
        // No disparamos query extra si ya hiciste eager load en el controlador/Livewire:
        $primary = $this->relationLoaded('primaryPhoto') ? $this->primaryPhoto : null;

        if ($primary && $primary->photo_path) {
            return asset('storage/' . ltrim($primary->photo_path, '/'));
        }

        // Fallback: si no hay foto principal cargada, buscar la primera foto
        $firstPhoto = $this->photos()->where('is_primary', true)->first();
        if ($firstPhoto && $firstPhoto->photo_path) {
            return asset('storage/' . ltrim($firstPhoto->photo_path, '/'));
        }

        return null;
    }

    /**
     * (Opcional) miniatura; por ahora devuelve la misma URL.
     * Si luego generas thumbs (ej. /pets/{id}/thumbs/...), cambia aquí.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->display_photo_url;
    }

    /**
     * (Opcional) helper rápido para saber si tiene primaria sin N+1
     */
    public function getHasPrimaryPhotoAttribute(): bool
    {
        return $this->relationLoaded('primaryPhoto') && !is_null($this->primaryPhoto);
    }

    /* ===================== Scopes ===================== */
    public function scopeAvailable($q)
    {
        return $q->where('adoption_status', 'available');
    }

    public function scopeDogs($q)
    {
        return $q->where('species', 'Perro');
    }

    public function scopeSearch($q, ?string $term)
    {
        if (!$term) return $q;
        $s = '%'.$term.'%';
        return $q->where(function($qq) use ($s) {
            $qq->where('name', 'like', $s)
            ->orWhere('breed', 'like', $s)
            ->orWhere('description', 'like', $s);
        });
    }

    public function scopeSortByKey($q, string $sortBy)
    {
        return $q->when($sortBy === 'name',   fn($qq) => $qq->orderBy('name', 'asc'))
                ->when($sortBy === 'age',    fn($qq) => $qq->orderBy('age_months', 'asc'))
                ->when($sortBy === 'oldest', fn($qq) => $qq->orderBy('created_at', 'asc'))
                ->when(!in_array($sortBy, ['name','age','oldest']), fn($qq) => $qq->orderBy('created_at','desc'));
    }

    public function scopeStatus($q, string $status)
    {
        return $status === 'all' ? $q : $q->where('adoption_status', $status);
    }   
}
