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
        Schema::table('pet_photos', function (Blueprint $table) {
            // Adding the necessary columns
            $table->foreignId('pet_id')->constrained()->onDelete('cascade');
            $table->string('photo_path');
            $table->boolean('is_primary')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pet_photos', function (Blueprint $table) {
            // Dropping the foreign key constraint
            $table->dropForeign(['pet_id']);
            
            // Dropping the columns
            $table->dropColumn(['pet_id', 'photo_path', 'is_primary']);
        });
    }
};
