<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Agregar nueva columna JSON (sin default)
        Schema::table('users', function (Blueprint $table) {
            $table->json('roles')->nullable()->after('role');
        });

        // 2. Migrar datos existentes del enum al JSON
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $currentRole = $user->role;
            $newRoles = [$currentRole]; // Convertir rol actual a array
            
            DB::table('users')
                ->where('id', $user->id)
                ->update(['roles' => json_encode($newRoles)]);
        }

        // 3. Hacer la columna NOT NULL ahora que tiene datos
        Schema::table('users', function (Blueprint $table) {
            $table->json('roles')->nullable(false)->change();
        });

        // 4. Eliminar columna enum antigua (opcional, puedes mantenerla como respaldo)
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn('role');
        // });
    }

    public function down(): void
    {
        // Restaurar datos del JSON al enum
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $roles = json_decode($user->roles, true);
            $primaryRole = $roles[0] ?? 'user'; // Tomar el primer rol como principal
            
            DB::table('users')
                ->where('id', $user->id)
                ->update(['role' => $primaryRole]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('roles');
        });
    }
};
