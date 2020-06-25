<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return User::with('profile_picture')
            ->with('role')
            ->with('detail')
            ->with('cover_photo')
            ->findOrFail($id);
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
        $user->update($request->all());
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
