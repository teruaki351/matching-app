{{-- resources/views/conversations/index.blade.php --}}
@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">メッセージ</h1>

@forelse ($conversations as $c)
  @php
    $me = auth()->id();
    $partnerId = $c->user_one_id === $me ? $c->user_two_id : $c->user_one_id;
  @endphp
  <a href="{{ route('conversations.show',$c) }}" class="block p-3 border rounded mb-2">
    相手: ユーザーID {{ $partnerId }}
  </a>
@empty
  <p>会話がありません。k</p>
@endforelse
@endsection
