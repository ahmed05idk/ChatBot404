<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;








class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    // Mostra il modulo per richiedere un link di reset della password.
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Invia il link per il reset della password via email.
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
    
        $response = $this->broker()->sendResetLink(
            $request->only('email'),
            function ($user, $token) {
                // In questa chiusura (Closure), puoi implementare la tua logica personalizzata,
                // ad esempio, inviare l'email con il link di reset della password.
                $user->sendPasswordResetNotification($token);
            }
        );
    
        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }
    
    

    // Mostra il modulo per il reset della password.
    public function showResetForm($token)
    {
        return view('auth.passwords.reset')->with(['token' => $token]);
    }

    // Resetta la password dell'utente.
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());
    
        // Estrai il token direttamente dalla richiesta
        $token = $request->input('token');
    
        $response = $this->broker()->reset(
            array_merge(
                $request->only('email', 'password', 'password_confirmation'),
                ['token' => $token]
            ),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );
    
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }
    
    
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }
     protected function validationErrorMessages()
    {
        return [
            'password.min' => 'La password deve essere lunga almeno 8 caratteri.',
            // Altri messaggi personalizzati...
        ];
    }
    protected function resetPassword($user, $password)
    {
        // Utilizza il metodo update per aggiornare la password nel modello utente.
        $user->update([
            'password' => bcrypt($password),
        ]);
    }
    protected function sendResetResponse(Request $request, $response)
{
    return redirect($this->redirectPath())
        ->with('status', trans($response));
}
protected function sendResetFailedResponse(Request $request, $response)
{
    return redirect()->back()
        ->withInput($request->only('email'))
        ->withErrors(['email' => trans($response)]);
}
protected function redirectPath()
{
    // Restituisci il percorso a cui l'utente dovrebbe essere reindirizzato dopo il reset della password.
    return '/'; // Modifica questo percorso in base alle tue esigenze.
}





}