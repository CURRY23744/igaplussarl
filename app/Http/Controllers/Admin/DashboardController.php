<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bien;
use App\Models\Realisation;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Totaux simples
        $totalBiens = Bien::count();
        $totalRealisations = Realisation::count();

        // Ajouts cette semaine
        $biensSemaine = Bien::where('created_at', '>=', Carbon::now()->subWeek())->count();
        $realisationsSemaine = Realisation::where('created_at', '>=', Carbon::now()->subWeek())->count();

        // Graphique : 6 derniers mois
        $months = [];
        $biensData = [];
        $realisationsData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M Y');

            $biensData[] = Bien::whereYear('created_at', $month->year)
                               ->whereMonth('created_at', $month->month)
                               ->count();

            $realisationsData[] = Realisation::whereYear('created_at', $month->year)
                                             ->whereMonth('created_at', $month->month)
                                             ->count();
        }

        return view('admin.dashboard', compact(
            'totalBiens',
            'totalRealisations',
            'biensSemaine',
            'realisationsSemaine',
            'months',
            'biensData',
            'realisationsData'
        ));
    }
}
