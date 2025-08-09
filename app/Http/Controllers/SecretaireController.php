<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;

class SecretaireController extends Controller
{
    public function dashboard()
    {
        $totalCourriers = Courrier::count();
        $courriersEnAttente = Courrier::where('status', 'pending')->count();  // exemple statut
        $totalExpeditions = Courrier::where('mouvement', 'expedition')->count();
        $totalReceptions = Courrier::where('mouvement', 'reception')->count();

        // Ex: préparation données graph mois sur 6 mois
        $graphLabels = [];
        $graphReceptionData = [];
        $graphExpeditionData = [];
        $now = \Carbon\Carbon::now();

        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $graphLabels[] = $month->format('M Y');

            $graphReceptionData[] = Courrier::where('mouvement', 'reception')
                ->whereYear('date_reception', $month->year)
                ->whereMonth('date_reception', $month->month)
                ->count();

            $graphExpeditionData[] = Courrier::where('mouvement', 'expedition')
                ->whereYear('jour_trans', $month->year)
                ->whereMonth('jour_trans', $month->month)
                ->count();
        }

        return view('secretaire.dashboard', compact(
            'totalCourriers',
            'courriersEnAttente',
            'totalExpeditions',
            'totalReceptions',
            'graphLabels',
            'graphReceptionData',
            'graphExpeditionData',
        ));
    }
}
