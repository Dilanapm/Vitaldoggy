<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PetController as ApiPetController;

Route::get('/pets', [ApiPetController::class, 'index']);
Route::get('/pets/{pet}', [ApiPetController::class, 'show']);
