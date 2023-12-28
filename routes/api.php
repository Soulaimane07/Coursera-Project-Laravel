<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\courController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EtudiantExcelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// ------------------- Authentification
Route::post('/signup', [UtilisateurController::class, 'signup']);
Route::post('/login', [UtilisateurController::class, 'login']);
Route::get('/logout', [UtilisateurController::class, 'logout']);



// ------------------- Cours
Route::get('cours/index', [courController::class, 'index']);
Route::post('cours/create', [courController::class, 'create']);
Route::put('cours/update/{id}', [courController::class, 'update']);
Route::delete('cours/destroy/{id}', [courController::class, 'destroy']);


//professeur routes:
Route::get('prof/showOne/{id}', [ProfesseurController::class, 'showOne']);
Route::get('prof/showAll', [ProfesseurController::class, 'showAll']);
Route::post('prof/create', [ProfesseurController::class, 'create']);
Route::put('prof/update/{id}', [ProfesseurController::class, 'update']);
Route::delete('prof/destroy/{id}', [ProfesseurController::class, 'destroy']);
Route::post('prof/{professeurId}/assignCours', [ProfesseurController::class, 'assignCours']);
Route::post('prof/{professeurId}/assignGroupes', [ProfesseurController::class, 'assignGroupes']);
Route::post('prof/{professeurId}/removeCours', [ProfesseurController::class, 'removeCours']);

Route::post('pdf', [courController::class, 'getText']);


//groupe routes
Route::get('groupe/index', [GroupeController::class, 'index']);
Route::post('groupe/create', [GroupeController::class, 'create']);
Route::put('groupe/update/{id}', [GroupeController::class, 'update']);
Route::delete('groupe/destroy/{id}', [GroupeController::class, 'destroy']);
Route::delete('group/{groupeId}/{professeurId}/removeprof', [GroupeController::class, 'removeProfesseurFromGroupe']);


//Etudiant Routes:
Route::get('etudiant/index', [EtudiantController::class, 'index']);
Route::get('etudiant/show/{idEtudiant}', [EtudiantController::class, 'show']);
Route::post('etudiant/create', [EtudiantController::class, 'create']);
Route::put('etudiant/update/{idEtudiant}', [EtudiantController::class, 'update']);
Route::delete('etudiant/destroy/{idEtudiant}', [EtudiantController::class, 'destroy']);


//--------- Excel
Route::post('/simple-excel/importEtudiant', [EtudiantExcelController::class, 'importEtudiants']);
Route::post('/simple-excel/import', [ProfexcelController::class, 'import']);
Route::post('/extractdate', [CertificatController::class, 'extractDateFromPDF']);