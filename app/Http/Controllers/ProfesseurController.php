<?php

namespace App\Http\Controllers;

use App\Models\Professeur;
use Illuminate\Http\Request;

class ProfesseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prof = Professeur::all();
        return response()->json($prof );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        $req->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required',
            'password' =>'required'
        ]);

        $prof = Professeur::create([
            'nom' => $req->nom,
            'prenom' => $req->prenom,
            'email' => $req->email,
            'password' =>bcrypt($req->input('password')),
     


        ]);

        return response()->json(['status' => 'success', 'professeur' => $prof]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Professeur $professeur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Professeur $professeur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Professeur $id)
    // {
    //     $profUpdate= Professeur::find($id);

    //     // $request->validate([
    //     //     'nom' => 'required',
    //     //     'prenom' => 'required',
    //     //     'email' => 'required',
    //     //     'password' =>'required'
    //     // ]);
    //     $profUpdate->update([
    //         'nom' => $request->nom,
    //         'prenom' => $request->prenom,
    //         'email' => $request->email,
    //         'password' => $request->password,
        
    //     ]);

    //     return response()->json([
    //         'message' => 'professeur mis à jour avec succès',
    //         'data' => $profUpdate
    //     ]);
    // }

    public function update(Request $req, $id)
{
    $req->validate([
        'nom' => 'required',
        'prenom' => 'required',
        'email' => 'required',
        'password' => 'required',
    ]);

    
    $prof = Professeur::findOrFail($id);

    if (!$prof) {
        return response()->json(['status' => 'error', 'message' => 'Professeur non trouvé.']);
    }

    // Mettre à jour les attributs du modèle
    $prof->update([
        'nom' => $req->nom,
        'prenom' => $req->prenom,
        'email' => $req->email,
        'password' => bcrypt($req->input('password')),
    ]);

    return response()->json(['status' => 'success', 'professeur' => $prof]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Professeur $id)
    {
        if (!$id) {
            return response()->json(['message' => 'prof introuvable'], 404);
        } else {
            // Appelle la méthode delete sur l'instance unique du modèle
            $id->delete();
    
            // Autres actions après la suppression si nécessaire
            return response()->json(['message' => 'professeur supprimé avec succès'], 200);
        }
    }
}
