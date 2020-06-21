<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Administrator;
use App\Faculty;
use App\Student;
use App\Classroom;
use App\Login;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        echo json_encode([
            'user' => User::whereBetween('created_at', [
                date('Y-m-') . '01',
                date('Y-m-t'),
            ])->count(),
            'admin' => Administrator::whereBetween('created_at', [
                date('Y-m-') . '01',
                date('Y-m-t'),
            ])->count(),
            'faculty' => Faculty::whereBetween('created_at', [
                date('Y-m-') . '01',
                date('Y-m-t'),
            ])->count(),
            'student' => Student::whereBetween('created_at', [
                date('Y-m-') . '01',
                date('Y-m-t'),
            ])->count(),
            'classroom' => Classroom::count(),
            'login' => Login::whereBetween('date', [
                date('Y-m-') . '01',
                date('Y-m-t'),
            ])->count(),
        ]);
    }

    public function registeredUsers(Request $request)
    {
        return [
            'count' => User::whereBetween('created_at', [
                date('Y-m-') . '01',
                date('Y-m-t'),
            ])->count(),
        ];
    }

    public function administrators(Request $request)
    {
        return [
            'count' => Administrator::whereBetween('created_at', [
                date('Y-m-') . '01',
                date('Y-m-t'),
            ])->count(),
        ];
    }

    public function faculties(Request $request)
    {
        return [
            'count' => Faculty::whereBetween('created_at', [
                date('Y-m-') . '01',
                date('Y-m-t'),
            ])->count(),
        ];
    }

    public function students(Request $request)
    {
        return [
            'count' => Student::whereBetween('created_at', [
                date('Y-m-') . '01',
                date('Y-m-t'),
            ])->count(),
        ];
    }

    public function classrooms(Request $request)
    {
        return ['count' => Classroom::count()];
    }

    public function logins(Request $request)
    {
        return [
            'count' => Login::whereBetween('date', [
                date('Y-m-') . '01',
                date('Y-m-t'),
            ])->count(),
        ];
    }
}
