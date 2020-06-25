<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateStudent;
use App\Detail;
use App\Student;
use App\User;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Student::with('user.detail')
            ->with('user.profile_picture')
            ->with('user.cover_photo')
            ->with('department')
            ->with('classrooms')
            ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateStudent $request)
    {
        $data = $request->validated();

        // Create User
        $data['access_level'] = User::STUDENT;
        $user = new User($data);
        $user->role_type = 'App\Student';
        $user->password = $data['password'];
        $user->setProviderAsSelf();
        $user->save();

        // Create Detail
        $detail = new Detail($data['detail']);
        $detail->user_id = $user->id;
        $detail->save();

        // Register as Faculty
        $student = new Student([
            'department_id' => $data['department_id'],
            'user_id' => $user->id,
        ]);
        $student->save();

        // Set Role ID for relationship polymorphism
        $user->role_id = $student->id;
        $user->save();

        $student->department = $student->department;
        $user->detail = $detail;
        $user->role = $student;
        return ['user' => $user];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Student::with('user.detail')
            ->with('user.profile_picture')
            ->with('user.cover_photo')
            ->with('department')
            ->with('classrooms')
            ->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $data = $request->all();

        // Update User
        if (isset($data['password'])) {
            $student->user->password = $data['password'];
        }
        $student->user->fill($data)->save();

        // Update Detail
        if (isset($data['detail'])) {
            $student->user->detail->update($data['detail']);
        }

        // Update Student
        $student->update($data);

        $student->department = $student->department;
        $user = $student->user;
        $user->detail = $user->detail;
        unset($student->user);
        $user->role = $student;
        return ['user' => $user];
    }

    public function updateOther(Request $request, Student $student)
    {
        $result = User::confirm($request->get('credentials'));
        if (!$result['status']) {
            return $result['response'];
        }
        $student->update($request->except(['user_id']));
        return $student;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response('', 405);
    }
}
