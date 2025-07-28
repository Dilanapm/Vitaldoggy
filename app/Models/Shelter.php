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
    ];
    protected $casts = [
        'status' => 'string', // Enum cast
        'capacity' => 'integer',
    ];
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
