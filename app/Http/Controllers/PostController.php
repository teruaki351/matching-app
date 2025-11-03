<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // posts テーブルの全レコードを取得
        $posts = Post::all();

        // ビューに渡す
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1) バリデーション
        $validated = $request->validate([
            'title' => ['required','string','max:255'],
            'body'  => ['required','string'],
        ]);

        // 2) 保存（Postモデルは $fillable に title, body を指定済みであること）
        Post::create($validated);

        // 3) リダイレクト（好きな行き先でOK）
        return redirect('/posts')->with('success', '投稿を保存しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
