<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App\User;

class SelfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return User::with('role')
            ->with('detail')
            ->with('profile_picture')
            ->with('cover_photo')
            ->with('role')
            ->find($request->user()->id);
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
        return response('', 405);
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
            $file = File::saveOne($request->file('profile_picture'));
            if($file)
            {
                $data['profile_picture_id'] = $file->id;
            }
        }
        if (isset($files['cover_photo'])) {
            $file = File::saveOne($request->file('cover_photo'));
            if($file)
            {
                $data['cover_photo_id'] = $file->id;
            }
        }
        $user->update($data);
        $user->detail->update($request->all());
        return User::with('role')
            ->with('detail')
            ->with('profile_picture')
            ->with('cover_photo')
            ->with('role')
            ->find($user->id);
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

    public function fourZeroFour()
    {
        return response('', 404);
    }

    public function main()
    {
        return view('main');
    }
}
