<?php
namespace App\Http\Controllers;

use App\Models\ReservationChambre;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    // Afficher les événements sur le calendrier
    public function index()
    {
        $events = [];
        $reservations = ReservationChambre::where('statut', 'occuper')->get(); // Filtrer les réservations occupées

        foreach ($reservations as $reservation) {
            $events[] = [
                'id' => $reservation->ID,
                'title' => 'Chambre ' . $reservation->ID_Chambre . ' - type: ' . $reservation->chambre->type,
                'start' => $reservation->Date_Debut,
                'end' => $reservation->Date_Fin,
                'description' => 'Client: ' . $reservation->Nom_Client,
                'color' => '#007bff'
            ];
        }

        return view('calendar.index', ['events' => $events]);
    }

    // Ajouter une nouvelle réservation
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $reservation = ReservationChambre::create([
            'title' => $request->title,
            'Date_Debut' => $request->start_date,
            'Date_Fin' => $request->end_date,
            'statut' => 'occuper', // Par défaut, une nouvelle réservation est occupée
        ]);

        return response()->json([
            'id' => $reservation->ID,
            'start' => $reservation->Date_Debut,
            'end' => $reservation->Date_Fin,
            'title' => $reservation->title,
            'description' => 'Client: ' . $reservation->Nom_Client,
            'color' => '#007bff'
        ]);
    }

    // Mettre à jour une réservation existante
    public function update(Request $request, $id)
    {
        $reservation = ReservationChambre::find($id);
        if (!$reservation) {
            return response()->json([
                'error' => 'Unable to locate the reservation'
            ], 404);
        }

        $reservation->update([
            'Date_Debut' => $request->start_date,
            'Date_Fin' => $request->end_date,
        ]);

        return response()->json('Reservation updated');
    }

    // Supprimer une réservation
    public function destroy($id)
    {
        $reservation = ReservationChambre::find($id);
        if (!$reservation) {
            return response()->json([
                'error' => 'Unable to locate the reservation'
            ], 404);
        }

        // Change status to 'libre' instead of deleting
        $reservation->statut = 'libre';
        $reservation->save();

        return response()->json([
            'success' => true,
            'message' => 'Reservation updated to libre'
        ]);
    }
}
