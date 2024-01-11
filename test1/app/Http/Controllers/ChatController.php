<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;


class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::all();
        return view('welcome', compact('chats'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'message' => 'required',
            'chatID' => 'required',
            'userCreationId' => 'required',
        ]);
    
        // Cambia 'Chat' con il tuo modello dei messaggi (presumibilmente 'Message')
        $message = Message::create([
            'message' => $validatedData['message'],
            'chatID' => $validatedData['chatID'], 
            'userCreationId' => $validatedData['userCreationId'], 
        ]);
    
        return redirect('/')->with('success', 'Message is successfully saved');
    }
    
    /*
    public function get()
    {
        $mess = DB::table('messages')->select('message')->get();

        return view('some-view')->with('messages', $mess);
    }
*/

    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->delete();

        return redirect('/')->with('success', 'Chat is successfully deleted');
    }
}