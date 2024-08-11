<?php

namespace App\Http\Controllers;

use App\Models\Chambre;
use App\Models\Notification;
use App\Models\ReservationChambre;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{



    public function planning_reservation(Request $request)
    {
        // Récupérer le mois et l'année depuis les paramètres ou utiliser le mois et l'année en cours
        $mois = $request->input('mois', Carbon::now()->month);
        $annee = $request->input('annee', Carbon::now()->year);

        // Calculer le premier et dernier jour du mois
        $debutMois = Carbon::create($annee, $mois, 1);
        $finMois = $debutMois->copy()->endOfMonth();

        $reservations = ReservationChambre::with('chambre')->get();
        // Récupérer les réservations du mois
        $reservations = ReservationChambre::whereBetween('Date_Debut', [$debutMois->startOfMonth(), $finMois->endOfMonth()])
            ->orWhereBetween('Date_Fin', [$debutMois->startOfMonth(), $finMois->endOfMonth()])
            ->get();

        // Générer les jours du mois
        $jours = [];
        for ($i = 1; $i <= $finMois->day; $i++) {
            $jours[$i] = $debutMois->copy()->day($i)->format('l j F');
        }

        return view('home.planning_reservations', compact('reservations', 'jours', 'debutMois', 'finMois'));
    }

    public function getReservations()
    {
        // Obtenez uniquement les réservations avec le statut "occupé"
        $reservations = ReservationChambre::where('statut', 'occuper')->get();
        $events = $reservations->map(function($reservation) {
            return [
                'id' => $reservation->ID,
                'title' => 'Numero Chambre ' . $reservation->ID_Chambre . ' / Type: ' . $reservation->chambre->type,
                'start' => \Carbon\Carbon::parse($reservation->Date_Debut)->toDateString(),
                'end' => \Carbon\Carbon::parse($reservation->Date_Fin)->toDateString(),
                'description' => 'Client: ' . $reservation->Nom_Client,
                'color' => '#007bff'
            ];
        });

        return response()->json($events);
    }
   /* public function annulerReservation($ID)
    {
        try {
            $reservation = ReservationChambre::find($ID);

            if ($reservation) {
                $reservation->Statut = 'libre'; // Changer le statut en libre
                $reservation->save();

                return response()->json(['success' => true, 'message' => 'Réservation annulée avec succès.']);
            }

            return response()->json(['success' => false, 'message' => 'Réservation non trouvée.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur lors de l\'annulation de la réservation'], 500);
        }
    }*/

 // Controller: ReservationController.php
   /* public function annuler_reservation($id)
    {
        $reservation = ReservationChambre::find($id);

        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Réservation non trouvée.']);
        }

        try {
            // Mettre à jour le statut de la chambre à "libre"
            $chambre = ReservationChambre::find($reservation->Statut);
            if ($chambre) {
                $chambre->update(['Statut' => 'libre']);
            }

            // Supprimer la réservation
            $reservation->delete();

            return response()->json(['success' => true, 'message' => 'Réservation annulée avec succès.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur lors de l\'annulation de la réservation : ' . $e->getMessage()]);
        }
    }*/
    public function annuler_reservation($id)
{
    $reservation = ReservationChambre::find($id);

    if (!$reservation) {
        return response()->json(['success' => false, 'message' => 'Réservation non trouvée.']);
    }

    try {
        // Mettre à jour le statut de la réservation à "libre"
        $reservation->update(['Statut' => 'libre']);

        return response()->json(['success' => true, 'message' => 'Réservation annulée avec succès.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Erreur lors de l\'annulation de la réservation : ' . $e->getMessage()]);
    }
}










    public function create_reservation()
{
    $chambres = Chambre::all(); // Retirez le filtre par statut
    return view('home.create_reservation', compact('chambres'));
}

public function add_reservation(Request $request)
{
    $validator = Validator::make($request->all(), [
        'ID_Chambre' => 'required|integer|exists:chambres,id',
        'type_Chambre' => 'required|string',
        'Nom_Client' => 'required|string',
        'Telephone' => 'required|string',
        'Date_Debut' => 'required|date',
        'Date_Fin' => 'required|date|after_or_equal:Date_Debut',
    ], [
        'Date_Fin.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator, 'validationErrors')->withInput();
    }

    try {
        $dateDebut = new \DateTime($request->Date_Debut);
        $dateFin = new \DateTime($request->Date_Fin);
        $interval = $dateDebut->diff($dateFin);
        $nombreNuits = $interval->days + 1; // Ajouter 1 jour pour inclure la date de début

        // Vérifier si la chambre est déjà réservée pour la période demandée
        $existingReservation = ReservationChambre::where('ID_Chambre', $request->ID_Chambre)
            ->where(function($query) use ($dateDebut, $dateFin) {
                $query->whereBetween('Date_Debut', [$dateDebut, $dateFin])
                      ->orWhereBetween('Date_Fin', [$dateDebut, $dateFin])
                      ->orWhere(function($query) use ($dateDebut, $dateFin) {
                          $query->where('Date_Debut', '<=', $dateDebut)
                                ->where('Date_Fin', '>=', $dateFin);
                      });
            })
            ->where('Statut', 'occuper')
            ->exists();

        if ($existingReservation) {
            return redirect()->back()->with('reservationError', 'La chambre est déjà réservée pour les dates spécifiées.')->withInput();
        }

        // Vérifier si une réservation existe déjà pour le même client et le même numéro de chambre
        $existingReservationForClient = ReservationChambre::where('ID_Chambre', $request->ID_Chambre)
            ->where('Nom_Client', $request->Nom_Client)
            ->where('type_Chambre', $request->type_Chambre)
            ->first();

        // Trouver la chambre et calculer le prix total
        $chambre = Chambre::find($request->ID_Chambre);
        $prixTotal = $nombreNuits * $chambre->prix;

        if ($existingReservationForClient) {
            if ($existingReservationForClient->Statut == 'occuper') {
                // Mettre à jour la réservation existante si besoin
                $existingReservationForClient->Date_Debut = $request->Date_Debut;
                $existingReservationForClient->Date_Fin = $request->Date_Fin;
                $existingReservationForClient->Nombre_Nuits = $nombreNuits;
                $existingReservationForClient->Prix_Total = $prixTotal;
                $existingReservationForClient->save();

                return redirect()->route('view_reservations')->with('success', 'La réservation a été mise à jour avec succès.');
            } else {
                // Retourner une erreur si la réservation existe mais n'est pas occupée
                return redirect()->back()->with('clientError', 'Vous avez déjà réservé cette chambre. Vous pouvez changer seulement le nombre de nuits et les dates de début et de fin.')->withInput();
            }
        }

        // Créer la nouvelle réservation
        ReservationChambre::create([
            'ID_Chambre' => $request->ID_Chambre,
            'type_Chambre' => $request->type_Chambre,
            'Nom_Client' => $request->Nom_Client,
            'Telephone' => $request->Telephone,
            'Date_Debut' => $request->Date_Debut,
            'Date_Fin' => $request->Date_Fin,
            'Nombre_Nuits' => $nombreNuits,
            'Prix_Total' => $prixTotal,
            'Statut' => 'occuper' // Exemple pour marquer comme occupé
        ]);

        Notification::create([
            'type' => 'reservation',
            'message' => 'Nouvelle réservation pour la chambre ' . $request->ID_Chambre,
        ]);

        return redirect()->route('view_reservations')->with('success', 'Réservation ajoutée avec succès.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erreur lors de l\'ajout de la réservation : ' . $e->getMessage());
    }
}


public function generateInvoice($id)
{
    $reservation = ReservationChambre::find($id);
    if (!$reservation) {
        return redirect()->back()->with('error', 'Réservation non trouvée.');
    }
    $pdf = Pdf::loadView('home.invoice', ['reservation' => $reservation]);

    return $pdf->download('ticket_reservation_'.$id.'.pdf');
}




    public function view_reservations()
{
    $reservations = ReservationChambre::with('chambre')->get();
    return view('home.view_reservations', compact('reservations'));
}

public function edit_reservation($ID)
{
    $reservation = ReservationChambre::find($ID);
    $chambres = Chambre::all();

    if (!$reservation) {
        return redirect()->route('view_reservations')->with('error', 'Réservation non trouvée.');
    }

    return view('home.edit_reservation', compact('reservation', 'chambres'));
}



public function update_reservation(Request $request, $ID)
{
    $validator = Validator::make($request->all(), [
        'ID_Chambre' => 'required|integer|exists:chambres,id',
        'type_Chambre' => 'required|string|exists:chambres,type',
        'Nom_Client' => 'required|string',
        'Telephone' => 'required|string',
        'Date_Debut' => 'required|date',
        'Date_Fin' => 'required|date|after_or_equal:Date_Debut',
    ], [
        'Date_Fin.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        // Trouver la réservation
        $reservation = ReservationChambre::find($ID);
        if (!$reservation) {
            return redirect()->route('view_reservations')->with('error', 'Réservation non trouvée.');
        }

        // Calculer le nombre de nuits
        $dateDebut = new \DateTime($request->Date_Debut);
        $dateFin = new \DateTime($request->Date_Fin);
        $interval = $dateDebut->diff($dateFin);
        $nombreNuits = $interval->days + 1; // Ajouter 1 jour pour inclure la date de début

        // Trouver la chambre et calculer le prix total
        $chambre = Chambre::find($request->ID_Chambre);
        $prixTotal = $nombreNuits * $chambre->prix;

        // Mettre à jour la réservation
        $reservation->update([
            'ID_Chambre' => $request->ID_Chambre,
            'type_Chambre' => $request->type_Chambre,
            'Nom_Client' => $request->Nom_Client,
            'Telephone' => $request->Telephone,
            'Date_Debut' => $request->Date_Debut,
            'Date_Fin' => $request->Date_Fin,
            'Nombre_Nuits' => $nombreNuits,
            'Prix_Total' => $prixTotal,
            'Statut' => 'occuper' // Exemple pour marquer comme occupé
        ]);

        return redirect()->route('view_reservations')->with('success', 'Réservation mise à jour avec succès.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la réservation : ' . $e->getMessage());
    }
}



}
