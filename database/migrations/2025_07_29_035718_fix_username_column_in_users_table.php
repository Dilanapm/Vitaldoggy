<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Verificar si existe un índice único en la columna username
        $hasUniqueIndex = false;
        
        // Verificamos los índices de la tabla
        $indexes = DB::select("SHOW INDEXES FROM users WHERE Column_name = 'username'");
        foreach ($indexes as $index) {
            if ($index->Non_unique == 0) { // 0 significa que es un índice único
                $hasUniqueIndex = true;
                break;
            }
        }
        
        // 2. Si no tiene índice único, lo creamos, pero primero actualizamos los valores
        if (!$hasUniqueIndex) {
            // Actualizar los usuarios existentes con usernames generados
            $users = User::whereNull('username')->orWhere('username', '')->get();
            
            foreach ($users as $user) {
                // Generar un username basado en el email o el nombre
                $baseUsername = Str::slug(explode('@', $user->email)[0]); // Usar la parte antes del @ del email
                
                // Asegurarse de que sea único
                $username = $baseUsername;
                $counter = 1;
                
                while (User::where('username', $username)->where('id', '!=', $user->id)->exists()) {
                    $username = $baseUsername . $counter;
                    $counter++;
                }
                
                $user->username = $username;
                $user->save();
            }
            
            // Ahora que todos los usuarios tienen un username único, podemos añadir la restricción
            Schema::table('users', function (Blueprint $table) {
                // Asegurarse de que no haya valores nulos
                $table->string('username')->nullable(false)->change();
                
                // Añadir la restricción única
                $table->unique('username');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // En caso de rollback, solo eliminamos la restricción única si existe
            $indexes = DB::select("SHOW INDEXES FROM users WHERE Column_name = 'username'");
            $hasUniqueIndex = false;
            
            foreach ($indexes as $index) {
                if ($index->Non_unique == 0) {
                    $hasUniqueIndex = true;
                    break;
                }
            }
            
            if ($hasUniqueIndex) {
                $table->dropUnique(['username']);
            }
        });
    }
};