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
            ->with('files')
            ->with('user.detail')
            ->with('user.profile_picture')
            ->with('comments.user.detail')
            ->with('comments.user.profile_picture')
            ->with('comments.files')
            ->orderBy('updated_at', 'DESC')
            ->paginate(5);
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
        if (!$request->user()->canPostToClassroom($data['classroom_id'])) {
            return response(
                ['errors' => ['You cannot post to this class.']],
                403
            );
        }
        $data['user_id'] = $request->user()->id;
        $post = Post::create($data);
        $post->saveFiles($request);
        $post->comments = [];
        $user = $request->user();
        $user->detail = $user->detail;
        $user->profile_picture = $user->profile_picture;
        $post->user = $user;
        return $post;
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
        return Post::with('files')
            ->with('user.detail')
            ->with('user.profile_picture')
            ->with('comments.user.detail')
            ->with('comments.user.profile_picture')
            ->with('comments.files')
            ->find($post->id);
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
        if (!$request->user()->ownsPost($post)) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        $data = $request->only(['body']);
        $post->update($data);
        $post->comments = $post
            ->comments()
            ->with('user.detail')
            ->with('files')
            ->get();
        $user = $post->user;
        $user->detail = $user->detail;
        $user->profile_picture = $user->profile_picture;
        $post->user = $user;
        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post)
    {
        if (!$request->user()->ownsPost($post)) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        $post->delete();
        return response('', 204);
    }
}
