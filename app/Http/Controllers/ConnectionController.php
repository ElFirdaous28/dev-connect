<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{

    public function connect(User $user)
    {
        Connection::create([
            'requester_id' => auth()->user()->id,
            'addressee_id' => $user->id,
        ]);
        return response()->json([
            'success' => true,
        ]);
    }

    // Accept connection request by connection ID
    public function accept(Request $request, $connectionId)
    {
        $connection = Connection::find($connectionId);

        if ($connection) {
            $connection->status = 'accepted';
            $connection->save();

            return response()->json(['message' => 'Connection accepted']);
        }

        return response()->json(['message' => 'Connection not found'], 404);
    }

    // Reject connection request by connection ID (delete it)

    public function reject(Request $request, $connectionId)
    {
        $connection = Connection::find($connectionId);

        if ($connection) {
            $connection->delete();

            return response()->json(['message' => 'Connection rejected']);
        }

        return response()->json(['message' => 'Connection not found'], 404);
    }
    // Delete a connection by connection ID
    public function delete(Request $request, $connectionId)
    {
        $connection = Connection::find($connectionId);

        if ($connection) {
            $connection->delete();

            return response()->json(['message' => 'Connection deleted']);
        }

        return response()->json(['message' => 'Connection not found'], 404);
    }
}
