<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdoptionDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'adoption_application_id',
        'document_type',
        'file_path',
        'notes',
        'original_filename',
        'file_size',
        'mime_type',
        'is_verified',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * Tipos de documentos
     */
    const TYPE_ID = 'id';
    const TYPE_PROOF_OF_RESIDENCE = 'proof_of_residence';
    const TYPE_OTHER = 'other';

    /**
     * Relación con la solicitud de adopción
     */
    public function adoptionApplication()
    {
        return $this->belongsTo(AdoptionApplication::class);
    }

    /**
     * Relación con el usuario que verificó el documento
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Obtener el tipo de documento en español
     */
    public function getDocumentTypeLabelAttribute()
    {
        return match($this->document_type) {
            self::TYPE_ID => 'Identificación',
            self::TYPE_PROOF_OF_RESIDENCE => 'Comprobante de domicilio',
            self::TYPE_OTHER => 'Otro',
            default => 'Desconocido'
        };
    }

    /**
     * Obtener la URL completa del archivo
     */
    public function getFileUrlAttribute()
    {
        return asset('storage/adoption_documents/' . $this->file_path);
    }

    /**
     * Verificar si el documento está verificado
     */
    public function isVerified()
    {
        return $this->is_verified;
    }
}
