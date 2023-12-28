<?php

namespace App\Http\Controllers;

use App\Models\Professeur;
use App\Models\Cour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfesseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showOne($id)
    {
        $professeur = Professeur::with('cours')->find($id);

    if (!$professeur) {
        return response()->json(['status' => 'error', 'message' => 'Professeur non trouvé.'], 404);
    }

    return response()->json(['status' => 'success', 'professeurs' => $professeur]);
    }


    public function showAll()
{
    $professeurs = Professeur::with('cours','groupes')->get();

    return response()->json(['status' => 'success', 'professeurs' => $professeurs]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required','email','regex:/@emsi\.ma$/i',
            'password' => 'required',
        ]);

        $professeur = Professeur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt($request->input('password')),
        ]);

        return response()->json(['status' => 'success', 'professeurs' => $professeur]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $professeur = Professeur::findOrFail($id);

        if (!$professeur) {
            return response()->json(['status' => 'error', 'message' => 'Professeur non trouvé.']);
        }

        // Mettre à jour les attributs du modèle
        // $professeur->update([
        //     'nom' => $request->nom,
        //     'prenom' => $request->prenom,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->input('password')),
        // ]);

        $professeur->nom = $request->input('nom');
        $professeur->prenom = $request->input('prenom');
        $professeur->email = $request->input('email');

        if($request->input('password')){
            $professeur->password = $request->input('password');
        }

        $professeur->update();

        return response()->json(['status' => 'success', 'professeur' => $professeur]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $professeur = Professeur::find($id);

        if (!$professeur) {
            return response()->json(['status' => 'error', 'message' => 'Professeur non trouvé.']);
        }

        // Supprimer le professeur
        $professeur->delete();

        return response()->json(['status' => 'success', 'message' => 'Professeur supprimé avec succès']);
    }

    /**
     * Assigner des cours à un professeur.
     */
//     public function assignCours(Request $request, $professeurId)
// {
//     $professeur = Professeur::find($professeurId);

//     if (!$professeur) {
//         return response()->json(['status' => 'error', 'message' => 'Professeur non trouvé.']);
//     }

//     $coursIds = $request->input('cours_ids');

//     $professeur->cours()->sync($coursIds);

//     return response()->json(['status' => 'success', 'professeur' => $professeur]);
// }

public function assignCours(Request $request, $professeurId)
{
    $professeur = Professeur::find($professeurId);

    if (!$professeur) {
        return response()->json(['status' => 'error', 'message' => 'Professeur non trouvé.']);
    }

    $coursIds = $request->input('cours_ids');

    $professeur->cours()->attach($coursIds);

    return response()->json(['status' => 'success', 'professeur' => $professeur]);
}

// public function removeCours(Request $request, $professeurId)
// {
//     $professeur = Professeur::find($professeurId);

//     if (!$professeur) {
//         return response()->json(['status' => 'error', 'message' => 'Professeur non trouvé.']);
//     }

//     $coursIdToRemove = $request->input('cours_id');

//     $professeur->cours()->detach($coursIdToRemove);

//     $coursActuels = $professeur->cours;

//     return response()->json(['status' => 'success', 'cours' => $coursActuels]);
// }


public function removeCours(Request $request, $professeurId)
{
    $professeur = Professeur::find($professeurId);

    if (!$professeur) {
        return response()->json(['status' => 'error', 'message' => 'Professeur non trouvé.']);
    }

    $coursIdToRemove = $request->input('cour_id');

    // Supprimez le cours spécifique de la table pivot
    DB::table('cours_professeur')
        ->where('professeur_id', $professeurId)
        ->where('cour_id', $coursIdToRemove)
        ->delete();

    // Récupérez à nouveau les cours actuels du professeur après la mise à jour
    $coursActuels = $professeur->cours;

    return response()->json(['status' => 'success', 'cours' => $coursActuels]);
}






public function assignGroupes(Request $request, $professeurId)
    {
        $professeur = Professeur::findOrFail($professeurId);

        if (!$professeur) {
            return response()->json(['status' => 'error', 'message' => 'Professeur non trouvé.']);
        }

        $groupesIds = $request->input('groupes_ids');

        // Synchroniser les groupes du professeur avec les nouveaux groupes
        $professeur->groupes()->attach($groupesIds);

        return response()->json(['status' => 'success', 'message' => 'Groupes attribués avec succès.']);
    }


    /**
     * Mettre à jour les groupes d'un professeur.
     */
    public function updateGroupes(Request $request, $professeurId)
    {
        $professeur = Professeur::findOrFail($professeurId);

        if (!$professeur) {
            return response()->json(['status' => 'error', 'message' => 'Professeur non trouvé.']);
        }

        $groupesIds = $request->input('groupes_ids');

        // Mettre à jour les groupes du professeur avec les nouveaux groupes
        $professeur->groupes()->sync($groupesIds);

        return response()->json(['status' => 'success', 'message' => 'Groupes mis à jour avec succès.']);
    }
}
