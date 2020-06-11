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
        $comment->user_id = $request->user()->id;
        $comment->post_id = $data['post_id'];
        $comment->save();
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
            ->with('files')
            ->find($id);
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
        $comment->update($request->all());
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
        $comment->files->each(function ($file) {
            $file->delete();
        });
        $comment->delete();
        return ['status' => true];
    }
}
