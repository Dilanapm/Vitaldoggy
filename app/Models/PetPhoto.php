<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetPhoto extends Model
{
    protected $fillable = ['pet_id', 'photo_path', 'is_primary'];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
