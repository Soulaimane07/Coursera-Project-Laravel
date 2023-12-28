<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;

class EtudiantExcelController extends Controller
{
    public function importEtudiants (Request $request) {

    	// 1. Validation du fichier uploadé. Extension ".xlsx" autorisée
    	$this->validate($request, [
    		'fichier' => 'bail|required|file|mimes:xlsx'
    	]);

    	// 2. On déplace le fichier uploadé vers le dossier "public" pour le lire
    	$fichier = $request->fichier->move(public_path(), $request->fichier->hashName());

        // 3. $reader : L'instance Spatie\SimpleExcel\SimpleExcelReader
    	$reader = SimpleExcelReader::create($fichier);

        // On récupère le contenu (les lignes) du fichier
        $rows = $reader->getRows();

        // $rows est une Illuminate\Support\LazyCollection

        // 4. On insère toutes les lignes dans la base de données
        $status = Etudiant::insert($rows->toArray());

        // Si toutes les lignes sont insérées
    	if ($status) {

            // 5. On supprime le fichier uploadé
            $reader->close(); // On ferme le $reader
            // unlink($fichier);

            return response()->json(['data' => 'data imported successufuly']);
        } else { abort(500); }
    }
}
