<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Deshabilitar verificación de claves foráneas temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Obtener todas las restricciones foráneas para la tabla donations
        $constraints = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'donations'
            AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        ");
        
        // Eliminar cada restricción
        foreach ($constraints as $constraint) {
            DB::statement("ALTER TABLE donations DROP FOREIGN KEY `{$constraint->CONSTRAINT_NAME}`");
        }
        
        // Intentar eliminar el índice problemático
        $indexes = DB::select("
            SHOW INDEX FROM donations 
            WHERE Key_name = 'donations_shelter_id_status_index'
        ");
        
        if (!empty($indexes)) {
            DB::statement("ALTER TABLE donations DROP INDEX `donations_shelter_id_status_index`");
        }
        
        // Volver a habilitar la verificación de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Si necesitas recrear los índices y restricciones, hazlo aquí
    }
};