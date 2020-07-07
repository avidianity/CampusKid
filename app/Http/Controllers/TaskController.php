<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App\Task;
use App\TaskFile;
use App\Http\Requests\ValidateTask;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Task::where('classroom_id', $request->input('classroom_id'))
            ->with('files')
            ->with('comments.user')
            ->with('submissions')
            ->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateTask $request)
    {
        $data = $request->validated();
        $task = new Task($data);
        $task->save();
        $files = File::saveFromRequest($request);
        foreach($files as $file)
        {
            TaskFile::create([
                'task_id' => $task->id,
                'file_id' => $file->id
            ]);
        }
        return Task::with('comments.user.detail')
            ->with('comments.user.profile_picture')
            ->with('files')
            ->with('submissions')->find($task->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        if (!$request->user()->ownsTask($task)) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        $task->update($request->all());
        return $task;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Task $task)
    {
        if (!$request->user()->ownsClassroom($task->classroom_id)) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        $task->comments->each(function ($comment) {
            $comment->delete();
        });
        $task->files->each(function ($file) {
            $file->delete();
        });
        $task->delete();
        return ['status' => true];
    }
}
