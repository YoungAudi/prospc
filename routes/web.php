<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ProspectoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropuestaController;
use App\Http\Controllers\TalentoController;
use App\Http\Controllers\AdjuntoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(AuthController::class)->name('auth.')->group(function() {
    Route::middleware(['guest'])->group(function() {
        Route::get('/', 'loginPage')->name('login.page');
        Route::post('/', 'login')->name('login.process');
    });
    Route::get('/salir', 'logout')->name('logout')->middleware('auth');
});

Route::prefix('panel')->middleware(['auth'])->group(function() {
    Route::get('/', PanelController::class)->name('home');
    Route::resource('prospectos', ProspectoController::class)->except(['create', 'edit'])->parameters(['prospectos' => 'prospecto'])
        ->missing(function (Request $request) {
            return Redirect::route('prospectos.index');
        });
    Route::resource('talentos', TalentoController::class)->except(['create', 'edit'])->parameters(['talentos' => 'talento'])
        ->missing(function (Request $request) {
            return Redirect::route('talentos.index');
        });
    Route::prefix('propuestas-creadas/{propuesta}')->name('propuestas.')->group(function () {
        Route::post('enviar', [PropuestaController::class, 'enviar'])->name('enviar');
        Route::post('aceptar', [PropuestaController::class, 'aceptar'])->name('aceptar');
        Route::post('rechazar', [PropuestaController::class, 'rechazar'])->name('rechazar');
        Route::resource('adjuntos', AdjuntoController::class)->except(['create', 'edit', 'update', 'show'])->parameters(['adjuntos' => 'adjunto'])
        ->missing(function (Request $request) {
            return Redirect::route('adjuntos.index');
        });
    });
    Route::resource('eventos', EventoController::class)->except(['create', 'edit'])->parameters(['eventos' => 'evento'])
        ->missing(function (Request $request) {
            return Redirect::route('eventos.index');
        });
    Route::resource('usuarios', UserController::class)->except(['create', 'edit'])->parameters(['usuarios' => 'user'])
        ->missing(function (Request $request) {
            return Redirect::route('usuarios.index');
        });
    Route::resource('propuestas', PropuestaController::class)->except(['create', 'edit'])->parameters(['propuestas' => 'propuesta'])
        ->missing(function (Request $request) {
            return Redirect::route('propuestas.index');
        });

});