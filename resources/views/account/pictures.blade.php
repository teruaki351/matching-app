{{-- resources/views/account/pictures/create.blade.php --}}
<x-app-layout>
  <x-slot name="header"><h2>写真をアップロード</h2></x-slot>

  @if (session('success'))
    <div class="p-3 mb-4 border rounded bg-green-50">{{ session('success') }}</div>
  @endif

  {{-- 既存の写真一覧 --}}
  <div class="grid grid-cols-3 gap-3 mb-6">
    @forelse($account->photos as $photo)
      <div class="border p-2 rounded">
        <img class="qawsed"  src="{{ asset('storage/'.$photo->path) }}" class=" w-full h-32 object-cover rounded">
        @if($photo->is_primary)
          <div class="text-xs mt-1">メイン</div>
        @endif
      </div>
    @empty
      <p>まだ写真がありません。</p>
    @endforelse
  </div>

  {{-- 複数ファイル受け取り --}}
  <form method="POST" action="{{ route('accounts.pictures.store', $account) }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="photos[]" accept="image/*" multiple class="mb-3">
    @error('photos')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    @error('photos.*')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror

    <button class="px-4 py-2 border rounded">アップロード</button>
  </form>
  <a href="{{ route('list.index') }}">一覧へ行く</a>
</x-app-layout>
