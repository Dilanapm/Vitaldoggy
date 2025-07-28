<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

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
    ];

    protected $casts = [
        'entry_date' => 'date',
        'exit_date' => 'date',
        'weight' => 'decimal:2',
        'is_sterilized' => 'boolean',
        'is_vaccinated' => 'boolean',
    ];

    /**
     * Get the shelter that owns this pet.
     */
    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    /**
     * Get the caretaker assigned to this pet.
     */
    public function caretaker()
    {
        return $this->belongsTo(Caretaker::class);
    }
}