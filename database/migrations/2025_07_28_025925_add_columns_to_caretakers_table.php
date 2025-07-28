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
        Schema::table('caretakers', function (Blueprint $table) {
            // Foreign Keys
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shelter_id')->constrained()->onDelete('cascade');
            // Campos específicos de caretakers
            $table->string('position');
            $table->string('phone')->nullable();
            $table->date('start_date');
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('caretakers', function (Blueprint $table) {
            // Eliminar foreign keys primero
            $table->dropForeign(['user_id']);
            $table->dropForeign(['shelter_id']);
            
            // Eliminar columnas
            $table->dropColumn(['user_id', 'shelter_id', 'position', 'phone', 'start_date', 'notes']);
        });
    }
};
