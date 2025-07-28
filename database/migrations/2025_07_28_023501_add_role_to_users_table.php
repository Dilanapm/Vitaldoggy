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
        Schema::table('users', function (Blueprint $table) {
            // agregando las columnas necesarias
            $table->enum('role', ['caretaker', 'user', 'donor', 'admin'])->default('user');
            $table->foreignId('shelter_id')->nullable()->constrained()->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
        });
    }

    /**
     * Reverse the migrations. 
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
        // Eliminar constraint específico por nombre
        $table->dropConstrainedForeignId('shelter_id');
        
        // Eliminar otras columnas
        $table->dropColumn(['role', 'is_active', 'phone', 'address']);
        });
    }
};