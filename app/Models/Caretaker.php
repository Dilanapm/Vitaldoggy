<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caretaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shelter_id',
        'position',
        'phone',
        'start_date',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
    ];

    /**
     * Get the user that owns this caretaker record.
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Esta línea establece una relación de pertenencia con el modelo User
    }

    /**
     * Get the shelter that this caretaker belongs to.
     */
    public function shelter()
    {
        return $this->belongsTo(Shelter::class); // Esta línea establece una relación de pertenencia con el modelo Shelter
    }
}