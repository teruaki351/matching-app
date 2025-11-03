<h1>運命の相手を探そう！</h1>

<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl">ユーザー一覧</h2></x-slot>

  {{-- 簡易フィルタ（任意） --}}
  <!-- <form method="GET" class="mb-4 flex gap-3 items-end">
    <div>
      <label class="block text-sm">性別</label>
      <select name="gender" class="border rounded p-2">
        <option value="">指定なし</option>
        <option value="male"   @selected(request('gender')==='male')>male</option>
        <option value="female" @selected(request('gender')==='female')>female</option>
        <option value="other"  @selected(request('gender')==='other')>other</option>
      </select>
    </div>
    <div>
      <label class="block text-sm">年齢</label>
      <div class="flex items-center gap-2">
        <input name="age_min" type="number" value="{{ request('age_min') }}" class="w-20 border rounded p-2" placeholder="18">
        <span>〜</span>
        <input name="age_max" type="number" value="{{ request('age_max') }}" class="w-20 border rounded p-2" placeholder="99">
      </div>
    </div>
    <button class="border rounded px-3 py-2">絞り込み</button>
  </form> -->

  {{-- 一覧 --}}
  <div class="list-wrap">
    @forelse($accounts as $a)
      @php
        $img = $a->primaryPhoto->path ?? $a->avatar_path ?? null;
        $age = $a->birthday ? \Carbon\Carbon::parse($a->birthday)->age : null;
      @endphp


      <a href="{{ route('accounts.show', $a->id) }}" class="list-items">
        <div class="img-wrap">
          @if($img)
            <img src="{{ asset('storage/'.$img) }}"  class="list-img">
          @else
            <div class="w-full h-40 bg-gray-100 rounded grid place-items-center text-sm text-gray-500">No Photo</div>
          @endif
        </div>

        <div class="list-txt-wrap">
          <div class="list-txt-age">
            34歳
          <!-- 年齢：{{ $a->age ? $a->age . '歳' : '未設定' }} -->
          </div>
          <div class="list-txt-name">{{ $a->display_name }}</div>
        </div> 

      </a>






    @empty
      <p>表示できるユーザーがいません。</p>
    @endforelse
  </div>



  

  <div class="mt-4">
    {{ $accounts->links() }}
  </div>
</x-app-layout>
