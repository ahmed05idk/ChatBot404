<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


/**
 * Controller per gestire le operazioni di autenticazione utente come registrazione, login e logout.
 * 
 * @author Ethan
 */
class AuthController extends Controller
{

    /**
     * Registra un nuovo utente.
     * 
     * @param request La richiesta HTTP contenente i dati di registrazione dell'utente.
     * 
     * @return Reindirizza alla pagina home dopo la registrazione.
     * 
     * @author Ethan
     */
    public function register(Request $request)
    {
        // Validazione dei dati del modulo
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $updated_at = now()->format('Y-m-d H:i:s');
        $created_at = now()->format('Y-m-d H:i:s');
        // Creazione di un nuovo utente nel database
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'updated_at' => $updated_at,
            'created_at' => $created_at
        ]);

        // Autenticazione dell'utente appena registrato
        Auth::login($user);

        // Reindirizzamento dopo la registrazione
        return redirect('/');
    }


        /**
     * Mostra il modulo di registrazione.
     * 
     * @return Vista del modulo di registrazione.
     * 
     * @author Ethan
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    use AuthenticatesUsers;

    protected $redirectTo = '/';


        /**
     * Costruttore del controller.
     * 
     * Imposta il middleware per permettere solo agli ospiti di accedere, tranne per l'azione di logout.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


        /**
     * Mostra il modulo di accesso.
     * 
     * @return Vista del modulo di accesso.
     * 
     * @author Ethan
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }


        /**
     * Esegue il logout dell'utente autenticato.
     * 
     * @param request La richiesta HTTP.
     * 
     * @return Reindirizza l'utente alla pagina di login con un messaggio di successo.
     * 
     * @author Ethan
     */
    public function logout(Request $request)
    {
        // Effettua il logout dell'utente autenticato
        Auth::logout();

        // Cancella la sessione utente
        $request->session()->invalidate();

        // Cancella il cookie di autenticazione
        $request->session()->regenerateToken();

        // Reindirizza l'utente alla pagina di login con un messaggio di successo
        return redirect('/')->with('success', 'Logout effettuato con successo.');
    }


}
?>