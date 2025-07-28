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
        Schema::table('curiosity_categories', function (Blueprint $table) {
            // Adding the necessary columns
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('curiosity_categories', function (Blueprint $table) {
            // Dropping the columns
            $table->dropColumn(['name', 'slug', 'description']);
        });
    }
};
