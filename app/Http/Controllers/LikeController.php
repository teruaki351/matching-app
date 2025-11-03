<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LikeController extends Controller
{
    public function store($toUserId)
    {
        $fromUserId = Auth::id();

        // 自分自身にはいいねできない
        if ($fromUserId == $toUserId) {
            return back()->with('error', '自分にはいいねできません。');
        }

        // すでにいいね済みならスキップ
        $alreadyLiked = Like::where('from_user_id', $fromUserId)
                            ->where('to_user_id', $toUserId)
                            ->exists();

        if (!$alreadyLiked) {
            Like::create([
                'from_user_id' => $fromUserId,
                'to_user_id'   => $toUserId,
            ]);
        }

        return back()->with('success', 'いいねしました！');
    }

    public function destroy($toUserId)
    {
        $fromUserId = Auth::id();

        Like::where('from_user_id', $fromUserId)
            ->where('to_user_id', $toUserId)
            ->delete();

        return back()->with('success', 'いいねを取り消しました。');
    }
}
