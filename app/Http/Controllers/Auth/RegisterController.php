<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUser;
use App\User;
use App\Faculty;
use App\Student;

class RegisterController extends Controller
{
    public function store(RegisterUser $request)
    {
        $data = $request->validated();
        $user = new User($data);
        $user->password = $data['password'];
        $user->role_type = 'App\\' . $user->access_level;
        $user->setProviderAsSelf()->save();
        $role_class = 'App\\' . $user->access_level;
        $data['user_id'] = $user->id;
        $role = new $role_class($data);
        $role->save();
        $user->role_id = $role->id;
        $user->save();
        return ['status' => true, 'data' => $user];
    }
}
