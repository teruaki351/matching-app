<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountPictureController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MatchController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/top', function () {
    return view('top/index');
    });

    // アカウント情報
    Route::get('/accounts/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::post('/accounts/update', [AccountController::class, 'update'])->name('accounts.update');


    Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/accounts',        [AccountController::class, 'store'])->name('accounts.store');
    Route::get('/accounts/{account}/pictures',  [AccountPictureController::class,'create'])->name('accounts.pictures');
    //Route::post('/accounts/{account}/pictures', [AccountPictureController::class,'store'])->name('accounts.pictures.store');
    Route::post('/accounts/{account}/pictures', [AccountPictureController::class,'storeMany'])->name('accounts.pictures.store');

    Route::get('/accounts/{id}', [AccountController::class, 'show'])->name('accounts.show');




    Route::get('/list', [ListController::class, 'index'])->name('list.index');


    // リスト
    Route::post('/like/{id}', [LikeController::class, 'store'])->name('like.store');
    Route::delete('/like/{id}', [LikeController::class, 'destroy'])->name('like.destroy');

    // 会話
    Route::get('/conversations',[ConversationController::class,'index'])->name('conversations.index');
    Route::post('/conversations',[ConversationController::class,'store'])->name('conversations.store');
    Route::get('/conversations/{conversation}', [ConversationController::class,'show'])->name('conversations.show');
    Route::post('/conversations/{conversation}/messages', [MessageController::class,'store'])->name('messages.store');

     // ★ 追加：相手ユーザーを指定して会話を開く
    Route::get('/conversations/with/{user}', [ConversationController::class, 'withUser'])
        ->name('conversations.with');

    // マッチング一覧表示
    Route::get('/matches', [MatchController::class, 'index'])
        ->name('matches.index');
});

Route::get('/create', function () {
    return view('account/create');
});

require __DIR__.'/auth.php';




