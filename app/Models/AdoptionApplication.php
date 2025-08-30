<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdoptionApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pet_id',
        'resolved_by',
        'status',
        'reason',
        'application_date',
        'resolution_date',
        'resolution_notes',
        'applicant_info',
        'has_experience',
        'living_situation',
        'priority_score',
    ];

    protected $casts = [
        'application_date' => 'datetime',
        'resolution_date' => 'datetime',
        'applicant_info' => 'array',
        'has_experience' => 'boolean',
        'priority_score' => 'integer',
    ];

    /**
     * Estados disponibles
     */
    const STATUS_PENDING = 'pending';
    const STATUS_UNDER_REVIEW = 'under_review';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * Relación con el usuario que solicita adopción
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con la mascota a adoptar
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Relación con el usuario que resolvió la solicitud (cuidador)
     */
    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Relación con los documentos adjuntos
     */
    public function documents()
    {
        return $this->hasMany(AdoptionDocument::class);
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope para solicitudes pendientes
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Verificar si la solicitud está pendiente
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Verificar si la solicitud está en revisión
     */
    public function isUnderReview()
    {
        return $this->status === self::STATUS_UNDER_REVIEW;
    }

    /**
     * Verificar si la solicitud fue aprobada
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Verificar si la solicitud fue rechazada
     */
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Obtener el estado en español
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_UNDER_REVIEW => 'En revisión',
            self::STATUS_APPROVED => 'Aprobada',
            self::STATUS_REJECTED => 'Rechazada',
            default => 'Desconocido'
        };
    }
}
