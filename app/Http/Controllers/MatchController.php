<?php


namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    public function index()
    {
        $myId = Auth::id();

        // 自分がいいねした相手の user_id 一覧
        $likedUserIds = Like::where('from_user_id', $myId)
            ->pluck('to_user_id');

        // その中で「相手からも自分にいいねされている人」の user_id 一覧
        $matchedUserIds = Like::whereIn('from_user_id', $likedUserIds)
            ->where('to_user_id', $myId)
            ->pluck('from_user_id')
            ->unique()
            ->values();

        // その user_id のアカウント情報を取得
        $accounts = Account::whereIn('user_id', $matchedUserIds)
            ->with('primaryPhoto') // 画像使ってるなら
            ->paginate(12);

        return view('matches.index', compact('accounts'));
    }
}
