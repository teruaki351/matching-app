<?php

// app/Http/Controllers/MessageController.php
namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation)
    {
        abort_unless($conversation->hasUser(Auth::id()), 403);

        $data = $request->validate([
            'body' => ['required','string','max:4000'],
        ]);

        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body'    => $data['body'],
        ]);

        // 既読制御・通知などは後段で
        $conversation->touch(); // updated_at を更新して一覧を上に

        return back();
    }
}
