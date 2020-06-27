<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use App\Http\Requests\ValidateClassroom;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->isFaculty()) {
            return Classroom::where('faculty_id', $user->role->id)
                ->with('department')
                ->with('students.user.detail')
                ->with('students.user.profile_picture')
                ->with('students.user.cover_photo')
                ->with('subject')
                ->with('profile_picture')
                ->with('cover_photo')
                ->with('tasks.comments.user.detail')
                ->with('tasks.comments.user.profile_picture')
                ->with('tasks.files')
                ->with('tasks.submissions')
                ->paginate(10);
        } else {
            return Classroom::with('faculty.user.detail')
                ->with('faculty.occupation')
                ->with('department')
                ->with('students.user.detail')
                ->with('students.user.profile_picture')
                ->with('students.user.cover_photo')
                ->with('subject')
                ->with('profile_picture')
                ->with('cover_photo')
                ->with('tasks.comments.user.detail')
                ->with('tasks.comments.user.profile_picture')
                ->with('tasks.files')
                ->with('tasks.submissions')
                ->paginate(10);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateClassroom $request)
    {
        $data = $request->validated();
        $classroom = new Classroom($data);
        $classroom->faculty_id = $request->user()->role->id;
        $classroom->generateToken();
        $classroom->save();
        return $classroom;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        if ($user->isAdministrator()) {
            return Classroom::with('faculty.user.detail')
                ->with('faculty.occupation')
                ->with('department')
                ->with('students.user.detail')
                ->with('students.user.profile_picture')
                ->with('students.user.cover_photo')
                ->with('subject')
                ->with('profile_picture')
                ->with('cover_photo')
                ->with('tasks.comments.user.detail')
                ->with('tasks.comments.user.profile_picture')
                ->with('tasks.files')
                ->with('tasks.submissions')
                ->findOrFail($id);
        } else {
            return $user->role
                ->classrooms()
                ->with('faculty.occupation')
                ->with('department')
                ->with('students.user.detail')
                ->with('students.user.profile_picture')
                ->with('students.user.cover_photo')
                ->with('subject')
                ->with('profile_picture')
                ->with('cover_photo')
                ->with('tasks.comments.user.detail')
                ->with('tasks.comments.user.profile_picture')
                ->with('tasks.files')
                ->with('tasks.submissions')
                ->findOrFail($id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classroom $classroom)
    {
        $classroom->update($request->all());
        return $classroom;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom)
    {
        return response('', 405);
    }
}
