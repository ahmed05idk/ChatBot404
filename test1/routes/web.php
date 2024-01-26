<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerificationController;


// Pagina di Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Pagina di Registrazione
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/logout', [AuthController::class, 'logout']);




Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');









//Route::post('/sendVerificationEmail', [VerificationController::class, 'sendVerificationEmail'])->name('sendVerificationEmail');

Route::post('/sendVerificationEmail', function (Request $request) {
    $email = $request->input('email');
    
    // Crea un'istanza del VerificationController
    $verificationController = new VerificationController();

    // Chiama il metodo per ottenere il codice di verifica
    $verificationCode = $verificationController->sendVerificationEmail($email);
    // Restituisci solo il JSON
    return ['success' => true, 'verification_code' => $verificationCode];
});



Route::post('/messages', [ChatController::class, 'store']);



Route::get('/', function () {
    $userId = Auth::id();

    $messaggi = DB::table('messages')->select('message', 'ChatID')->where('userCreationId', $userId)->get();

    // Passa l'array di messaggi alla vista
    return view('home')->with('messaggi', $messaggi);
});


Route::post('/updateMessages', function (Request $request) {
    // Supponendo che tu stia passando i dati necessari nella richiesta
    $userId = Auth::id();
    $newMessage = $request->input('newMessage');
    $chatId = $request->input('chatId');

    // Aggiorna il messaggio nella tabella "messages"
    DB::table('messages')
        ->where('userCreationId', $userId)
        ->where('ChatID', $chatId)
        ->update(['message' => $newMessage]);

    return true;
});


Route::post('/deleteChat', function (Request $request) {
    // Supponendo che tu stia passando i dati necessari nella richiesta
    $userId = Auth::id();
    $chatId = $request->input('chatId');

    // Verifica se l'utente corrente è coinvolto nella chat
    $isUserInChat = DB::table('messages')
        ->where('userCreationId', $userId)
        ->where('ChatID', $chatId)
        ->exists();

    // Se l'utente è coinvolto, elimina la chat
    if ($isUserInChat) {
        DB::table('messages')
            ->where('userCreationId', $userId)
            ->where('ChatID', $chatId)
            ->delete();

        // Puoi anche eliminare la chat dalla tabella delle chat, ad esempio:
        // DB::table('chats')->where('id', $chatId)->delete();

        return true;
    }

    // Se l'utente non è coinvolto nella chat, restituisci false o un messaggio di errore
    return false;
});

