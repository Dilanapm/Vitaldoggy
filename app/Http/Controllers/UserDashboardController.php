<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = auth()->user();
        
        // Si el usuario es cuidador, mostrar dashboard específico
        if ($user->role === 'caretaker') {
            return $this->caretakerDashboard();
        }
        
        // Obtener el estado de los roles/logros para usuarios normales
        $roleAchievements = $this->getUserRoleAchievements($user);
        
        // Obtener estadísticas del usuario
        $userStats = $this->getUserStatistics($user);
        
        return view('user.dashboard', compact('roleAchievements', 'userStats'));
    }

    /**
     * Dashboard específico para cuidadores
     */
    public function caretakerDashboard(): View
    {
        /** @var User $user */
        $user = auth()->user();
        
        // Estadísticas específicas del refugio del cuidador
        $stats = $this->getCaretakerStats($user);
        
        // Notificaciones para el cuidador
        $notifications = $this->getCaretakerNotifications($user);
        
        return view('caretaker.dashboard', compact('stats', 'notifications'));
    }

    /**
     * Obtiene el estado de los roles/logros del usuario
     */
    private function getUserRoleAchievements(User $user): array
    {
        return [
            'adoptante' => [
                'unlocked' => $user->hasRole('adoptante'),
                'title' => 'Adoptante Comprometido',
                'description' => 'Adopta una mascota exitosamente',
                'icon' => '🏠',
                'color' => 'from-green-500 to-emerald-600',
                'progress' => $this->getAdoptionProgress($user),
                'requirement' => $this->getAdoptionRequirementText($user),
                'steps' => [
                    'Envía una solicitud de adopción (50%)',
                    'Completa la adopción exitosa (100%)'
                ],
            ],
            'donador' => [
                'unlocked' => $user->hasRole('donador'),
                'title' => 'Corazón Generoso', 
                'description' => 'Realiza donaciones para ayudar',
                'icon' => '💖',
                'color' => 'from-pink-500 to-rose-600',
                'progress' => $this->getDonationProgress($user),
                'requirement' => 'Realiza tu primera donación',
            ],
            'voluntario' => [
                'unlocked' => $user->hasRole('voluntario'),
                'title' => 'Alma Voluntaria',
                'description' => 'Participa como voluntario',
                'icon' => '🤝',
                'color' => 'from-blue-500 to-indigo-600', 
                'progress' => $this->getVolunteerProgress($user),
                'requirement' => 'Regístrate como voluntario',
            ],
        ];
    }

    /**
     * Obtiene estadísticas del usuario
     */
    private function getUserStatistics(User $user): array
    {
        return [
            'total_applications' => $user->adoptionApplications()->count() ?? 0,
            'successful_adoptions' => $user->adoptionApplications()
                ->where('status', 'approved')->count() ?? 0,
            'pending_applications' => $user->adoptionApplications()
                ->where('status', 'pending')->count() ?? 0,
            'total_donations' => 0, // TODO: Implementar cuando tengas modelo de donaciones
            'volunteer_hours' => 0, // TODO: Implementar cuando tengas modelo de voluntarios
        ];
    }

    /**
     * Calcula el progreso de adopción (0-100%)
     * 0% = No ha hecho solicitudes
     * 50% = Ha enviado solicitudes (pendiente/rechazada)
     * 100% = Tiene adopción exitosa
     */
    private function getAdoptionProgress(User $user): int
    {
        $totalApplications = $user->adoptionApplications()->count() ?? 0;
        $successfulAdoptions = $user->adoptionApplications()
            ->where('status', 'approved')->count() ?? 0;
        
        // Si no ha hecho ninguna solicitud
        if ($totalApplications === 0) {
            return 0;
        }
        
        // Si tiene adopciones exitosas = 100%
        if ($successfulAdoptions > 0) {
            return 100;
        }
        
        // Si tiene solicitudes pero ninguna aprobada = 50%
        return 50;
    }

    /**
     * Obtiene el texto del requisito para adopción según el progreso
     */
    private function getAdoptionRequirementText(User $user): string
    {
        $totalApplications = $user->adoptionApplications()->count() ?? 0;
        $successfulAdoptions = $user->adoptionApplications()
            ->where('status', 'approved')->count() ?? 0;
        $pendingApplications = $user->adoptionApplications()
            ->where('status', 'pending')->count() ?? 0;

        if ($successfulAdoptions > 0) {
            return '¡Adopción completada exitosamente!';
        } elseif ($pendingApplications > 0) {
            return 'Solicitud pendiente - Esperando aprobación';
        } elseif ($totalApplications > 0) {
            return 'Intenta con otra mascota para completar adopción';
        } else {
            return 'Envía tu primera solicitud de adopción';
        }
    }

    /**
     * Calcula el progreso de donaciones (0-100%)  
     */
    private function getDonationProgress(User $user): int
    {
        // TODO: Implementar cuando tengas modelo de donaciones
        // Por ahora retorna 0
        return 0;
    }

    /**
     * Calcula el progreso de voluntariado (0-100%)
     */
    private function getVolunteerProgress(User $user): int
    {
        // TODO: Implementar cuando tengas modelo de voluntarios
        // Por ahora verifica si se registró como voluntario
        return $user->hasRole('voluntario') ? 100 : 0;
    }

    /**
     * Obtiene estadísticas específicas para cuidadores
     */
    private function getCaretakerStats(User $user): array
    {
        if (!$user->shelter_id) {
            return $this->getEmptyCaretakerStats();
        }

        $shelter = $user->shelter;
        
        // Mascotas del refugio
        $shelterPets = \App\Models\Pet::where('shelter_id', $user->shelter_id);
        $totalShelterPets = $shelterPets->count();
        $availablePets = $shelterPets->where('adoption_status', 'available')->count();
        $adoptedPets = $shelterPets->where('adoption_status', 'adopted')->count();

        // Solicitudes de adopción para mascotas del refugio
        $pendingApplications = \App\Models\AdoptionApplication::whereHas('pet', function($query) use ($user) {
            $query->where('shelter_id', $user->shelter_id);
        })->where('status', 'pending')->count();

        // Aplicaciones de esta semana
        $applicationsThisWeek = \App\Models\AdoptionApplication::whereHas('pet', function($query) use ($user) {
            $query->where('shelter_id', $user->shelter_id);
        })->where('created_at', '>=', now()->startOfWeek())->count();

        // Adopciones de este mes
        $adoptionsThisMonth = \App\Models\AdoptionApplication::whereHas('pet', function($query) use ($user) {
            $query->where('shelter_id', $user->shelter_id);
        })->where('status', 'approved')
        ->where('created_at', '>=', now()->startOfMonth())->count();

        // Capacidad y ocupación
        $capacity = $shelter->capacity ?? 100;
        $occupancyPercentage = $capacity > 0 ? round(($totalShelterPets / $capacity) * 100, 1) : 0;

        return [
            'shelter_pets' => $totalShelterPets,
            'available_pets' => $availablePets,
            'adopted_pets' => $adoptedPets,
            'pending_applications' => $pendingApplications,
            'applications_this_week' => $applicationsThisWeek,
            'adoptions_this_month' => $adoptionsThisMonth,
            'capacity' => $capacity,
            'occupancy_percentage' => $occupancyPercentage,
        ];
    }

    /**
     * Obtiene notificaciones para cuidadores
     */
    private function getCaretakerNotifications(User $user): array
    {
        if (!$user->shelter_id) {
            return [];
        }

        $notifications = [];

        // Solicitudes pendientes recientes
        $recentApplications = \App\Models\AdoptionApplication::with(['pet', 'user'])
            ->whereHas('pet', function($query) use ($user) {
                $query->where('shelter_id', $user->shelter_id);
            })
            ->where('status', 'pending')
            ->where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        foreach ($recentApplications as $application) {
            $notifications[] = [
                'icon' => '📋',
                'description' => "Nueva solicitud de adopción para {$application->pet->name} por {$application->user->name}",
                'date' => $application->created_at,
                'action_url' => route('admin.adoption-applications.show', $application->id),
            ];
        }

        // Mascotas que necesitan atención
        $petsNeedingAttention = \App\Models\Pet::where('shelter_id', $user->shelter_id)
            ->where(function($query) {
                $query->where('health_status', 'Tratamiento')
                      ->orWhereNotNull('special_needs');
            })
            ->take(3)
            ->get();

        foreach ($petsNeedingAttention as $pet) {
            $notifications[] = [
                'icon' => '🏥',
                'description' => "{$pet->name} requiere atención especial: {$pet->health_status}",
                'date' => $pet->updated_at,
                'action_url' => route('admin.pets.edit', $pet->id),
            ];
        }

        // Ordenar por fecha más reciente
        usort($notifications, function($a, $b) {
            return $b['date']->timestamp - $a['date']->timestamp;
        });

        return array_slice($notifications, 0, 10); // Limitar a 10 notificaciones
    }

    /**
     * Retorna estadísticas vacías si el cuidador no tiene refugio asignado
     */
    private function getEmptyCaretakerStats(): array
    {
        return [
            'shelter_pets' => 0,
            'available_pets' => 0,
            'adopted_pets' => 0,
            'pending_applications' => 0,
            'applications_this_week' => 0,
            'adoptions_this_month' => 0,
            'capacity' => 0,
            'occupancy_percentage' => 0,
        ];
    }

    /**
     * Método para desbloquear roles automáticamente
     */
    public function checkAndUnlockRoles(User $user): void
    {
        // Verificar si debe desbloquear 'adoptante'
        $successfulAdoptions = $user->adoptionApplications()
            ->where('status', 'approved')->count() ?? 0;
        
        if ($successfulAdoptions > 0 && !$user->hasRole('adoptante')) {
            $user->becomeAdopter();
        }

        // TODO: Agregar lógica para donador y voluntario cuando implementes esas funcionalidades
    }
}
