<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateTaskSubmission;
use App\TaskSubmission;

class TaskSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return TaskSubmission::where('task_id', $request->input('task_id'))
            ->with('task')
            ->with('student.user.detail')
            ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateTaskSubmission $request)
    {
        $data = $request->validated();
        $task_id = $data['task_id'];
        if (!$request->user()->canSubmitToTask($task_id)) {
            return response(
                ['errors' => ['You do not belong to this task\'s classroom.']],
                403
            );
        }
        if (
            TaskSubmission::alreadySubmitted(
                $task_id,
                $request->user()->role->id
            )
        ) {
            return response(
                ['errors' => ['You have already submitted on this task.']],
                400
            );
        }
        $submission = new TaskSubmission($request->all());
        $submission->task_id = $task_id;
        $submission->student_id = $request->user()->role->id;
        $submission->save();
        return $submission;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return TaskSubmission::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $submission = TaskSubmission::where(
            'student_id',
            $request->user()->role->id
        )
            ->where('task_id', $id)
            ->first();
        $submission->update($request->all());
        return $submission;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $submission = $request
            ->user()
            ->role->subscriptions->classroom->tasks->submissions->findOrFail(
                $id
            );
        $submission->delete();
        return $submission;
    }
}
