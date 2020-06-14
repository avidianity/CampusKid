<?php

namespace App\Http\Controllers;

use App\TaskSubmissionFile;
use Illuminate\Http\Request;

class TaskSubmissionFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return TaskSubmissionFile::where(
            'task_submission_id',
            $request->input('task_submission_id')
        )
            ->with('file')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response(['errors' => ['Forbidden.']], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TaskSubmissionFile  $taskSubmissionFile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return TaskSubmissionFile::with('file')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaskSubmissionFile  $taskSubmissionFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response(['errors' => ['Forbidden.']], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TaskSubmissionFile  $taskSubmissionFile
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response(['errors' => ['Forbidden.']], 403);
    }
}
