<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">アカウント作成</h2>
    </x-slot>

    <div class="max-w-xl mx-auto p-6">
        @if (session('success'))
            <div class="p-3 mb-4 border rounded bg-green-50">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('accounts.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium">表示名</label>
                <input name="display_name" value="{{ old('display_name') }}" class="w-full border rounded p-2">
                @error('display_name')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">自己紹介</label>
                <textarea name="bio" class="w-full border rounded p-2">{{ old('bio') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">誕生日</label>
                <input type="date" name="birthday" value="{{ old('birthday') }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">性別</label>
                <select name="gender" class="w-full border rounded p-2">
                    <option value="">未選択</option>
                    <option value="male"   @selected(old('gender')==='male')>male</option>
                    <option value="female" @selected(old('gender')==='female')>female</option>
                    <option value="other"  @selected(old('gender')==='other')>other</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">都道府県</label>
                <input name="location_pref" value="{{ old('location_pref') }}" class="w-full border rounded p-2">
            </div>

            <div class="grid grid-cols-2 gap-3 mb-6">
                <label>lat <input name="lat" value="{{ old('lat') }}" class="w-full border rounded p-2"></label>
                <label>lng <input name="lng" value="{{ old('lng') }}" class="w-full border rounded p-2"></label>
            </div>

            <button class="px-4 py-2 border rounded">作成する</button>
        </form>
    </div>
</x-app-layout>
