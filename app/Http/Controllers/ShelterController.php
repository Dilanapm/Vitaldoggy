<?php

namespace App\Http\Controllers;

use App\Models\Shelter;
use Illuminate\Http\Request;

class ShelterController extends Controller
{
    /**
     * Display a listing of active shelters.
     */
    public function index()
    {
        $shelters = Shelter::where('status', 'active')
                          ->orderBy('name')
                          ->paginate(12);

        return view('shelters.index', compact('shelters'));
    }

    /**
     * Display the specified shelter.
     */
    public function show(Shelter $shelter)
    {
        // Cargar mascotas del refugio con sus fotos
        $shelter->load(['pets.photos']);
        
        return view('shelters.show', compact('shelter'));
    }
}
