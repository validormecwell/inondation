<?php

namespace App\Http\Controllers;

use App\Models\TanaInonderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TanaInonderController extends Controller
{
    public function index()
    {
        // Récupérer toutes les données avec cl_danger entre 0 et 4 et géométries valides
        $inondations = DB::table('tana_inonder')
            ->select('id', 'region', 'fokontany', 'cl_danger', DB::raw('ST_AsText(geom) AS geom_text'))
            ->whereIn('cl_danger', [0, 1, 2, 3, 4])
            ->whereRaw('ST_IsValid(geom)')
            ->get();

        return response()->json($inondations);
    }

    public function getMarkers($dangerLevel)
    {
        // Ajouter une vérification pour s'assurer que le dangerLevel est valide
        if (!in_array($dangerLevel, [0, 1, 2, 3, 4])) {
            return response()->json(['error' => 'Invalid danger level'], 400);
        }
    
        $markers = DB::table('tana_inonder')
            ->select('id', 'region', 'fokontany', 'cl_danger', DB::raw('ST_AsText(geom) AS geom_text'))
            ->where('cl_danger', $dangerLevel)
            ->get();
    
        foreach ($markers as $marker) {
            $isValid = DB::select("SELECT ST_IsValid(ST_GeomFromText(?)) AS is_valid", [$marker->geom_text]);
            if (!$isValid[0]->is_valid) {
                // Log the invalid geometry
                error_log('Invalid geometry for marker ID: ' . $marker->id);
            }
        }
    
        return response()->json($markers);
    }
    public function getFokontanyCoordinates($fokontany)
{
    $fokontanyData = DB::table('tana_inonder')
        ->select('id', DB::raw('ST_AsText(geom) AS geom_text'))
        ->where('fokontany', $fokontany)
        ->first();

    if ($fokontanyData) {
        return response()->json(['id' => $fokontanyData->id, 'coordinates' => $fokontanyData->geom_text]);
    } else {
        return response()->json(['error' => 'Fokontany not found'], 404);
    }
}

}
