<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiShipment;





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

Route::post('login', [ApiAuthController::class, 'login'])->name('login');
Route::get('getcbu/{id}', [ApiLokasi::class, 'getcbu'])->name('getcbu');
Route::get('listoftrouble/{idsitename}', [ApiTrouble::class, 'listoftrouble'])->name('listoftrouble');
Route::get('gettrouble/{id}', [ApiTrouble::class, 'gettrouble'])->name('gettrouble');
Route::post('apimedia', 'App\Http\Controllers\ApiMedia@store');
Route::get('trouble/listdokumen/{id}', [ApiTrouble::class, 'listdokumen']);
Route::post('trouble/store', [ApiTrouble::class, 'store']);

Route::get('listofunit/{idsitename}', [ApiMaintenance::class, 'listofunit'])->name('listofunit');
Route::get('listofmaintenance/{idsitename}', [ApiMaintenance::class, 'listofmaintenance'])->name('listofmaintenance');
Route::get('getmaintenance/{id}', [ApiMaintenance::class, 'getmaintenance'])->name('getmaintenance');
Route::post('apimedia', 'App\Http\Controllers\ApiMedia@store');
Route::get('maintenance/listdokumen/{id}', [ApiMaintenance::class, 'listdokumen']);
Route::post('maintenance/store', [ApiMaintenance::class, 'store']);
Route::get('getunit/{id}', [ApiMaintenance::class, 'getunit'])->name('getunit');

Route::get('listshipment/{id}', [ApiShipment::class, 'listshipment'])->name('listshipment');
Route::get('listhistoryshipment/{id}', [ApiShipment::class, 'listhistoryshipment'])->name('listhistoryshipment');
