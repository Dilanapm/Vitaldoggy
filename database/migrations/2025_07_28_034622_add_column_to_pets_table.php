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
        Schema::table('pets', function (Blueprint $table) {
            // Foreign Keys (Relaciones)
            $table->foreignId('shelter_id')->constrained('shelters')->onDelete('cascade');
            $table->foreignId('caretaker_id')->nullable()->constrained('caretakers')->onDelete('set null');
            
            // Información Básica
            $table->string('name'); // Nombre de la mascota
            $table->string('species')->default('Perro'); // Especie (principalmente perros)
            $table->string('breed')->nullable(); // Raza
            $table->string('age')->nullable(); // Edad (ej: "2 años", "6 meses")
            $table->enum('gender', ['Macho', 'Hembra']); // Sexo
            
            // Descripción y Características
            $table->text('description')->nullable(); // Descripción general
            $table->string('health_status')->default('Saludable'); // Estado de salud
            
            // Sistema de Adopción
            $table->enum('adoption_status', ['available', 'pending', 'adopted'])->default('available');
            
            // Identificación y Control
            $table->string('microchip')->nullable()->unique(); // Número de microchip
            $table->date('entry_date'); // Fecha de ingreso
            $table->date('exit_date')->nullable(); // Fecha de salida
            
            // Campos Adicionales Útiles
            $table->decimal('weight', 5, 2)->nullable(); // Peso en kg
            $table->string('color')->nullable(); // Color del pelaje
            $table->boolean('is_sterilized')->default(false); // ¿Está esterilizado?
            $table->boolean('is_vaccinated')->default(false); // ¿Está vacunado?
            $table->text('special_needs')->nullable(); // Necesidades especiales
            
            // Índices para optimizar consultas
            $table->index(['shelter_id', 'adoption_status']);
            $table->index(['adoption_status', 'species']);
            $table->index('caretaker_id');
            $table->index('entry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            // Eliminar índices primero
            $table->dropIndex(['shelter_id', 'adoption_status']);
            $table->dropIndex(['adoption_status', 'species']);
            $table->dropIndex(['caretaker_id']);
            $table->dropIndex(['entry_date']);
            
            // Eliminar foreign keys
            $table->dropForeign(['shelter_id']);
            $table->dropForeign(['caretaker_id']);
            
            // Eliminar todas las columnas
            $table->dropColumn([
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
                'special_needs'
            ]);
        });
    }
};