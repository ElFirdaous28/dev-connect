<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function chat($userId)
    {
        $loggedInUser = auth()->user();
        $secondUser = User::findOrFail($userId);

        // Retrieve messages using relationships
        $messages = Message::where(function ($query) use ($loggedInUser, $secondUser) {
            $query->where('sender_id', $loggedInUser->id)
                ->where('receiver_id', $secondUser->id);
        })->orWhere(function ($query) use ($loggedInUser, $secondUser) {
            $query->where('sender_id', $secondUser->id)
                ->where('receiver_id', $loggedInUser->id);
        })->with(['sender', 'receiver']) // Eager load sender and receiver
            ->orderBy('created_at', 'asc')->get();

        return view('chat', compact('secondUser', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message->message,
            'time' => $message->created_at->format('H:i')
        ]);
    }
}
