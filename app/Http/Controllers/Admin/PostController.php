<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $request->user()->posts()->create([
            'title' => $request->title,
        ]);

        return response([''], 201);
    }

    public function update(Post $post , UpdatePostRequest $request)
    {
        $post->update([
            'title' => $request->title,
        ]);

        return 'Post updated!';
    }
}
