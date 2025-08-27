<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Shelter extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'phone',
        'city',
        'status',
        'description',
        'email',
        'capacity',
        'image_path',
    ];
    protected $casts = [
        'status' => 'string', // Enum cast
        'capacity' => 'integer',
    ];

    /**
     * Get the full image URL for the shelter
     */
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/shelters/' . $this->image_path);
        }
        return null; // Sin imagen por defecto por ahora
    }

    /**
     * Check if shelter has an image
     */
    public function hasImage()
    {
        return !empty($this->image_path);
    }

    /**
     * Get shelter status in Spanish
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'active' => 'Activo',
            'inactive' => 'Inactivo',
            default => 'Desconocido'
        };
    }
    public function users()
    {
        return $this->hasMany(User::class); // Esta línea establece una relación uno a muchos con el modelo User
    }
    public function caretakers()
    {
        return $this->hasMany(Caretaker::class); // Relación uno a muchos con el modelo Caretaker
    }
    public function pets()
    {
        return $this->hasMany(Pet::class); // Relación uno a muchos con el modelo Pet
    }
}
