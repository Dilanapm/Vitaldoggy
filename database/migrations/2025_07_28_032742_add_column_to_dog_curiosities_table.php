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
        Schema::table('dog_curiosities', function (Blueprint $table) {
            // Foreign Keys (Relaciones)
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('curiosity_category_id')->constrained('curiosity_categories')->onDelete('cascade');
            
            // Campos de Contenido
            $table->string('title'); // Título del artículo
            $table->string('slug')->unique(); // URL amigable
            $table->longText('content'); // Contenido completo (HTML/Markdown)
            $table->text('excerpt')->nullable(); // Resumen corto para listados
            
            // Campos de Gestión
            $table->string('featured_image')->nullable(); // Imagen principal
            $table->unsignedBigInteger('views')->default(0); // Contador de vistas
            $table->timestamp('published_at')->nullable(); // Fecha de publicación
            
            // Campos de Estado
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false); // Para destacar artículos
            
            // Índices para optimizar consultas
            $table->index(['status', 'published_at']);
            $table->index(['curiosity_category_id', 'status']);
            $table->index('author_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dog_curiosities', function (Blueprint $table) {
            // Eliminar índices primero
            $table->dropIndex(['status', 'published_at']);
            $table->dropIndex(['curiosity_category_id', 'status']);
            $table->dropIndex(['author_id']);
            
            // Eliminar foreign keys
            $table->dropForeign(['author_id']);
            $table->dropForeign(['curiosity_category_id']);
            
            // Eliminar todas las columnas
            $table->dropColumn([
                'author_id',
                'curiosity_category_id',
                'title',
                'slug',
                'content',
                'excerpt',
                'featured_image',
                'views',
                'published_at',
                'status',
                'is_featured'
            ]);
        });
    }
};
