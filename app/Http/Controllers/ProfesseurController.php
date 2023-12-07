<?php

namespace App\Http\Controllers;

use App\Models\Professeur;
use App\Models\Cour;
use Illuminate\Http\Request;

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

    return response()->json(['status' => 'success', 'professeur' => $professeur]);
    }


    public function showAll()
    {
        $professeurs = Professeur::with('cours')->get();

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

        return response()->json(['status' => 'success', 'professeur' => $professeur]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required','email','regex:/@emsi\.ma$/i',
            'password' => 'required',
        ]);

        $professeur = Professeur::findOrFail($id);

        if (!$professeur) {
            return response()->json(['status' => 'error', 'message' => 'Professeur non trouvé.']);
        }

        // Mettre à jour les attributs du modèle
        $professeur->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt($request->input('password')),
        ]);

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
    public function assignCours(Request $request, $professeurId)
{
    $professeur = Professeur::find($professeurId);

    if (!$professeur) {
        return response()->json(['status' => 'error', 'message' => 'Professeur non trouvé.']);
    }

    $coursIds = $request->input('cours_ids', []);

    $professeur->cours()->attach($coursIds);

    return response()->json(['status' => 'success', 'professeur' => $professeur]);

    // return $request;
}
}
