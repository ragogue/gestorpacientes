<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\Controllers\api\AuthController@signin');
Route::post('/register', 'App\Http\Controllers\api\AuthController@signup');



Route::middleware('auth:sanctum')->group( function () {
    Route::get('/patient/all', 'App\Http\Controllers\PatientController@listAll'); //show all patients
    Route::get('/patient/show/{id}', 'App\Http\Controllers\PatientController@show'); //show a patient
    Route::post('/patient/store', 'App\Http\Controllers\PatientController@store'); //save a patient
    Route::post('/patient/update/{id}', 'App\Http\Controllers\PatientController@update'); //update a patient
    Route::delete('/patient/delete/{nif}', 'App\Http\Controllers\PatientController@destroy'); //delete a patient
});


Route::post('/diagnosis/store', 'App\Http\Controllers\DiagnosisController@store'); //save a diagnosis
Route::get('/diagnosis/patient/{id}', 'App\Http\Controllers\DiagnosisController@show'); //show all patients
