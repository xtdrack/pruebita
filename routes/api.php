<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\EventController;
//RESET

Route::post('/reset', 'ResetController@reset');



//GET Balance



//POST crear cuenta con balance inicial




//POST depositar




//GET BALANCE

Route::get('/balance', [BalanceController::class, 'show'])->name('home');


//RETIRO DE CUENTA QE NO EXISTE


// retiro de una cuenta qe si existe



//tranferencia cuenta que si existe



//transferencia de una cuenta que no existe

Route::post('/event', [EventController::class, 'store'])->name('home');