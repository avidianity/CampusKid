<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateFaculty;
use App\Department;
use App\Detail;
use App\Faculty;
use App\Occupation;
use App\User;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Faculty::with('user.detail')
            ->with('department')
            ->with('occupation')
            ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateFaculty $request)
    {
        $data = $request->validated();

        // Create User
        $data['access_level'] = User::FACULTY;
        $user = new User($data);
        $user->role_type = 'App\Faculty';
        $user->password = $data['password'];
        $user->setProviderAsSelf();
        $user->save();

        // Create Detail
        $detail = new Detail($data['detail']);
        $detail->user_id = $user->id;
        $detail->save();

        // Register as Faculty
        $faculty = new Faculty([
            'occupation_id' => $data['occupation_id'],
            'department_id' => $data['department_id'],
            'user_id' => $user->id,
        ]);
        $faculty->save();

        // Set Role ID for relationship polymorphism
        $user->role_id = $faculty->id;
        $user->save();

        $faculty->occupation = $faculty->occupation;
        $faculty->department = $faculty->department;
        $user->detail = $detail;
        $user->role = $faculty;
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
        return Faculty::with('user.detail')
            ->with('department')
            ->with('occupation')
            ->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faculty $faculty)
    {
        $data = $request->all();

        // Update User
        if (isset($data['password'])) {
            $faculty->user->password = $data['password'];
        }
        $faculty->user->fill($data)->save();

        // Update Detail
        if (isset($data['detail'])) {
            $faculty->user->detail->update($data['detail']);
        }

        // Update Faculty
        $faculty->update($data);

        $faculty->occupation = $faculty->occupation;
        $faculty->department = $faculty->department;
        $user = $faculty->user;
        $user->detail = $user->detail;
        unset($faculty->user);
        $user->role = $faculty;
        return ['user' => $user];
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
