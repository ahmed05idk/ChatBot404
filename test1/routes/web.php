<?php
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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerificationController;



/**
 * Imopsta la pagina come pagina iniziale
 * 
 * @author Ethan
 */
Route::get('/', function () {
    return view('home');
});




/**
 * Definisce le route per il login e gestisce le richieste GET e POST.
 * 
 * @return \Illuminate\Http\Response
 * 
 * @author Ethan
 */
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


/**
 * Definisce le route per la registrazione degli utenti e gestisce le richieste GET e POST.
 * 
 * @return \Illuminate\Http\Response
 * 
 * @author Ethan
 */
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


/**
 * Definisce la route per il logout e gestisce le richieste GET e POST.
 * 
 * @return \Illuminate\Http\Response
 * 
 * @author Ethan
 */
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/logout', [AuthController::class, 'logout']);





/**
 * Definisce la route per richiedere il reset della password e gestisce le richieste GET.
 * 
 * @return \Illuminate\Http\Response
 * 
 * @author Ethan
 */
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

/**
 * Definisce la route per inviare l'email di reset della password e gestisce le richieste POST.
 * 
 * @return \Illuminate\Http\Response
 * 
 * @author Ethan
 */
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

/**
 * Definisce la route per visualizzare il form di reset della password e gestisce le richieste GET.
 * 
 * @return \Illuminate\Http\Response
 * 
 * @param string $token
 */
Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');

/**
 * Definisce la route per effettuare il reset della password e gestisce le richieste POST.
 * 
 * @return \Illuminate\Http\Response
 *
 */
Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');








/**
 * Gestisce la richiesta POST per inviare l'email di verifica e restituisce il codice di verifica.
 * 
 * @param Request $request L'istanza della richiesta HTTP.
 * 
 * @return array Un array JSON che indica il successo dell'operazione e il codice di verifica generato.
 * 
 * @author Ethan
 */
Route::post('/sendVerificationEmail', function (Request $request) {
    $email = $request->input('email');

    // Crea un'istanza del VerificationController
    $verificationController = new VerificationController();

    // Chiama il metodo per ottenere il codice di verifica
    $verificationCode = $verificationController->sendVerificationEmail($email);
    // Restituisci il JSON
    return ['success' => true, 'verification_code' => $verificationCode];
});



/**
 * Gestisce la richiesta POST per salvare un messaggio nella chat.
 * 
 * @return \Illuminate\Http\Response
 * 
 * @author Ethan
 */
Route::post('/messages', [ChatController::class, 'store']);



/**
 * Gestisce la richiesta GET per la pagina principale e restituisce i messaggi dell'utente.
 * 
 * @return Array - Messaggi dell'utente..
 * 
 * @author Ethan
 */
Route::get('/', function () {
    $userId = Auth::id();

    $messaggi = DB::table('messages')->select('message', 'ChatID', 'nomeChat', 'updated_at')->where('userCreationId', $userId)->get();

    // Passa l'array di messaggi alla home
    return view('home')->with('messaggi', $messaggi);
});



/**
 * Gestisce la richiesta POST per aggiornare un messaggio nella chat.
 * 
 * @param Request $request L'istanza della richiesta HTTP contenente i dati necessari per l'aggiornamento del messaggio.
 * 
 * @return bool Restituisce true se l'aggiornamento è avvenuto con successo, altrimenti false.
 * 
 * @author Ethan
 */
Route::post('/updateMessages', function (Request $request) {

    $userId = Auth::id();
    $newMessage = $request->input('newMessage');
    $chatId = $request->input('chatId');
    $updated_at = now()->format('Y-m-d H:i:s');

    // Aggiorna il messaggio nella tabella "messages"
    DB::table('messages')
        ->where('userCreationId', $userId)
        ->where('ChatID', $chatId)
        ->update(['message' => $newMessage, 'updated_at' => $updated_at]);

    return true;
});



/**
 * Gestisce la richiesta POST per eliminare una chat.
 * 
 * @param Request $request L'istanza della richiesta HTTP contenente i dati necessari per l'eliminazione della chat.
 * 
 * @return bool Restituisce true se l'eliminazione è avvenuta con successo, altrimenti false.
 *
 * @author Ethan
 */
Route::post('/deleteChat', function (Request $request) {

    $userId = Auth::id();
    $chatId = $request->input('chatId');

    // Verifica se l'utente è lo stesso che ha creato la chat
    $isUserInChat = DB::table('messages')
        ->where('userCreationId', $userId)
        ->where('ChatID', $chatId)
        ->exists();

    // Elimina la chat
    if ($isUserInChat) {
        DB::table('messages')
            ->where('userCreationId', $userId)
            ->where('ChatID', $chatId)
            ->delete();


        return true;
    }

    // Se l'utente non è lo stesso che ha creato la chat, restituisce false
    return false;
});