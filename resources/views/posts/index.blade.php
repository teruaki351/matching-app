<h1>投稿一覧</h1>

<a href="{{ route('posts.create') }}">新規投稿</a>

<ul>
  @foreach ($posts as $post)
    <li>
      <strong>{{ $post->title }}</strong><br>
      {{ $post->body }}<br>
      <small>{{ $post->created_at }}</small>
    </li>
  @endforeach
</ul>
