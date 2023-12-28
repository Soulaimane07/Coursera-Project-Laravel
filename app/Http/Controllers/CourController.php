<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use Illuminate\Http\Request;

class CourController extends Controller
{
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

    public function store(Request $request)
    {
        //
    }

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

    public function destroy(Cour $id)
    {
        if (!$id) {
            return response()->json(['message' => 'Cours introuvable'], 404);
        } else {
            $id->delete();
            return response()->json(['message' => 'Cours supprimé avec succès'], 200);
        }
    }

}
