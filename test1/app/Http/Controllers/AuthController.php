<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{


    public function register(Request $request)
    {
        // Validazione dei dati del modulo
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Creazione di un nuovo utente nel database
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        // Autenticazione dell'utente appena registrato
        Auth::login($user);

        // Reindirizzamento dopo la registrazione
        return redirect('/'); // Puoi personalizzare il percorso a tuo piacimento
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

}
?>