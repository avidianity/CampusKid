<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Administrator;
use App\Detail;
use App\Occupation;
use App\User;
use App\Http\Requests\ValidateAdministrator;

class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Administrator::with('user.detail')
            ->with('occupation')
            ->with('user.profile_picture')
            ->with('user.cover_photo')
            ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateAdministrator $request)
    {
        $data = $request->validated();

        // Create User
        $data['access_level'] = User::ADMIN;
        $user = new User($data);
        $user->role_type = 'App\Administrator';
        $user->password = $data['password'];
        $user->setProviderAsSelf();
        $user->save();

        // Create Detail
        $detail = new Detail($data['detail']);
        $detail->user_id = $user->id;
        $detail->save();

        // Register as Admin
        $admin = new Administrator([
            'occupation_id' => $data['occupation_id'],
            'user_id' => $user->id,
        ]);
        $admin->save();

        // Set Role ID for relationship polymorphism
        $user->role_id = $admin->id;
        $user->save();

        // Nest everything
        $admin->occupation = Occupation::find($admin->occupation_id);
        $user->detail = $detail;
        $user->role = $admin;

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
        return $administrator
            ->with('user.detail')
            ->with('occupation')
            ->with('user.profile_picture')
            ->with('user.cover_photo')
            ->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Administrator $administrator)
    {
        $data = $request->all();

        $user = $administrator->user;
        $detail = $user->detail;
        if (isset($data['password'])) {
            $user->password = $data['password'];
        }
        $user->fill($data);

        if (isset($data['occupation_id'])) {
            try {
                $occupation = Occupation::findOrFail($data['occupation_id']);
            } catch (ModelNotFoundException $e) {
                return response(
                    [
                        'errors' => [
                            'occupation_id' => 'Occupation does not exist.',
                        ],
                    ],
                    442
                );
            }
            $administrator->occupation_id = $occupation->id;
            $administrator->occupation = $occupation;
        }

        // Save everything
        $user->save();
        if (isset($data['detail'])) {
            $detail->update($data['detail']);
        }
        $administrator->save();

        $response = $user->toArray();
        $administrator->occupation = $administrator->occupation;
        unset($administrator->user);
        $response['detail'] = $detail;
        $response['role'] = $administrator;
        return ['user' => $response];
    }

    public function updateOther(Request $request, Administrator $admin)
    {
        $result = User::confirm($request->get('credentials'));
        if (!$result['status']) {
            return $result['response'];
        }
        $admin->update($request->except(['user_id']));
        return $admin;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Administrator $administrator)
    {
        if ($request->user()->id === $administrator->user->id) {
            return response(
                ['errors' => ['You cannot delete your own account.']],
                403
            );
        }
        $administrator->user->delete();
        return ['status' => true];
    }
}
