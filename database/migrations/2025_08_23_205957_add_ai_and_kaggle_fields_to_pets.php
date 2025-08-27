<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            // ===== Normalización de Edad =====
            if (!Schema::hasColumn('pets', 'age_months')) {
                $table->unsignedSmallInteger('age_months')->nullable()->index()->after('age');
            }

            // ===== Tamaño y rasgos útiles para matching =====
            if (!Schema::hasColumn('pets', 'size')) {
                $table->enum('size', ['S','M','L','XL'])->nullable()->index()->after('weight');
            }
            if (!Schema::hasColumn('pets', 'energy_level')) {
                $table->tinyInteger('energy_level')->nullable()->after('size'); // 1-5
            }
            if (!Schema::hasColumn('pets', 'trainability')) {
                $table->tinyInteger('trainability')->nullable()->after('energy_level'); // 1-5
            }
            if (!Schema::hasColumn('pets', 'good_with_kids')) {
                $table->boolean('good_with_kids')->nullable()->after('trainability');
            }
            if (!Schema::hasColumn('pets', 'good_with_dogs')) {
                $table->boolean('good_with_dogs')->nullable()->after('good_with_kids');
            }
            if (!Schema::hasColumn('pets', 'good_with_cats')) {
                $table->boolean('good_with_cats')->nullable()->after('good_with_dogs');
            }
            if (!Schema::hasColumn('pets', 'shedding_level')) {
                $table->tinyInteger('shedding_level')->nullable()->after('good_with_cats'); // 1-5
            }
            if (!Schema::hasColumn('pets', 'apartment_ok')) {
                $table->boolean('apartment_ok')->nullable()->after('shedding_level');
            }

            // ===== Identificación del origen (Kaggle, etc.) =====
            if (!Schema::hasColumn('pets', 'external_source')) {
                $table->string('external_source', 50)->nullable()->after('apartment_ok')->index();
            }
            if (!Schema::hasColumn('pets', 'external_id')) {
                $table->string('external_id', 100)->nullable()->after('external_source')->index();
            }

            // ===== Campos prácticos del dataset =====
            if (!Schema::hasColumn('pets', 'photo_url')) {
                $table->string('photo_url')->nullable()->after('description');
            }
            if (!Schema::hasColumn('pets', 'city')) {
                $table->string('city')->nullable()->after('color')->index();
            }
            if (!Schema::hasColumn('pets', 'state')) {
                $table->string('state')->nullable()->after('city')->index();
            }

            // Opcional: índice combinado útil para búsquedas
            // Evita duplicarlo si ya lo tienes
            // $table->index(['adoption_status','species','size']);
        });
    }

    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            // Eliminar en orden inverso
            if (Schema::hasColumn('pets', 'state')) $table->dropColumn('state');
            if (Schema::hasColumn('pets', 'city')) $table->dropColumn('city');
            if (Schema::hasColumn('pets', 'photo_url')) $table->dropColumn('photo_url');
            if (Schema::hasColumn('pets', 'external_id')) $table->dropColumn('external_id');
            if (Schema::hasColumn('pets', 'external_source')) $table->dropColumn('external_source');
            if (Schema::hasColumn('pets', 'apartment_ok')) $table->dropColumn('apartment_ok');
            if (Schema::hasColumn('pets', 'shedding_level')) $table->dropColumn('shedding_level');
            if (Schema::hasColumn('pets', 'good_with_cats')) $table->dropColumn('good_with_cats');
            if (Schema::hasColumn('pets', 'good_with_dogs')) $table->dropColumn('good_with_dogs');
            if (Schema::hasColumn('pets', 'good_with_kids')) $table->dropColumn('good_with_kids');
            if (Schema::hasColumn('pets', 'trainability')) $table->dropColumn('trainability');
            if (Schema::hasColumn('pets', 'energy_level')) $table->dropColumn('energy_level');
            if (Schema::hasColumn('pets', 'size')) $table->dropColumn('size');
            if (Schema::hasColumn('pets', 'age_months')) $table->dropColumn('age_months');
        });
    }
};
