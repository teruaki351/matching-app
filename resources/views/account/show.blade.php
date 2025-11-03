@extends('layouts.app')

@section('title', $account->display_name)

@section('content')

 <!-- <p>ユーザーID：{{ $account->user_id }}</p> -->
     <!-- <a href="{{ route('list.index') }}">一覧に戻る</a> -->

    <div class="account-detail-content">
        <a class="account-detail-back-link" href="{{ url('/list') }}">
            <img class="account-detail-dami-img" src="{{ asset('storage/images/back_arrow.png') }}" alt="バックアイコン">
        </a>
        
        <!-- 写真 -->
        <div class="account-detail-pic-area">
            @if ($account->primaryPhoto)
                <img class="account-detail-pic-main" src="{{ asset('storage/' . $account->primaryPhoto->path) }}" width="200">
            @else
                <p>画像なし</p>
            @endif
            <div class="account-detail-dami-wrap">
                <img class="account-detail-dami-img" src="{{ asset('storage/images/dami_img.png') }}" alt="ロゴ">
                <img class="account-detail-dami-img" src="{{ asset('storage/images/dami_img.png') }}" alt="ロゴ">
                <img class="account-detail-dami-img" src="{{ asset('storage/images/dami_img.png') }}" alt="ロゴ">
            </div>
        </div>
        <!-- テキスト情報 -->
        <div class="account-detail-txt-area">
            <!-- 名前、年齢、住まい -->
            <div class="account-detail-txt-top-wrap">
                <div class="account-detail-txt-name">
                    {{ $account->display_name }}
                </div>
                <div class="account-detail-txt-age">
                    {{ $account->age_years }}
                </div>
                <div class="account-detail-txt-residence">
                    {{ $account->residence }}
                </div>
            </div>

            <!-- 自己紹介文 -->
            <div class="account-detail-txt-bio-wrap">
                <div class="account-detail-txt-bio-label">自己紹介文</div>

                <p class="account-detail-txt-bio-txt">
                    {{ $account->bio }}
                </p>
            </div>

            <!-- 基本情報 -->
             <div class="account-detail-txt-base-wrap">
                <div class="account-detail-txt-base-label">基本情報</div>


                <div class="account-detail-txt-base-items">
                    <div class="account-detail-txt-base-txt-label">
                        ニックネーム
                    </div>
                    <div class="account-detail-txt-base-txt-pro">
                        {{ $account->display_name }}
                    </div>
                </div>

                <div class="account-detail-txt-base-items">
                    <div class="account-detail-txt-base-txt-label">
                        年齢
                    </div>
                    <div class="account-detail-txt-base-txt-pro">
                        {{ $account->age_years }} 歳
                    </div>
                </div>

                <div class="account-detail-txt-base-items">
                    <div class="account-detail-txt-base-txt-label">
                        血液型
                    </div>
                    <div class="account-detail-txt-base-txt-pro">
                        {{ $account->blood_type }} 型
                    </div>
                </div>

                <div class="account-detail-txt-base-items">
                    <div class="account-detail-txt-base-txt-label">
                        居住地
                    </div>
                    <div class="account-detail-txt-base-txt-pro">
                       {{ $account->residence }}
                    </div>
                </div>

                <div class="account-detail-txt-base-items">
                    <div class="account-detail-txt-base-txt-label">
                        出身地
                    </div>
                    <div class="account-detail-txt-base-txt-pro">
                      {{ $account->hometown }}
                    </div>
                </div>

                <div class="account-detail-txt-base-items">
                    <div class="account-detail-txt-base-txt-label">
                        学歴
                    </div>
                    <div class="account-detail-txt-base-txt-pro">
                      {{ $account->education }}
                    </div>
                </div>


            </div>
        </div>


        <!--  -->
        {{-- いいね機能 --}}
        <div class="account-detail-btn-area">
            @if ($alreadyLiked)
                <!-- <form action="{{ route('like.destroy', $account->user_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                        💔 いいねを取り消す
                    </button>
                </form> -->
                <div class="account-detail-already-btn">既にいいねを送っています</div>
            @else
                <form action="{{ route('like.store', $account->user_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="account-detail-good-btn">
                        <img class="account-detail-good-btn-img" src="{{ asset('storage/images/good_btn.png') }}" alt="グッドボタン">
                        いいね！
                    </button>
                </form>
            @endif

        </div>

    <!-- {{-- いいね数の表示 --}}
    <div class="mt-3 text-gray-700">
        もらったいいね数：
        <span class="font-semibold">
            {{ $account->user->likesReceived->count() }}
        </span>
    </div>
        -->

    </div>
@endsection
