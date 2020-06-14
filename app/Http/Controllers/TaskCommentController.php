<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskComment;
use App\Http\Requests\ValidateTaskComment;

class TaskCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return TaskComment::where('task_id', $request->input('task_id'))
            ->with('user.detail')
            ->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateTaskComment $request)
    {
        $data = $request->validated();
        if (!$request->user()->canCommentToTask($data['task_id'])) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        $comment = new TaskComment($data);
        $comment->task_id = $data['task_id'];
        $comment->user_id = $request->user()->id;
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
        return TaskComment::with('user.detail')->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskComment $comment)
    {
        if (!$request->user()->ownsComment($comment)) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        $comment->update($request->all());
        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskComment $comment)
    {
        if (!$request->user()->ownsComment($comment)) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        $comment->delete();
        return ['status' => true];
    }
}
