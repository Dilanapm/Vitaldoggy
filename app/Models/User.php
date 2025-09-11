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
        'username',
        'profile_photo_path'
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

    // ========== GESTIÓN DE ROLES Y LOGROS ==========
    
    /**
     * Verificar si el usuario tiene un rol específico (admin, user, caretaker)
     */
    public function hasRole(string $role): bool
    {
        // Para roles principales
        if (in_array($role, ['admin', 'user', 'caretaker'])) {
            return $this->role === $role;
        }
        
        // Para logros/achievements (adoptante, donador, voluntario)
        if (in_array($role, ['adoptante', 'donador', 'voluntario'])) {
            return $this->hasAchievement($role);
        }
        return false;
    }

    /**
     * Verificar si el usuario tiene un logro específico
     */
    public function hasAchievement(string $achievement): bool
    {
        $achievements = $this->getAchievements();
        return in_array($achievement, $achievements);
    }

    /**
     * Obtener todos los logros del usuario
     */
    public function getAchievements(): array
    {
        if (!$this->roles || !is_array($this->roles)) {
            return [];
        }
        
        // Solo devolver logros válidos
        $validAchievements = ['adoptante', 'donador', 'voluntario'];
        return array_intersect($this->roles, $validAchievements);
    }

    /**
     * Verificar si el usuario tiene alguno de los roles especificados
     */
    public function hasAnyRole(array $roles): bool
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Agregar un logro al usuario (solo para achievements, no roles)
     */
    public function addAchievement(string $achievement): void
    {
        if (!in_array($achievement, ['adoptante', 'donador', 'voluntario'])) {
            return; // Solo permitir logros válidos
        }
        
        $currentAchievements = $this->getAchievements();
        
        if (!in_array($achievement, $currentAchievements)) {
            $currentAchievements[] = $achievement;
            $this->roles = $currentAchievements;
            $this->save();
        }
    }

    /**
     * Remover un logro del usuario
     */
    public function removeAchievement(string $achievement): void
    {
        $currentAchievements = $this->getAchievements();
        $this->roles = array_values(array_diff($currentAchievements, [$achievement]));
        $this->save();
    }

    /**
     * Cambiar el rol principal del usuario (solo admin, user, caretaker)
     */
    public function changeRole(string $newRole): void
    {
        if (in_array($newRole, ['admin', 'user', 'caretaker'])) {
            $this->role = $newRole;
            $this->save();
        }
    }

    /**
     * Obtener el rol principal
     */
    public function getPrimaryRoleAttribute(): string
    {
        return $this->role ?? 'user';
    }

    /**
     * Verificar si es administrador
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Verificar si es cuidador
     */
    public function isCaretaker(): bool
    {
        return $this->role === 'caretaker';
    }

    /**
     * Verificar si es usuario normal
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Verificar si es adoptante (logro)
     */
    public function isAdopter(): bool
    {
        return $this->hasAchievement('adoptante');
    }

    /**
     * Verificar si es donador (logro)
     */
    public function isDonor(): bool
    {
        return $this->hasAchievement('donador');
    }

    /**
     * Verificar si es voluntario (logro)
     */
    public function isVolunteer(): bool
    {
        return $this->hasAchievement('voluntario');
    }

    /**
     * Marcar como adoptante (cuando hace una solicitud de adopción exitosa)
     */
    public function becomeAdopter(): void
    {
        $this->addAchievement('adoptante');
    }

    /**
     * Marcar como donador (cuando hace una donación)
     */
    public function becomeDonor(): void
    {
        $this->addAchievement('donador');
    }

    /**
     * Marcar como voluntario (cuando se registra como voluntario)
     */
    public function becomeVolunteer(): void
    {
        $this->addAchievement('voluntario');
    }

    /**
     * Get the profile photo URL attribute.
     */
    public function getProfilePhotoUrlAttribute(): ?string
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }
        
        // Retorna null para mostrar un ícono por defecto en la vista
        return null;
    }

    /**
     * Check if user has a profile photo.
     */
    public function hasProfilePhoto(): bool
    {
        return !empty($this->profile_photo_path);
    }

    // ========== MÉTODOS DE COMPATIBILIDAD ==========
    
    /**
     * Helper para normalizar roles (mantener compatibilidad)
     * @deprecated Usar getAllRoles() en su lugar
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
}
