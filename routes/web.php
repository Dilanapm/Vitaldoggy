<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CaretakerController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


// Rutas públicas
use App\Http\Controllers\PetController;
use App\Http\Controllers\ShelterController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdoptionController;

// Página principal
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas de mascotas
Route::get('/mascotas', [PetController::class, 'index'])->name('pets.index');
Route::get('/mascotas/{pet}', [PetController::class, 'show'])->name('pets.show');
// Rutas públicas para refugios
Route::get('/refugios', [ShelterController::class, 'index'])->name('shelters.index');
Route::get('/refugios/{shelter}', [ShelterController::class, 'show'])->name('shelters.show');

// Rutas de donaciones
Route::get('/donaciones', [App\Http\Controllers\DonationController::class, 'index'])->name('donations.index');
Route::get('/donaciones/crear/{shelter?}', [App\Http\Controllers\DonationController::class, 'create'])->name('donations.create');
Route::post('/donaciones', [App\Http\Controllers\DonationController::class, 'store'])->name('donations.store');
Route::get('/donaciones/exito', [App\Http\Controllers\DonationController::class, 'success'])->name('donations.success');

// Ruta pública para servicios
Route::get('/servicios', [ServiceController::class, 'index'])->name('services.index');

// Rutas de adopción (requieren autenticación)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/adopcion/{pet}', [App\Http\Controllers\AdoptionController::class, 'create'])->name('adoption.create');
    Route::post('/adopcion/{pet}', [App\Http\Controllers\AdoptionController::class, 'store'])->name('adoption.store');
    Route::get('/mis-solicitudes', [App\Http\Controllers\AdoptionController::class, 'index'])->name('adoption.index');
});

// Rutas de verificación de email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard')->with('status', 'email-verified');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Rutas para administradores
Route::prefix('admin')->middleware(['auth','verified' , 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Gestión de Usuarios
    Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/users/create', [App\Http\Controllers\Admin\AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [App\Http\Controllers\Admin\AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::patch('/users/{user}/toggle-status', [App\Http\Controllers\Admin\AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
    
    // Gestión de Refugios
    Route::get('/shelters', [App\Http\Controllers\Admin\AdminController::class, 'shelters'])->name('admin.shelters.index');
    Route::get('/shelters/create', [App\Http\Controllers\Admin\AdminController::class, 'createShelter'])->name('admin.shelters.create');
    Route::post('/shelters', [App\Http\Controllers\Admin\AdminController::class, 'storeShelter'])->name('admin.shelters.store');
    Route::get('/shelters/{shelter}/edit', [App\Http\Controllers\Admin\AdminController::class, 'editShelter'])->name('admin.shelters.edit');
    Route::put('/shelters/{shelter}', [App\Http\Controllers\Admin\AdminController::class, 'updateShelter'])->name('admin.shelters.update');
    Route::patch('/shelters/{shelter}/toggle-status', [App\Http\Controllers\Admin\AdminController::class, 'toggleShelterStatus'])->name('admin.shelters.toggle-status');
    Route::delete('/shelters/{shelter}', [App\Http\Controllers\Admin\AdminController::class, 'destroyShelter'])->name('admin.shelters.destroy');
    Route::get('/shelters/{shelter}', [App\Http\Controllers\Admin\AdminController::class, 'showShelter'])->name('admin.shelters.show');
    Route::get('/shelters/{shelter}/edit', [App\Http\Controllers\Admin\AdminController::class, 'editShelter'])->name('admin.shelters.edit');
    Route::put('/shelters/{shelter}', [App\Http\Controllers\Admin\AdminController::class, 'updateShelter'])->name('admin.shelters.update');
    Route::delete('/shelters/{shelter}', [App\Http\Controllers\Admin\AdminController::class, 'destroyShelter'])->name('admin.shelters.destroy');
    Route::patch('/shelters/{shelter}/toggle-status', [App\Http\Controllers\Admin\AdminController::class, 'toggleShelterStatus'])->name('admin.shelters.toggle-status');
    
    // Gestión de cuidadores (caretakers) - acceso de administrador
    Route::get('/caretakers', [App\Http\Controllers\CaretakerController::class, 'index'])->name('admin.caretakers.index');
    Route::get('/caretakers/create', [App\Http\Controllers\CaretakerController::class, 'create'])->name('admin.caretakers.create');
    Route::post('/caretakers', [App\Http\Controllers\CaretakerController::class, 'store'])->name('admin.caretakers.store');
    Route::get('/caretakers/{caretaker}', [App\Http\Controllers\CaretakerController::class, 'show'])->name('admin.caretakers.show');
    Route::get('/caretakers/{caretaker}/edit', [App\Http\Controllers\CaretakerController::class, 'edit'])->name('admin.caretakers.edit');
    Route::put('/caretakers/{caretaker}', [App\Http\Controllers\CaretakerController::class, 'update'])->name('admin.caretakers.update');
    Route::patch('/caretakers/{caretaker}/toggle-status', [App\Http\Controllers\CaretakerController::class, 'toggleStatus'])->name('admin.caretakers.toggle-status');
    Route::delete('/caretakers/{caretaker}', [App\Http\Controllers\CaretakerController::class, 'destroy'])->name('admin.caretakers.destroy');
    
    // Gestión de Mascotas
    Route::get('/pets', [App\Http\Controllers\Admin\AdminController::class, 'pets'])->name('admin.pets.index');
    Route::get('/pets/create', [App\Http\Controllers\Admin\AdminController::class, 'createPet'])->name('admin.pets.create');
    Route::post('/pets', [App\Http\Controllers\Admin\AdminController::class, 'storePet'])->name('admin.pets.store');
    Route::get('/pets/{pet}', [App\Http\Controllers\Admin\AdminController::class, 'showPet'])->name('admin.pets.show');
    Route::get('/pets/{pet}/edit', [App\Http\Controllers\Admin\AdminController::class, 'editPet'])->name('admin.pets.edit');
    Route::put('/pets/{pet}', [App\Http\Controllers\Admin\AdminController::class, 'updatePet'])->name('admin.pets.update');
    Route::patch('/pets/{pet}/toggle-status', [App\Http\Controllers\Admin\AdminController::class, 'togglePetStatus'])->name('admin.pets.toggle-status');
    Route::delete('/pets/{pet}', [App\Http\Controllers\Admin\AdminController::class, 'destroyPet'])->name('admin.pets.destroy');
    Route::get('/pets/{pet}/applications', [App\Http\Controllers\Admin\AdminController::class, 'petApplications'])->name('admin.pets.applications');
});

