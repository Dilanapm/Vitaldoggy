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
        Schema::table('donations', function (Blueprint $table) {
            // Foreign Keys (Relaciones)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('shelter_id')->constrained('shelters')->onDelete('cascade');
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Información de la Donación
            $table->decimal('amount', 10, 2); // Cantidad (hasta 99,999,999.99)
            $table->string('currency', 3)->default('USD'); // Moneda (ISO code)
            $table->enum('type', ['money', 'goods', 'service']); // Tipo de donación
            $table->text('description'); // Descripción detallada
            $table->string('transaction_id', 100)->nullable()->unique(); // ID de transacción
            
            // Control del Proceso
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('donation_date')->useCurrent(); // Fecha de donación
            $table->timestamp('confirmed_at')->nullable(); // Fecha de confirmación
            
            // Campos Adicionales Útiles
            $table->string('payment_method')->nullable(); // Método de pago (PayPal, Stripe, etc.)
            $table->json('payment_details')->nullable(); // Detalles adicionales del pago
            $table->boolean('is_anonymous')->default(false); // ¿Donación anónima?
            $table->text('donor_message')->nullable(); // Mensaje del donante
            $table->text('thank_you_sent')->nullable(); // ¿Se envió agradecimiento?
            
            // Índices para optimizar consultas
            $table->index(['shelter_id', 'status']);
            $table->index(['user_id', 'status']);
            $table->index(['status', 'donation_date']);
            $table->index(['type', 'status']);
            $table->index('confirmed_by');
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // Eliminar índices primero
            $table->dropIndex(['shelter_id', 'status']);
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['status', 'donation_date']);
            $table->dropIndex(['type', 'status']);
            $table->dropIndex(['confirmed_by']);
            $table->dropIndex(['transaction_id']);
            
            // Eliminar foreign keys
            $table->dropForeign(['user_id']);
            $table->dropForeign(['shelter_id']);
            $table->dropForeign(['confirmed_by']);
            
            // Eliminar todas las columnas
            $table->dropColumn([
                'user_id',
                'shelter_id',
                'confirmed_by',
                'amount',
                'currency',
                'type',
                'description',
                'transaction_id',
                'status',
                'donation_date',
                'confirmed_at',
                'payment_method',
                'payment_details',
                'is_anonymous',
                'donor_message',
                'thank_you_sent'
            ]);
        });
    }
};