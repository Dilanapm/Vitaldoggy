<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('adoption_documents', function (Blueprint $table) {
            // Foreign Key (Relación)
            $table->foreignId('adoption_application_id')->constrained('adoption_applications')->onDelete('cascade');
            
            // Información del Documento
            $table->enum('document_type', ['id', 'proof_of_residence', 'other'])->default('other');
            $table->string('file_path'); // Ruta del archivo
            $table->text('notes')->nullable(); // Notas sobre el documento
            
            // Campos Adicionales Útiles
            $table->string('original_filename')->nullable(); // Nombre original del archivo
            $table->string('file_size')->nullable(); // Tamaño del archivo
            $table->string('mime_type')->nullable(); // Tipo MIME
            $table->boolean('is_verified')->default(false); // ¿Documento verificado?
            $table->timestamp('verified_at')->nullable(); // Fecha de verificación
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null'); // Quién verificó
            
            // Índices para optimizar consultas
            $table->index(['adoption_application_id', 'document_type']);
            $table->index(['adoption_application_id', 'is_verified']);
            $table->index('verified_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adoption_documents', function (Blueprint $table) {
            // Eliminar índices primero
            $table->dropIndex(['adoption_application_id', 'document_type']);
            $table->dropIndex(['adoption_application_id', 'is_verified']);
            $table->dropIndex(['verified_by']);
            
            // Eliminar foreign keys
            $table->dropForeign(['adoption_application_id']);
            $table->dropForeign(['verified_by']);
            
            // Eliminar todas las columnas
            $table->dropColumn([
                'adoption_application_id',
                'document_type',
                'file_path',
                'notes',
                'original_filename',
                'file_size',
                'mime_type',
                'is_verified',
                'verified_at',
                'verified_by'
            ]);
        });
    }
};