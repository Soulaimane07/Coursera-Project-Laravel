<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;
use App\Models\Professeur;

class GroupeController extends Controller
{
    public function index()
    {
        $groupe = Groupe::all();
        return response()->json(['status' => 'success', 'groupes' => $groupe]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        $req->validate([
            'nom' => 'required', 

        ]);

        $groupe = Groupe::create([
            'nom' => $req->nom,
           

        ]);

        return response()->json(['status' => 'success', 'groupe' => $groupe]);
    }

    
    public function update(Request $request, string  $id)
    {
        $groupeUpdate= Groupe::find($id);

        $request->validate([
            'nom' => 'required',
           
        ]);
        $groupeUpdate->update([
            'nom' => $request->nom,
        
        ]);

        return response()->json([
            'message' => 'groupe mis à jour avec succès',
            'data' => $groupeUpdate
        ]);
    }

   
    public function destroy(Groupe $id)
{
    // A ce stade, $id est déjà une instance du modèle Cour correspondant à l'identifiant fourni dans l'URL

    // Vérifie si le modèle existe
    if (!$id) {
        return response()->json(['message' => 'groupe introuvable'], 404);
    } else {
        // Appelle la méthode delete sur l'instance unique du modèle
        $id->delete();

        // Autres actions après la suppression si nécessaire

        return response()->json(['message' => 'groupe supprimé avec succès'], 200);
    }
}

public function assignerProfesseurAuGroupe($groupeId, $professeurIds) {
    $groupe = Groupe::find($groupeId);

    // Assigner des professeurs au groupe
    $groupe->professeurs()->attach($professeurIds);

    return response()->json(['message' => 'Professeurs assignés avec succès au groupe.']);
}

public function removeProfesseurFromGroupe($groupeId, $professeurId) {
    $groupe = Groupe::find($groupeId);

    if (!$groupe) {
        return response()->json(['message' => 'Groupe introuvable'], 404);
    }

    $professeur = Professeur::find($professeurId);

    if (!$professeur) {
        return response()->json(['message' => 'Professeur introuvable'], 404);
    }

    $groupe->professeurs()->detach($professeur);

    return response()->json(['message' => 'Professeur retiré avec succès .']);
}

}
