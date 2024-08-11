<?php

namespace App\Http\Controllers;

use App\Models\Chambre;
use App\Models\Notification;
use App\Models\salle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function home(){

        // Récupérer les notifications non lues
    $notifications = Notification::where('is_read', false)->get();

    // Passer les notifications à la vue
    return view('home.index', compact('notifications'));
    }

    public function create_chambre(){
        return view('home.create_chambre');
    }


    public function add_chambre(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'type' => 'required|string',
            'prix' => 'required|numeric',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Chambre::create([
                'id' => $request->id,
                'type' => $request->type,
                'prix' => $request->prix,

            ]);

            return redirect()->route('view_chambre')->with('success', 'Chambre ajoutée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de la chambre : ' . $e->getMessage());
        }
    }

    public function view_chambre(){
        $data = Chambre::all();
        return view('home.liste_chambre',compact('data'));
    }

    public function delete_chambre($id)
    {
        $data = Chambre::find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Chambre non trouvée.');
        }

        $data->delete();

        return redirect()->back()->with('success', 'Chambre supprimée avec succès.');
    }

    public function edit_chambre($id)
    {
        $data = Chambre::find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Chambre non trouvée.');
        }

        return view('home.edit_chambre', compact('data'));
    }


    public function update_chambre(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'type' => 'required|string',
            'prix' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $chambre = Chambre::find($id);

        if (!$chambre) {
            return redirect()->back()->with('error', 'Chambre non trouvée.');
        }

        try {
            $chambre->update([
                'id' => $request->id,
                'type' => $request->type,
                'prix' => $request->prix,
            ]);

            return redirect()->route('view_chambre')->with('success', 'Chambre mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la chambre : ' . $e->getMessage());
        }
    }

    public function create_salle(){
        return view('home.create_salle');
    }

    public function add_salle(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'num_salle' => 'required|integer|unique:salles,num_salle',
            'type' => 'required|string',
            'prix' => 'required|integer',
            'capacite' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            salle::create([
                'num_salle' => $request->num_salle,
                'type' => $request->type,
                'prix' => $request->prix,
                'capacite' => $request->capacite,

            ]);

            return redirect()->route('view_salle')->with('success', 'salle ajoutée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de la salle : ' . $e->getMessage());
        }
    }

    public function view_salle(){
        $data = salle::all();
        return view('home.liste_salle',compact('data'));
    }

    public function delete_salle($id)
    {
        $data = salle::find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'salle non trouvée.');
        }

        $data->delete();

        return redirect()->back()->with('success', 'salle supprimée avec succès.');
    }

    public function edit_salle($id)
    {
        $data = salle::find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Salle non trouvée.');
        }

        return view('home.edit_salle', compact('data'));
    }



    public function update_salle(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
           'num_salle' => 'required|integer',
            'type' => 'required|string',
            'prix' => 'required|numeric',
            'capacite' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $chambre = salle::find($id);

        if (!$chambre) {
            return redirect()->back()->with('error', 'Chambre non trouvée.');
        }

        try {
            $chambre->update([
                'num_salle' => $request->num_salle,
                'type' => $request->type,
                'prix' => $request->prix,
                'capacite' => $request->capacite,
            ]);

            return redirect()->route('view_salle')->with('success', 'Chambre mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la chambre : ' . $e->getMessage());
        }
    }

}
