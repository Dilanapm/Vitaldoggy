<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Shelter;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display donations page with information and donation options
     */
    public function index()
    {
        // Obtener refugios activos para mostrar opciones de donación
        $shelters = Shelter::where('status', 'active')
                          ->orderBy('name')
                          ->get();

        // Estadísticas recientes (si existe el modelo Donation)
        $totalDonations = 0;
        $monthlyDonations = 0;
        $recentDonations = collect([]);

        return view('donations.index', compact('shelters', 'totalDonations', 'monthlyDonations', 'recentDonations'));
    }

    /**
     * Show donation form for a specific shelter
     */
    public function create(Shelter $shelter = null)
    {
        $shelters = Shelter::where('status', 'active')
                          ->orderBy('name')
                          ->get();

        return view('donations.create', compact('shelter', 'shelters'));
    }

    /**
     * Process donation
     */
    public function store(Request $request)
    {
        $request->validate([
            'shelter_id' => 'nullable|exists:shelters,id',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'amount' => 'required|numeric|min:1',
            'donation_type' => 'required|in:money,food,supplies,medicine,other',
            'message' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:card,bank_transfer,paypal,other',
        ]);

        // Por ahora solo mostraremos un mensaje de éxito
        // En una implementación real aquí se procesaría el pago
        
        return redirect()->route('donations.success')->with([
            'donation_data' => $request->all()
        ]);
    }

    /**
     * Show success page after donation
     */
    public function success()
    {
        if (!session()->has('donation_data')) {
            return redirect()->route('donations.index');
        }

        $donationData = session('donation_data');
        
        return view('donations.success', compact('donationData'));
    }
}