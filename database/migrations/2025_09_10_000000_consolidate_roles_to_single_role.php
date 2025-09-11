<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrar datos de roles JSON a role principal (solo admin, user, caretaker)
        // Y mantener logros en roles JSON
        DB::table('users')->whereNotNull('roles')->orderBy('id')->each(function ($user) {
            $roles = json_decode($user->roles, true);
            if (is_array($roles) && !empty($roles)) {
                // Determinar el rol principal (solo admin, user, caretaker)
                $primaryRole = 'user'; // Default
                
                if (in_array('admin', $roles)) {
                    $primaryRole = 'admin';
                } elseif (in_array('caretaker', $roles)) {
                    $primaryRole = 'caretaker';
                } else {
                    $primaryRole = 'user';
                }
                
                // Filtrar solo logros (achievements) para mantener en roles JSON
                $achievements = array_intersect($roles, ['adoptante', 'donador', 'voluntario']);
                
                // Actualizar el rol principal y los logros
                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'role' => $primaryRole,
                        'roles' => json_encode(array_values($achievements)) // Solo logros
                    ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No hacer nada en el rollback para mantener integridad
    }
};
