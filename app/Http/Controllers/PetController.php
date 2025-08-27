<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Muestra el listado público de mascotas.
     */
    public function index()
    {
        // Puedes paginar o limitar según necesidad
        $pets = Pet::with('photos')->latest()->paginate(12);
        return view('pets.index', compact('pets'));
    }
}
