@extends('layouts.app')

@section('content')

    <h1>プロフィール編集</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="edit-content-wrap">

        <form action="{{ route('accounts.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 画像 -->
            <div class="">
                <label  class="edit-img-label">現在の主画像</label>
                <div class="edit-img">
                    @if($account?->primaryPhoto)
                        <img src="{{ asset('storage/'.$account->primaryPhoto->path) }}"
                            alt="avatar" style="width:160px;height:160px;object-fit:cover;border-radius:8px">
                    @else
                        <div style="width:160px;height:160px;background:#eee;border-radius:8px;display:grid;place-items:center;color:#666">
                            画像なし
                        </div>
                    @endif
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="remove_primary" name="remove_primary" value="1">
                    <label class="form-check-label" for="remove_primary">主画像を削除する</label>
                </div>

                <label class="form-label">新しい画像を選択（アップロードすると主画像に設定）</label>
                <input type="file" name="avatar" accept="image/*" class="form-control">
                @error('avatar') <div class="text-danger">{{ $message }}</div> @enderror
            </div>


            <div class="edit-content-inner">
                <div class="edit-content">
                    <div class="mb-3 edit-content-items">
                        <label>名前</label>
                        <input type="text" name="name" value="{{ old('display_name', $account->display_name) }}" class="form-control">
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 edit-content-items">
                        <label>自己紹介文</label>
                        <input type="text" name="bio" value="{{ old('bio', $account->bio) }}" class="form-control">
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
            
                    <div class="mb-3 edit-content-items">
                        <label>メールアドレス</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="edit-content-items">
                        <label>身長(cm)</label>
                        <input type="number" name="height_cm" min="50" max="300"
                            value="{{ old('height_cm', $account->height_cm) }}">
                    </div>

                    <div class="edit-content-items">
                    <label>年齢</label>
                    <input type="number" name="age_years" min="0" max="120"
                            value="{{ old('age_years', $account->age_years) }}">
                    </div>

                    <div class="edit-content-items">
                        <label>血液型</label>
                        <select name="blood_type">
                            <option value="">未設定</option>
                            @foreach (['A','B','O','AB'] as $bt)
                            <option value="{{ $bt }}" @selected(old('blood_type', $account->blood_type)===$bt)>{{ $bt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="edit-content-items">
                        <label>居住地</label>
                        <select name="residence">
                            <option value="">未設定</option>
                            @foreach ([
                                '北海道',
                                '青森県','岩手県','宮城県','秋田県','山形県','福島県',
                                '茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県',
                                '新潟県','富山県','石川県','福井県','山梨県','長野県',
                                '岐阜県','静岡県','愛知県','三重県',
                                '滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県',
                                '鳥取県','島根県','岡山県','広島県','山口県',
                                '徳島県','香川県','愛媛県','高知県',
                                '福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県'
                            ] as $pre)
                                <option value="{{ $pre }}" @selected(old('residence', $account->residence) === $pre)>{{ $pre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="edit-content-items">
                    <label>出身地</label>
                    <select name="hometown">
                            <option value="">未設定</option>
                            @foreach ([
                                '北海道',
                                '青森県','岩手県','宮城県','秋田県','山形県','福島県',
                                '茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県',
                                '新潟県','富山県','石川県','福井県','山梨県','長野県',
                                '岐阜県','静岡県','愛知県','三重県',
                                '滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県',
                                '鳥取県','島根県','岡山県','広島県','山口県',
                                '徳島県','香川県','愛媛県','高知県',
                                '福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県'
                            ] as $to)
                                <option value="{{ $to }}" @selected(old('hometown', $account->hometown) === $to)>{{ $to }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="edit-content-items">
                    <label>学歴</label>
                    <select name="education">
                        <option value="">未設定</option>
                        @php($eds=['jhs'=>'中学','hs'=>'高校','vocational'=>'専門','bachelor'=>'学士','master'=>'修士','doctor'=>'博士','other'=>'その他'])
                        @foreach($eds as $val=>$label)
                        <option value="{{ $val }}" @selected(old('education', $account->education)===$val)>{{ $label }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary edit-btn">更新する</button>
        </form>
        
    </div>

@endsection
