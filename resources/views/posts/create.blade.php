<h1>新規投稿</h1>

@if ($errors->any())
  <ul style="color:red;">
    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
  </ul>
@endif

<form method="POST" action="{{ route('posts.store') }}">
  @csrf
  <div>
    <label>タイトル</label><br>
    <input type="text" name="title" value="{{ old('title') }}">
  </div>
  <div style="margin-top:8px;">
    <label>本文</label><br>
    <textarea name="body" rows="6">{{ old('body') }}</textarea>
  </div>
  <button type="submit" style="margin-top:8px;">保存</button>
</form>
