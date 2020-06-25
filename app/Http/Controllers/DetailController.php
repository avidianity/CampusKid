<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detail;
use App\User;
use App\Http\Requests\ValidateDetail;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $detail = $request->user()->detail;
        return ['data' => $detail];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateDetail $request)
    {
        if ($request->user()->detail) {
            return response(
                ['errors' => ['You already have your details filled up.']],
                403
            );
        }
        $detail = new Detail($request->validated());
        $request
            ->user()
            ->detail()
            ->save($detail);
        return $detail;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Detail $detail)
    {
        return $detail;
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
        $detail = $request->user()->detail;
        $detail->update($request->all());
        return $detail;
    }

    public function storeOther(ValidateDetail $request)
    {
        $creds = $request->get('credentials');
        $result = User::confirm($creds);
        if (!$result['status']) {
            return $result['response'];
        }
        $detail = new Detail($request->validated());
        $detail->user_id = isset($creds['email'])
            ? User::where('email', $creds['email'])->first()->id
            : User::where('username', $creds['username'])->first()->id;
        $detail->save();
        return $detail;
    }

    public function updateOther(Request $request, Detail $detail)
    {
        $result = User::confirm($request->get('credentials'));
        if (!$result['status']) {
            return $result['response'];
        }
        $detail->update($request->all());
        return $detail;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response('', 403);
    }
}