// Rutas para usuarios normales
Route::prefix('user')->middleware(['auth', 'verified' , 'role:user'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\UserDashboardController::class, 'index'])->name('user.dashboard');
});

// Rutas para donantes
Route::prefix('donor')->middleware(['auth', 'verified' , 'role:donor'])->group(function () {
    Route::get('/dashboard', function () {
        return view('donor.dashboard');
    })->name('donor.dashboard');
});

// Rutas para cuidadores (caretakers)
Route::prefix('caretaker')->middleware(['auth', 'verified', 'role:caretaker'])->group(function () {
    // Route:prefix 'caretaker' se utiliza para agrupar las rutas relacionadas con los cuidadores.
    // Dashboard del cuidador
    Route::get('/dashboard', [App\Http\Controllers\UserDashboardController::class, 'caretakerDashboard'])->name('caretaker.dashboard');
    
    // Rutas para gestión de cuidadores - acceso de cuidador
    Route::get('/caretakers', [App\Http\Controllers\CaretakerController::class, 'index'])->name('caretaker.caretakers.index');
    Route::get('/caretakers/create', [App\Http\Controllers\CaretakerController::class, 'create'])->name('caretaker.caretakers.create');
    Route::post('/caretakers', [App\Http\Controllers\CaretakerController::class, 'store'])->name('caretaker.caretakers.store');
    Route::get('/caretakers/{caretaker}', [App\Http\Controllers\CaretakerController::class, 'show'])->name('caretaker.caretakers.show');
    Route::get('/caretakers/{caretaker}/edit', [App\Http\Controllers\CaretakerController::class, 'edit'])->name('caretaker.caretakers.edit');
    Route::put('/caretakers/{caretaker}', [App\Http\Controllers\CaretakerController::class, 'update'])->name('caretaker.caretakers.update');
    Route::patch('/caretakers/{caretaker}/toggle-status', [App\Http\Controllers\CaretakerController::class, 'toggleStatus'])->name('caretaker.caretakers.toggle-status');
    
    // Rutas para gestión de solicitudes de adopción - acceso de cuidador
    Route::get('/adoption-applications', [App\Http\Controllers\Caretaker\AdoptionApplicationController::class, 'index'])->name('caretaker.adoption-applications.index');
    Route::get('/adoption-applications/{adoptionApplication}', [App\Http\Controllers\Caretaker\AdoptionApplicationController::class, 'show'])->name('caretaker.adoption-applications.show');
    Route::patch('/adoption-applications/{adoptionApplication}/approve', [App\Http\Controllers\Caretaker\AdoptionApplicationController::class, 'approve'])->name('caretaker.adoption-applications.approve');
    Route::patch('/adoption-applications/{adoptionApplication}/reject', [App\Http\Controllers\Caretaker\AdoptionApplicationController::class, 'reject'])->name('caretaker.adoption-applications.reject');
    Route::patch('/adoption-applications/{adoptionApplication}/review', [App\Http\Controllers\Caretaker\AdoptionApplicationController::class, 'markAsUnderReview'])->name('caretaker.adoption-applications.review');
});

// Rutas compartidas entre admin y donante
Route::prefix('reports')->middleware(['auth','verified', 'roles:admin,donor'])->group(function () {
    Route::get('/donations', function () {
        return view('reports.donations');
    })->name('reports.donations');
});

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/photo', [ProfileController::class, 'deleteProfilePhoto'])->name('profile.photo.delete');
});

// Ruta para redirección después de login
Route::get('/dashboard', function () {
    if(!auth()->user()->hasVerifiedEmail()) {
        return redirect()->route('verification.notice');
    }
    
    $role = auth()->user()->role;
    
    switch ($role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'user':
            return redirect()->route('user.dashboard');
        case 'donor':
            return redirect()->route('donor.dashboard');
        case 'caretaker':
            return redirect()->route('caretaker.dashboard');
        default:
            return view('dashboard');
    }
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';