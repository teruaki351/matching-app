<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{   
    public function edit()
    {   
        $user = Auth::user();

         // ログインユーザーのAccountを取得 or 作成
        $account = $user->account()->firstOrCreate(
    ['user_id' => $user->id],
    ['display_name' => $user->name ?? '未設定'] // 初期値
);



        return view('account.edit', compact('account','user'));
    } 



        public function update(Request $request)
        {   
            //dd($request->only(['bio', 'height_cm']));
            //dd($request->all());
            // 入力バリデーション
            $validated = $request->validate([
                'name'         => ['required','string','max:255'],
                'email'        => ['required','email','max:255'],
                'bio'          => ['nullable','string','max:5000'],
                'height_cm'    => ['nullable','integer','min:50','max:300'],
                'age_years' => ['nullable','integer','min:0','max:120'],
                'blood_type'=> ['nullable','in:A,B,O,AB'],
                'residence' => [
                    'nullable',
                    'in:北海道,青森県,岩手県,宮城県,秋田県,山形県,福島県,茨城県,栃木県,群馬県,埼玉県,千葉県,東京都,神奈川県,新潟県,富山県,石川県,福井県,山梨県,長野県,岐阜県,静岡県,愛知県,三重県,滋賀県,京都府,大阪府,兵庫県,奈良県,和歌山県,鳥取県,島根県,岡山県,広島県,山口県,徳島県,香川県,愛媛県,高知県,福岡県,佐賀県,長崎県,熊本県,大分県,宮崎県,鹿児島県,沖縄県'
                ],
                'hometown'  => [
                    'nullable',
                    'in:北海道,青森県,岩手県,宮城県,秋田県,山形県,福島県,茨城県,栃木県,群馬県,埼玉県,千葉県,東京都,神奈川県,新潟県,富山県,石川県,福井県,山梨県,長野県,岐阜県,静岡県,愛知県,三重県,滋賀県,京都府,大阪府,兵庫県,奈良県,和歌山県,鳥取県,島根県,岡山県,広島県,山口県,徳島県,香川県,愛媛県,高知県,福岡県,佐賀県,長崎県,熊本県,大分県,宮崎県,鹿児島県,沖縄県'
                ],
                'education' => ['nullable','in:jhs,hs,vocational,bachelor,master,doctor,other'], // 任意
                'avatar'       => ['nullable','image','max:5120'],   // 5MB
                'remove_avatar'=> ['nullable','boolean'],            // ← ここに合わせる
            ]);

            $user = Auth::user();

            // ① account を必ず用意（ここを最初に！）
            $account = $user->account()->firstOrCreate(['user_id' => $user->id]);

            // ② まとめて DB を更新（トランザクション）
            DB::transaction(function () use ($user, $account, $request, $validated) {

                // users テーブルの更新（名前・メール）
                $user->fill([
                    'name'  => $validated['name'],
                    'email' => $validated['email'],
                ])->save();

                // account テーブルの更新（bio・height_cm ほか）
                $account->fill([
                    'bio'       => $validated['bio']      ?? null,
                    'height_cm' => $validated['height_cm']?? null,
                    'age_years' => $validated['age_years']?? null,
                    'blood_type' => $validated['blood_type']?? null,
                    'residence' => $validated['residence']?? null,
                    'hometown' => $validated['hometown']?? null,
                    'education' => $validated['education']?? null,
                ])->save();

                // ③ 画像（photos テーブル）操作
                // 削除指定（バリデーション名に合わせる）
                if ($request->boolean('remove_avatar') && $account->primaryPhoto) {
                    Storage::disk('public')->delete($account->primaryPhoto->path);
                    $account->primaryPhoto->delete();
                }

                // 新規アップロード
                if ($request->hasFile('avatar')) {
                    $path = $request->file('avatar')->store('photos', 'public');

                    // 既存の主画像フラグを落とす
                    $account->photos()->where('is_primary', true)->update(['is_primary' => false]);

                    // 新規を主画像として登録
                    $account->photos()->create([
                        'path'       => $path,
                        'is_primary' => true,
                    ]);
                }
            });

            return redirect()->route('accounts.edit')->with('success', 'プロフィールを更新しました。');
        }



    public function create()
    {
        return view('account.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'display_name'  => ['required','string','max:255'],
            'bio'           => ['nullable','string'],
            'birthday'      => ['nullable','date'],
            'gender'        => ['nullable','in:male,female,other'],
            'location_pref' => ['nullable','string','max:255'],
            'lat'           => ['nullable','numeric'],
            'lng'           => ['nullable','numeric'],
            'height_cm' => ['nullable','integer','min:50','max:300'],
            'age_years' => ['nullable','integer','min:0','max:120'],
            'blood_type'=> ['nullable','in:A,B,O,AB'],
            'residence' => ['nullable','string','max:100'],
            'hometown'  => ['nullable','string','max:100'],
            'education' => ['nullable','in:jhs,hs,vocational,bachelor,master,doctor,other'], // 任意
        ]);

        $validated['user_id'] = auth()->id();   // ログインユーザーに紐付け

        // Account::create($validated);
        //   return view('account.pictures');
        $account = auth()->user()->account()->firstOrCreate(['user_id'=>auth()->id()]);
        $account->fill($request->only([
            'bio','height_cm','age_years','blood_type','residence','hometown','education'
        ]))->save();

        $account = Account::create($validated);
        return view('account.pictures', ['account' => $account]);
       //return redirect()
        //->route('accounts.pictures', $account)   // ← 次のページ
        //->with('success', 'アカウントを作成しました。'); // フラッシュメッセージ

        //return redirect()->route('accounts.create')->with('success','アカウントを作成しました。');
    }

     public function show($id)
        {
            // $account = Account::with('user.likesReceived')->findOrFail($id); // 該当IDを取得 or 404
            // return view('account.show', compact('account'));

             $account = \App\Models\Account::with('user.likesReceived')->findOrFail($id);

                $alreadyLiked = \App\Models\Like::where('from_user_id', auth()->id())
                    ->where('to_user_id', $account->user_id)
                    ->exists();

            return view('account.show', compact('account', 'alreadyLiked'));
        }
}
