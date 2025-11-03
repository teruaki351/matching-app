{{-- resources/views/conversations/show.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="message-content">
  <h1 class="text-xl font-bold mb-4">会話（文字を追加したとお）</h1>
  <h2>新しいブランチを作成したよ</h2>

  {{-- メッセージ一覧 --}}
      <div class="space-y-2 mb-4">
          @forelse ($conversation->messages as $message)
            @php
                $isMe = $message->user_id === auth()->id();
            @endphp

          {{-- 自分のメッセージ --}}
          @if ($isMe)
              <div class="flex justify-end mb-2">
                  <div class="bg-blue-500 text-white px-3 py-2 rounded-lg max-w-xs text-sm shadow">
                      <div class="font-semibold text-right">あなた</div>
                      <div class="mt-1">{{ $message->body }}</div>
                      <div class="text-[10px] text-right opacity-70 mt-1">
                          {{ $message->created_at->format('Y/m/d H:i') }}
                      </div>
                  </div>
              </div>

          {{-- 相手のメッセージ --}}
          @else
              <div class="flex justify-start mb-2">
                  <div class="bg-gray-200 text-gray-900 px-3 py-2 rounded-lg max-w-xs text-sm shadow">
                      <div class="font-semibold text-gray-700">{{ $message->user->name ?? '相手' }}</div>
                      <div class="mt-1">{{ $message->body }}</div>
                      <div class="text-[10px] text-right opacity-60 mt-1">
                          {{ $message->created_at->format('Y/m/d H:i') }}
                      </div>
                  </div>
              </div>
          @endif

          @empty
              <p class="text-sm text-gray-500">まだメッセージはありません。</p>
          @endforelse
      </div>



  <form action="{{ route('messages.store',$conversation) }}" method="post" class="flex gap-2">
    @csrf
    <input name="body" class="flex-1 border rounded px-3 py-2" placeholder="メッセージ…" required maxlength="4000">
    <button class="px-4 py-2 bg-blue-600 text-white rounded">送信</button>
  </form>

</div>


@endsection
