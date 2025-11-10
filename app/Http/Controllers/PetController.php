<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Muestra el listado público de mascotas usando Livewire.
     */
    public function index()
    {
        return view('pets.index');
    }

    /**
     * Muestra los detalles de una mascota específica.
     */
    public function show(Pet $pet)
    {
        // Cargar las relaciones necesarias
        $pet->load(['photos', 'shelter']);
        
        return view('pets.show', compact('pet'));
    }
}
