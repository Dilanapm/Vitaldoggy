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
        Schema::table('adoption_applications', function (Blueprint $table) {
            // Foreign Keys (Relaciones)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pet_id')->constrained('pets')->onDelete('cascade');
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Estado del Proceso
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            // Información de la Solicitud
            $table->text('reason'); // Motivo de adopción
            $table->timestamp('application_date')->useCurrent(); // Fecha de solicitud
            $table->timestamp('resolution_date')->nullable(); // Fecha de resolución
            $table->text('resolution_notes')->nullable(); // Notas de la decisión
            
            // Campos Adicionales Útiles
            $table->json('applicant_info')->nullable(); // Info adicional del solicitante
            $table->boolean('has_experience')->default(false); // ¿Tiene experiencia con mascotas?
            $table->text('living_situation')->nullable(); // Situación de vivienda
            $table->integer('priority_score')->default(0); // Sistema de priorización
            
            // Índices para optimizar consultas
            $table->index(['status', 'application_date']);
            $table->index(['pet_id', 'status']);
            $table->index(['user_id', 'status']);
            $table->index('resolved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            // Eliminar índices primero
            $table->dropIndex(['status', 'application_date']);
            $table->dropIndex(['pet_id', 'status']);
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['resolved_by']);
            
            // Eliminar foreign keys
            $table->dropForeign(['user_id']);
            $table->dropForeign(['pet_id']);
            $table->dropForeign(['resolved_by']);
            
            // Eliminar todas las columnas
            $table->dropColumn([
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
                'priority_score'
            ]);
        });
    }
};