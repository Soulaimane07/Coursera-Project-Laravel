<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\courController;
use App\Http\Controllers\ProfesseurController;

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

Route::post('pdf', [courController::class, 'getText']);