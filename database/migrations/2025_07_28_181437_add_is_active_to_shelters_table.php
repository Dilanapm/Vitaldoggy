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
        Schema::table('shelters', function (Blueprint $table) {
            // Añadir columna is_active si no existe
            if (!Schema::hasColumn('shelters', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shelters', function (Blueprint $table) {
            // Eliminar columna si existe
            if (Schema::hasColumn('shelters', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};