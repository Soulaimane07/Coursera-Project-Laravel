<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Validation\Rule;
use App\Models\Etudiant;
class EtudiantController extends Controller
{
    public function index()
    {
        $etudiant = Etudiant::all();
        return response()->json($etudiant);
    }
    
    public function create(Request $req)
    {
        $req->validate([
            'CIN' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'dateNaissance' => 'required',
            'numTele' => 'required',
            'email' => 'required',
            'groupe_id' => 'required',
            'password' => 'required',


        ]);

        
        $etud = Etudiant::create([
            'CIN' => $req->CIN,
            'nom' => $req->nom,
            'prenom' => $req->prenom,
            'dateNaissance' => $req->dateNaissance,
            'numTele' => $req->numTele,
            'email' => $req->email,
            'password' => $req->password,
           'groupe_id' => $req->groupe_id,

        ]);

        return response()->json(['status' => 'success', 'etudiant' => $etud]);
    }

    public function show(Etudiant $idEtudiant)
    {
        $etudiant = Etudiant::find($idEtudiant);
        return response()->json($etudiant);
    }

    public function update(Request $request,String $idEtudiant )
    {
        $etudiant = Etudiant::find($idEtudiant);

        $request->validate([
            'CIN' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'dateNaissance' => 'required',
            'numTele' => 'required',
            'email' => 'required',
            'groupe_id' => 'required'

        ]);
        $etudiant->update([
            'CIN' => $request->CIN,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'dateNaissance' => $request->dateNaissance,
            'numTele' => $request->numTele,
            'email' => $request->email,
            'groupe_id' => $request->groupe_id,

        ]);

        return response()->json([
            'message' => 'Etudiant mis à jour avec succès',
            'data' => $etudiant
        ]);
    }

    public function destroy(String $idEtudiant)
    {
        $etud = Etudiant::find($idEtudiant);

        if (!$etud) {
            return response()->json(['message' => 'etudiant introuvable'], 404);
        } else{
            $etud->delete();
            return response()->json(['message' => 'Etudiant Supprimé'], 200);
        }
    }
}
