<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display the services page.
     */
    public function index()
    {
        return view('services.index');
    }
}
