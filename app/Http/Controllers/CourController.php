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
        return response()->json(['status' => 'success', 'cours' => $cour]);
    }

    public function getText(Request $req)
    {

        if($req->hasfile('pdf')){
            $file = $req->file('pdf');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '' .$extention;
            $file->move('uploads/certificats/', $filename);
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile(public_path('uploads/certificats/'.$filename));
    
            $text = $pdf->getText();
            echo $text;
        }


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

        if($req->hasfile('image')){
            $file = $req->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '' .$extention;
            $file->move('uploads/', $filename);
            $cour->image = $filename;
        }

        $cour->save();
        return response()->json(['status' => 'success', 'cour' => $cour]);
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
    public function update(Request $req, string  $id)
    {
        $cour = Cour::find($req->id);

        if($req->libelle){
            $cour->libelle = $req->libelle;
        }
        if($req->desc){
            $cour->desc = $req->desc;
        }
        if($req->dateDebut){
            $cour->dateDebut = $req->dateDebut;
        }
        if($req->dateFin){
            $cour->dateFin = $req->dateFin;
        }

        if($req->hasfile('image')){
            $file = $req->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '' .$extention;
            $file->move('uploads/', $filename);
            $cour->image = $filename;
        }

        $cour->save();

        return response()->json([
            'message' => 'cours mis à jour avec succès',
            'data' => $cour
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
