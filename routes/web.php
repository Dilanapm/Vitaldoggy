<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CaretakerController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


// Rutas públicas
Route::get('/', function () {
    return view('welcome');
})->name('home');

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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/shelters', function () {
        return view('admin.shelters.index');
    })->name('admin.shelters');
    
    // Rutas para gestión de cuidadores (caretakers) - acceso de administrador
    Route::get('/caretakers', [App\Http\Controllers\CaretakerController::class, 'index'])->name('admin.caretakers.index');
    Route::get('/caretakers/create', [App\Http\Controllers\CaretakerController::class, 'create'])->name('admin.caretakers.create');
    Route::post('/caretakers', [App\Http\Controllers\CaretakerController::class, 'store'])->name('admin.caretakers.store');
    Route::get('/caretakers/{caretaker}', [App\Http\Controllers\CaretakerController::class, 'show'])->name('admin.caretakers.show');
    Route::get('/caretakers/{caretaker}/edit', [App\Http\Controllers\CaretakerController::class, 'edit'])->name('admin.caretakers.edit');
    Route::put('/caretakers/{caretaker}', [App\Http\Controllers\CaretakerController::class, 'update'])->name('admin.caretakers.update');
    Route::patch('/caretakers/{caretaker}/toggle-status', [App\Http\Controllers\CaretakerController::class, 'toggleStatus'])->name('admin.caretakers.toggle-status');
    Route::delete('/caretakers/{caretaker}', [App\Http\Controllers\CaretakerController::class, 'destroy'])->name('admin.caretakers.destroy');
});

// Rutas para usuarios normales
Route::prefix('user')->middleware(['auth', 'verified' , 'role:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
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
    // Redirigir el dashboard a la lista de cuidadores
    Route::get('/dashboard', function () {
        return redirect()->route('caretaker.caretakers.index');
    })->name('caretaker.dashboard');
    
    // Rutas para gestión de cuidadores - acceso de cuidador
    Route::get('/caretakers', [App\Http\Controllers\CaretakerController::class, 'index'])->name('caretaker.caretakers.index');
    Route::get('/caretakers/create', [App\Http\Controllers\CaretakerController::class, 'create'])->name('caretaker.caretakers.create');
    Route::post('/caretakers', [App\Http\Controllers\CaretakerController::class, 'store'])->name('caretaker.caretakers.store');
    Route::get('/caretakers/{caretaker}', [App\Http\Controllers\CaretakerController::class, 'show'])->name('caretaker.caretakers.show');
    Route::get('/caretakers/{caretaker}/edit', [App\Http\Controllers\CaretakerController::class, 'edit'])->name('caretaker.caretakers.edit');
    Route::put('/caretakers/{caretaker}', [App\Http\Controllers\CaretakerController::class, 'update'])->name('caretaker.caretakers.update');
    Route::patch('/caretakers/{caretaker}/toggle-status', [App\Http\Controllers\CaretakerController::class, 'toggleStatus'])->name('caretaker.caretakers.toggle-status');
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
            return redirect()->route('caretaker.caretakers.index');
        default:
            return view('dashboard');
    }
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';