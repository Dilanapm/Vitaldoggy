<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shelter_id', 
        'confirmed_by',
        'amount',
        'currency',
        'type',
        'description',
        'transaction_id',
        'status',
        'donation_date',
        'confirmed_at',
        'payment_method',
        'payment_details',
        'is_anonymous',
        'donor_message',
        'thank_you_sent',
    ];

    protected $casts = [
        'donation_date' => 'datetime',
        'confirmed_at' => 'datetime',
        'payment_details' => 'array',
        'is_anonymous' => 'boolean',
        'amount' => 'decimal:2',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
