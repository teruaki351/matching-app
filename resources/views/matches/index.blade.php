

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">

    <h1 class="text-2xl font-bold mb-4">マッチしているユーザー</h1>

    @if ($accounts->isEmpty())
        <p>まだマッチしている人はいません。</p>
    @else
        <div class="grid gap-4 md:grid-cols-2">
            @foreach ($accounts as $account)
                <a href="{{ route('conversations.with', $account->user_id) }}" class="block border rounded p-4 hover:bg-gray-50">
                    {{-- アイコン（あれば） --}}
                    @if ($account->primaryPhoto)
                        <img src="{{ asset('storage/'.$account->primaryPhoto->path) }}"
                             alt="avatar"
                             class="w-16 h-16 rounded-full object-cover mb-2">
                    @endif

                    <div class="font-semibold text-lg">
                        {{ $account->display_name }}
                    </div>

                    <div class="text-sm text-gray-600">
                        年齢：{{ $account->age ? $account->age.'歳' : '未設定' }} /
                        居住地：{{ $account->residence ?? '未設定' }}
                    </div>

                    <div class="text-sm text-gray-500 mt-1">
                        自己紹介：{{ \Illuminate\Support\Str::limit($account->bio, 40) }}
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $accounts->links() }}
        </div>
    @endif

</div>
@endsection
