<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;



class VerificationController extends Controller
{
    public function sendVerificationEmail($email)
    {
        // Genera un codice di verifica casuale
        $verificationCode = rand(100000, 999999);

        // Personalizza il corpo del messaggio a tuo piacimento
        $message = "Il tuo codice di verifica è: $verificationCode";

        // Invia l'email di verifica
        Mail::raw($message, function ($mail) use ($email) {
            $mail->to($email)->subject('Verifica Codice');
        });

        // Ritorna il codice di verifica
        return $verificationCode;
    }
}
   