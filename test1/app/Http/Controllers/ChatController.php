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
            'message' => 'required|max:255',
        ]);
    
        // Cambia 'Chat' con il tuo modello dei messaggi (presumibilmente 'Message')
        $message = Message::create($validatedData);
    
        return redirect('/')->with('success', 'Message is successfully saved');
    }
    
    public function create()
    {
        return view('chats.create');
    }

    public function show($id)
    {
        $chat = Chat::findOrFail($id);

        return view('chats.show', compact('chat'));
    }

    public function edit($id)
    {
        $chat = Chat::findOrFail($id);

        return view('chats.edit', compact('chat'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'message' => 'required|max:255',
        ]);
        Chat::whereId($id)->update($validatedData);

        return redirect('/')->with('success', 'Chat is successfully updated');
    }

    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->delete();

        return redirect('/')->with('success', 'Chat is successfully deleted');
    }
}
