<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use App\ClassroomSubscription;

class ClassroomSubscriptionController extends Controller
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
            ->classroomSubscriptions()
            ->with('classroom.faculty')
            ->with('classroom.department')
            ->with('grade')
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
        $token = $request->input('token');
        ($classroom = Classroom::where('token', $token)->first()) or
            abort(404, 'Invalid Token');
        if ($request->user()->role->isSubscribedToClassroom($classroom->id)) {
            return response(
                ['errors' => ['You are already subscribed to this classroom.']],
                400
            );
        }
        $subscription = new ClassroomSubscription([
            'student_id' => $request->user()->role->id,
            'classroom_id' => $classroom->id,
        ]);
        $subscription->save();
        return $subscription;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return $request
            ->user()
            ->classroomSubscriptions()
            ->with('classroom.faculty')
            ->with('classroom.department')
            ->with('grade')
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
        return response(['errors' => ['Forbidden.']], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $subscription = $request
            ->user()
            ->classroomSubscriptions()
            ->findOrFail($id);
        $subscription->delete();
        return ['status' => true];
    }
}
