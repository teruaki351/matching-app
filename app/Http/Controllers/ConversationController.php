<?php

// app/Http/Controllers/ConversationController.php
namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Support\MatchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Like;



class ConversationController extends Controller
{
    // 一覧
    public function index()
    {
        $uid = Auth::id();
        $conversations = Conversation::where('user_one_id',$uid)
            ->orWhere('user_two_id',$uid)
            ->latest('updated_at')
            ->get();

        return view('conversations.index', compact('conversations'));
    }

    // 相手との会話を開始 or 取得
    public function store(Request $request)
    {
        $uid = Auth::id();
        $otherId = (int)$request->validate(['user_id'=>'required|integer|exists:users,id'])['user_id'];

        if ($uid === $otherId) abort(403);

        // 相互いいねでなければ禁止
        if (!MatchService::isMutualLike($uid, $otherId)) {
            return back()->with('error','相互いいねではありません。');
        }

        [$one,$two] = Conversation::normalizePair($uid, $otherId);

        $conv = Conversation::firstOrCreate([
            'user_one_id' => $one,
            'user_two_id' => $two,
        ]);

        return redirect()->route('conversations.show', $conv);
    }

    // 表示
    public function show(Conversation $conversation)
    {
        // abort_unless($conversation->hasUser(Auth::id()), 403);

        // $messages = $conversation->messages()
        //     ->with('user')
        //     ->orderBy('created_at')
        //     ->get();

        $me = Auth::id();

        // 自分がこの会話の参加者かチェック（ザックリ例）
        if (!in_array($me, [$conversation->user_one_id, $conversation->user_two_id])) {
            abort(403);
        }

        // メッセージと送信者情報を一緒に取得
        $conversation->load([
            'messages.user',   // $message->user
            'userOne',
            'userTwo',
        ]);

        // return view('conversations.show', compact('conversation','messages'));
         return view('conversations.show', compact('conversation'));
    }


     // ★ 追加：相手ユーザーとの会話を取得 or 作成してトーク画面へ
    public function withUser(User $user)
    {
        $me = Auth::id();
        $otherId = $user->id;

        // 自分自身には飛べない
        if ($me === $otherId) {
            abort(404);
        }

        // 相互いいねじゃなければ拒否（お好みで外してもOK）
        $ab = Like::where('from_user_id', $me)
            ->where('to_user_id', $otherId)
            ->exists();

        $ba = Like::where('from_user_id', $otherId)
            ->where('to_user_id', $me)
            ->exists();

        if (!($ab && $ba)) {
            abort(403, '相互いいねではありません');
        }

        // 2人のIDの並びを固定（小さい方を user_one_id に）
        [$userOne, $userTwo] = $me < $otherId
            ? [$me, $otherId]
            : [$otherId, $me];

        // 既にあれば取得、なければ作成
        $conversation = Conversation::firstOrCreate([
            'user_one_id' => $userOne,
            'user_two_id' => $userTwo,
        ]);

        // トーク画面へ
        return redirect()->route('conversations.show', $conversation);
    }
}
