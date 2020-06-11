<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\ValidatePost;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if (!isset($data['classroom_id'])) {
            return response(
                ['errors' => ['You must provide a Classroom ID']],
                422
            );
        }
        return Post::where('classroom_id', $data['classroom_id'])
            ->with('user.detail')
            ->with('comments.user.detail')
            ->with('comments.files')
            ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidatePost $request)
    {
        $data = $request->validated();
        if (
            !$request
                ->user()
                ->canPostToClassroom($request->input('classroom_id'))
        ) {
            return response(
                ['errors' => ['You cannot post to this class.']],
                403
            );
        }
        $data['user_id'] = $request->user()->id;
        return Post::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Post $post)
    {
        if (!$request->user()->canPostToClassroom($post->classroom_id)) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        return $post
            ->with('user.detail')
            ->with('comments.user.detail')
            ->with('comments.files')
            ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->only(['body']);
        $post->update($data);
        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        return response('', 405);
    }
}
