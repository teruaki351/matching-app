<?php

// app/Http/Controllers/AccountPictureController.php
namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccountPictureController extends Controller
{
    public function create(Account $account)
    {
        abort_unless($account->user_id === auth()->id(), 403);
          // 既存の写真も表示に使う
        $account->load(['photos' => fn($q) => $q->orderBy('sort_order')]);
        return view('account.pictures', compact('account'));
    }

    // public function store(Request $request, Account $account)
    // {
    //     abort_unless($account->user_id === auth()->id(), 403);

    //     $data = $request->validate([
    //         'avatar' => ['required','image','mimes:jpg,jpeg,png,webp','max:2048'], // 2MB
    //     ]);

    //     // // 既存のファイルがあれば削除（任意）
    //     // if ($account->avatar_path) {
    //     //     Storage::disk('public')->delete($account->avatar_path);
    //     // }

    //     // public/avatars に保存 → 相対パスが返る
    //     $path = $request->file('avatar')->store('avatars', 'public');

    //     $account->update(['avatar_path' => $path]);

    //     return redirect()
    //         ->route('accounts.pictures', $account)
    //         ->with('success', '画像を更新しました。');
    // }

    public function storeMany(Request $request, Account $account)
    {
        abort_unless($account->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'photos'   => ['required','array','max:5'], // 一度に最大5枚など
            'photos.*' => ['image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);

        $startOrder = (int) $account->photos()->max('sort_order') ?: 0;

        $created = [];
        foreach ($request->file('photos', []) as $i => $file) {
            $path = $file->store('photos', 'public');   // storage/app/public/photos/...
            $created[] = $account->photos()->create([
                'path'       => $path,
                'sort_order' => $startOrder + $i + 1,
                'is_primary' => false,
            ]);
        }

        // まだメインが無ければ1枚目をメインに
        if (! $account->photos()->where('is_primary', true)->exists() && isset($created[0])) {
            $created[0]->update(['is_primary' => true]);
        }

        return redirect()->route('accounts.pictures', $account)
                         ->with('success','写真を追加しました。');
    }
}
