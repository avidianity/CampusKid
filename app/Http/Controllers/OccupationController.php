<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Occupation;
use App\Http\Requests\ValidateOccupation;

class OccupationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Occupation::with('faculties.user.detail')
            ->with('administrators.user.detail')
            ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateOccupation $request)
    {
        return Occupation::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Occupation::with('faculties.user.detail')
            ->with('administrators.user.detail')
            ->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Occupation $occupation)
    {
        $occupation->update($request->all());
        return $occupation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Occupation $occupation)
    {
        return response('', 405);
    }
}
