<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = \Request::query();
        if (isset($q['name'])) {
            $posts = Post::orderBy('created_at', 'desc')
                ->where('body', 'like', "%#{$q['name']}%")
                ->paginate(5);
            $user = auth()->user();
            return view('post.index', [
                'posts' => $posts,
                'user' => $user,
                'name' => $q['name'],
            ]);
        } else {
            $posts = Post::orderBy('created_at', 'desc')
                ->paginate(5);
            $user = auth()->user();
            return view('post.index', [
                'posts' => $posts,
                'user' => $user,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'title'=>'required|max:255',
            'body'=>'required|max:1000',
            'image1'=>'image|max:1024',
            'image2'=>'image|max:1024',
            'image3'=>'image|max:1024',
            'tags'=>['nullable', 'string'],
        ]);
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->user()->id; //　認証済みログイン中のユーザid
        if (request('image1')){
            $original = request()->file('image1')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            request()->file('image1')->move('storage/images', $name);
            $post->image1 = $name;
        }
        if (request('image2')){
            $original = request()->file('image2')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            request()->file('image2')->move('storage/images', $name);
            $post->image2 = $name;
        }
        if (request('image3')){
            $original = request()->file('image3')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            request()->file('image3')->move('storage/images', $name);
            $post->image3 = $name;
        }

        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->body, $match);
        $tags = [];
        foreach ($match[1] as $tag) {
            $record = Tag::firstOrCreate(['name' => $tag]);
            array_push($tags, $record);
        }
        $tags_id = [];
        foreach ($tags as $tag) {
            array_push($tags_id, $tag['id']);
        }
        $post->save();
        $post->tags()->attach($tags_id);
        return redirect()->route('post.create')->with('message', '投稿を作成しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $inputs=$request->validate([
            'title'=>'required|max:255',
            'body'=>'required|max:1000',
            'image1'=>'image|max:1024',
            'image2'=>'image|max:1024',
            'image3'=>'image|max:1024',
            'tags'=>['nullable', 'string'],
        ]);

        $post->title=$request->title;
        $post->body=$request->body;

        if (request('image1')){
            $original = request()->file('image1')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            request()->file('image1')->move('storage/images', $name);
            $post->image1 = $name;
        }
        if (request('image2')){
            $original = request()->file('image2')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            request()->file('image2')->move('storage/images', $name);
            $post->image2 = $name;
        }
        if (request('image3')){
            $original = request()->file('image3')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            request()->file('image3')->move('storage/images', $name);
            $post->image3 = $name;
        }

        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->body, $match);
        $tags = [];
        foreach ($match[1] as $tag) {
            $record = Tag::firstOrCreate(['name' => $tag]);
            array_push($tags, $record);
        }
        $tags_id = [];
        foreach ($tags as $tag) {
            array_push($tags_id, $tag['id']);
        }

        $post->save();
        // $post->tags()->syncWithoutDetaching($tags_id);
        $post->tags()->sync($tags_id);

        return redirect()->route('post.show', $post)->with('message', '投稿を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('post.index')->with('message', '投稿を削除しました');
    }
}
?>
