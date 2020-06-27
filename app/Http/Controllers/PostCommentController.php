<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostComment;
use App\Http\Requests\ValidatePostComment;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $post_id = $request->input('post_id');
        return PostComment::where('post_id', $post_id)
            ->with('user.detail')
            ->with('user.profile_picture')
            ->with('files')
            ->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidatePostComment $request)
    {
        $data = $request->validated();
        if (!$request->user()->canCommentToPost($data['post_id'])) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        $comment = new PostComment($data);
        $user = $request->user();
        $comment->user_id = $user->id;
        $comment->post_id = $data['post_id'];
        $comment->save();
        $user->detail = $user->detail;
        $user->profile_picture = $user->profile_picture;
        $comment->user = $user;
        return $comment;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PostComment::with('user.detail')
            ->with('user.profile_picture')
            ->with('files')
            ->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostComment $comment)
    {
        if (!$request->user()->ownsComment($comment)) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        $data = $request->only(['body']);
        if(!isset($data['body']) || empty($data['body'])) {
            return response(['errors' => ['body' => 'Body can\'t be empty.']], 422);
        }
        $comment->update($data);
        $user = $request->user();
        $user->detail = $user->detail;
        $user->profile_picture = $user->profile_picture;
        $comment->user = $user;
        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PostComment $comment)
    {
        if (!$request->user()->ownsComment($comment)) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        $comment->delete();
        return response('', 204);
    }
}
