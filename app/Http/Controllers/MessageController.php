<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $users = User::whereNotIn('id', [Auth::id()])->get();
        $messages = Message::where('sender_id', $user->id)
            ->orWhere('recipient_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('messages.index', compact('messages', 'users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'recipient_id' => 'required',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $validatedData['sender_id'] = Auth::id();

        Message::create($validatedData);

        $recipient = User::find($validatedData['recipient_id']);

        if ($recipient->isOnline()) {
            broadcast(new NewMessage($recipient))->toOthers();

            $recipient->notify([
                'title' => 'Nuovo messaggio',
                'text' => 'Hai ricevuto un nuovo messaggio!',
                'duration' => 5000
            ]);
        }


        return redirect()->route('messages.index')->with('success', 'Message sent successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
