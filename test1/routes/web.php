<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});




use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;

// Pagina di Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Pagina di Registrazione
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/messages', [ChatController::class, 'store']);

/*
Route::get('/', function () {
    $userId = Auth::id();

    $mess = DB::table('messages')->select('message')->where('userCreationId', $userId)->get();
    return view('home', compact('mess'));
});
*/

Route::get('/', function () {
    $userId = Auth::id();

    $messaggi = DB::table('messages')->select('message', 'ChatID')->where('userCreationId', $userId)->get();

    // Passa l'array di messaggi alla vista
    return view('home')->with('messaggi', $messaggi);
});




