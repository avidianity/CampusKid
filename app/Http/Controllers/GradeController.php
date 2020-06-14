<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateGrade;
use App\Grade;
use App\Student;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request
            ->user()
            ->grades()
            ->with('classroom.faculty')
            ->with('classroom.department')
            ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateGrade $request)
    {
        $data = $request->validated();
        $user = $request->user();
        if (!$request->user()->ownsClassroom($data['classroom_id'])) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        if (
            !Student::belongsToClassroom(
                $data['student_id'],
                $data['classroom_id']
            )
        ) {
            return response(
                [
                    'errors' => ['Student does not belong in this classroom.'],
                ],
                422
            );
        }
        if (Grade::alreadyExists($data['student_id'], $data['classroom_id'])) {
            return response(
                [
                    'errors' => [
                        'You have already given grades to this student. Did you mean to update it?',
                    ],
                ],
                422
            );
        }
        $grade = new Grade($data);
        $grade->classroom_id = $data['classroom_id'];
        $grade->student_id = $data['student_id'];
        $grade->save();
        return $grade;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        return $grade;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grade $grade)
    {
        if (!$request->user()->ownsGrade($grade)) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        $grade->update($request->all());
        return $grade;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($request, Grade $grade)
    {
        if (!$request->user()->ownsGrade($grade)) {
            return response(['errors' => ['Forbidden.']], 403);
        }
        $grade->delete();
        return ['status' => true];
    }
}
