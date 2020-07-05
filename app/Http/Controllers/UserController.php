<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('profile_picture')
            ->with('role')
            ->with('detail')
            ->with('cover_photo')
            ->with('role')
            ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response('', 405);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('profile_picture')
            ->with('role')
            ->with('detail')
            ->with('cover_photo')
            ->with('role')
            ->findOrFail($id);
        if ($user->isAdministrator()) {
            $user->role->occupation = $user->role->occupation;
        } elseif ($user->isFaculty()) {
            $user->role->occupation = $user->role->occupation;
            $user->role->department = $user->role->department;
        } elseif ($user->isStudent()) {
            $user->role->department = $user->role->department;
        }
        return $user;
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
        $user = $request->user();
        $data = $request->only(['email', 'username']);
        $files = $request->only(['profile_picture', 'cover_photo']);
        if (isset($files['profile_picture'])) {
            $file = File::saveOne($files['profile_picture']);
            $data['profile_picture_id'] = $file->id;
        }
        if (isset($files['cover_photo'])) {
            $file = File::saveOne($files['cover_photo']);
            $data['cover_photo_id'] = $file->id;
        }
        $user->update($data);
        return $user;
    }

    public function updateOther(Request $request, User $user)
    {
        $result = User::confirm($request->get('credentials'));
        if (!$result['status']) {
            return $result['response'];
        }
        $data = $request->all();
        $user->fill($data);
        if (isset($data['password']) && !empty(trim($data['password']))) {
            $user->password = $data['password'];
        }
        $user->save();
        return $user;
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
