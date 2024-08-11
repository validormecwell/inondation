<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistiquesController extends Controller
{
    //
    public function index()
    {
        // Récupérer les statistiques de réservation par mois
        $reservationsParMois = DB::table('reservation_chambres')
            ->select(
                DB::raw('MONTH(Date_Debut) as mois'),
                DB::raw('YEAR(Date_Debut) as annee'),
                DB::raw('COUNT(DISTINCT Nom_Client) as nombre_clients')
            )
            ->groupBy('annee', 'mois')
            ->orderBy('annee', 'desc')
            ->orderBy('mois', 'desc')
            ->get();

            $labelsMois = [];
            $dataMois = [];
            foreach ($reservationsParMois as $stat) {
                $labelsMois[] = Carbon::create()->month($stat->mois)->format('F') . ' ' . $stat->annee;
                $dataMois[] = $stat->nombre_clients;
            }

        $reservationsParAn = DB::table('reservation_chambres')
        ->select(DB::raw('YEAR(Date_Debut) as year'), DB::raw('COUNT(*) as total'))
        ->groupBy('year')
        ->orderBy('year')
        ->get();

    $labelsAn = $reservationsParAn->pluck('year');
    $dataAn = $reservationsParAn->pluck('total');


        return view('home.statistiques', compact('labelsMois', 'dataMois', 'labelsAn', 'dataAn'));
    }

}
