<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Log;


/**
 * Questa classe gestisce le operazioni relative alla chat.
 * 
 * @author Ethan
 */
class ChatController extends Controller
{

  
    /**
     * Qeuesto metodo valida i dati relativi alle chat
     *
     * @param \Illuminate\Http\Request $request richiesta HTTP
     * 
     * @return Success se la chat è valida
     * 
     * @author Ethan
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'message' => 'required',
            'chatID' => 'required',
            'userCreationId' => 'required',
            'nomeChat' => 'required',
            'systemPrompt' => 'required',
        ]);
    
       
        $message = Message::create([
            'message' => $validatedData['message'],
            'chatID' => $validatedData['chatID'], 
            'userCreationId' => $validatedData['userCreationId'], 
            'nomeChat' => $validatedData['nomeChat'], 
            'systemPrompt' => $validatedData['systemPrompt'],
        ]);
        

        return redirect('/')->with('success', 'Message is successfully saved');
    }
    

}