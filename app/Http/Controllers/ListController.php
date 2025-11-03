<?php

// app/Http/Controllers/ListController.php
namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;


class ListController extends Controller
{
    public function index(Request $request)
    {
        $q = Account::query()
            ->where('user_id', '!=', auth()->id())
            ->with(['primaryPhoto']);  // 既に追加している関係（下に記載）


        // アカウント一覧を取得
        $accounts = \App\Models\Account::all();


        $accounts = $q->latest('id')->paginate(12)->withQueryString();

        return view('list.index', compact('accounts'));
    }
}
