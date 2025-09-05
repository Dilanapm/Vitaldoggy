<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'roles', // Nueva columna JSON
        'shelter_id',
        'is_active',
        'phone',
        'address',
        'email_verified_at',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'roles' => 'array', // Cast JSON a array
        ];
    }

    /**
     * Set the roles attribute with default value
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->roles)) {
                $user->roles = ['user'];
            }
        });
    }
    
    /**
     * Get the shelter that the user belongs to.
     */
    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    /**
     * Get the adoption applications for this user.
     */
    public function adoptionApplications()
    {
        return $this->hasMany(AdoptionApplication::class);
    }

    // ========== MÉTODOS PARA GESTIÓN DE ROLES ==========
    
    /**
     * Helper para normalizar roles (siempre devolver array)
     */
    private function normalizeRoles($roles = null): array
    {
        if ($roles === null) {
            $roles = $this->roles;
        }
        
        if (is_string($roles)) {
            $roles = json_decode($roles, true);
        }
        
        if (!is_array($roles) || empty($roles)) {
            return ['user'];
        }
        
        return $roles;
    }
    
    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function hasRole(string $role): bool
    {
        $roles = $this->normalizeRoles();
        return in_array($role, $roles);
    }

    /**
     * Verificar si el usuario tiene alguno de los roles especificados
     */
    public function hasAnyRole(array $roles): bool
    {
        $userRoles = $this->normalizeRoles();
        return !empty(array_intersect($roles, $userRoles));
    }

    /**
     * Agregar un rol al usuario (sin duplicados)
     */
    public function addRole(string $role): void
    {
        $currentRoles = $this->normalizeRoles();
        
        if (!in_array($role, $currentRoles)) {
            $currentRoles[] = $role;
            $this->roles = $currentRoles;
            $this->save();
        }
    }

    /**
     * Remover un rol del usuario
     */
    public function removeRole(string $role): void
    {
        $currentRoles = $this->normalizeRoles();
        $this->roles = array_values(array_diff($currentRoles, [$role]));
        
        // Asegurar que siempre tenga al menos 'user'
        if (empty($this->roles)) {
            $this->roles = ['user'];
        }
        
        $this->save();
    }

    /**
     * Obtener el rol principal (primer rol del array)
     */
    public function getPrimaryRoleAttribute(): string
    {
        $roles = $this->normalizeRoles();
        return $roles[0];
    }

    /**
     * Verificar si es adoptante
     */
    public function isAdopter(): bool
    {
        return $this->hasRole('adoptante');
    }

    /**
     * Verificar si es donador
     */
    public function isDonor(): bool
    {
        return $this->hasRole('donador');
    }

    /**
     * Verificar si es voluntario
     */
    public function isVolunteer(): bool
    {
        return $this->hasRole('voluntario');
    }

    /**
     * Marcar como adoptante (cuando hace una solicitud de adopción)
     */
    public function becomeAdopter(): void
    {
        $this->addRole('adoptante');
    }

    /**
     * Marcar como donador (cuando hace una donación)
     */
    public function becomeDonor(): void
    {
        $this->addRole('donador');
    }

    /**
     * Marcar como voluntario (cuando se registra como voluntario)
     */
    public function becomeVolunteer(): void
    {
        $this->addRole('voluntario');
    }
}
