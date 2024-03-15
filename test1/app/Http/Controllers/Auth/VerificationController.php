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

        // Invia l'email di verifica utilizzando un template HTML
        Mail::send('verificationEmail', ['verificationCode' => $verificationCode], function ($mail) use ($email) {
            $mail->to($email)
                ->subject('Codice di verifica')
                ->from('help.chatbot404@gmail.com', 'ChatBot404');
        });

        // Ritorna il codice di verifica
        return $verificationCode;
    }
}
