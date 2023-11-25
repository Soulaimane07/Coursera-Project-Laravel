<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use Illuminate\Http\Request;

class CourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cour = Cour::all();
        return response()->json($cour );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        $req->validate([
            'image' => 'required',
            'libelle' => 'required',
            'desc' => 'required',
            'dateDebut' => 'required',
            'dateFin' => 'required',
           

        ]);

        $cour = new Cour;

        $cour->libelle = $req->input('libelle');
        $cour->desc = $req->input('desc');
        $cour->dateDebut = $req->input('dateDebut');
        $cour->dateFin = $req->input('dateFin');




        // $cour = Cour::create([
        //     // 'image' => $req->image,
        //     'libelle' => $req->libelle,
        //     'desc' => $req->desc,
        //     'dateDebut' => $req->dateDebut,
        //     'dateFin' => $req->dateFin,
        // ]);

        if($req->hasfile('image')){
            $file = $req->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '' .$extention;
            $file->move('uploads/', $filename);
            $cour->image = $filename;
        }

        $cour->save();


        // if($req->hasfile('image')){

        // return $req->file('image');
        // return response()->json(['status' => 'success', 'cour' => $cour]);
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
    public function show(Cour $cour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cour $cour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string  $id)
    {
        

        $request->validate([
            'image' => 'required',
            'libelle' => 'required',
            'desc' => 'required',
            'dateDebut' => 'required',
            'dateFin' => 'required',
        ]);

        $cour = Cour::find($req->id);

        $cour->libelle = $req->libelle;
        $cour->desc = $req->desc;
        $cour->dateDebut = $req->dateDebut;
        $cour->dateFin = $req->dateFin;

        if($req->hasfile('image')){
            $file = $req->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '' .$extention;
            $file->move('uploads/', $filename);
            $cour->image = $filename;
        }

        $cour->save();

        // $courUpdate->update([
        //     'image' => $request->image,
        //     'libelle' => $request->libelle,
        //     'desc' => $request->desc,
        //     'dateDebut' => $request->dateDebut,
        //     'dateFin' => $request->dateFin,

        // ]);

        return response()->json([
            'message' => 'cours mis à jour avec succès',
            'data' => $courUpdate
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {
    //     $cour = Cour::find($id);

    //     if (!$cour) {
    //         return response()->json(['message' => 'Cours introuvable'], 404);
    //     }
    //     else{
    //         $cour->delete();
    //         return response()->json(['message' => 'Cours supprimée avec succes'], 200);
    //    }
    // }

    public function destroy(Cour $id)
{
    // A ce stade, $id est déjà une instance du modèle Cour correspondant à l'identifiant fourni dans l'URL

    // Vérifie si le modèle existe
    if (!$id) {
        return response()->json(['message' => 'Cours introuvable'], 404);
    } else {
        // Appelle la méthode delete sur l'instance unique du modèle
        $id->delete();

        // Autres actions après la suppression si nécessaire

        return response()->json(['message' => 'Cours supprimé avec succès'], 200);
    }
}

}
