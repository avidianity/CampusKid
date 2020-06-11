<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'Auth\LoginController@check');

    Route::resources([
        'detail' => 'DetailController',
    ]);

    Route::middleware('only.admin')->group(function () {
        Route::resources([
            'administrators' => 'AdministratorController',
        ]);

        Route::resource('faculties', 'FacultyController')->only([
            'store',
            'update',
            'destroy',
        ]);
    });

    Route::middleware('only.faculty')->group(function () {
        Route::resources([
            'classrooms' => 'ClassroomController',
        ]);
    });

    Route::middleware('forbid.student')->group(function () {
        Route::resource('occupations', 'OccupationController')->only([
            'store',
            'update',
            'destroy',
        ]);

        Route::resource('departments', 'DepartmentController')->only([
            'store',
            'update',
            'destroy',
        ]);

        Route::resource('students', 'StudentController')->only([
            'store',
            'update',
            'destroy',
        ]);
    });

    Route::resource('occupations', 'OccupationController')->only([
        'index',
        'show',
    ]);

    Route::resource('departments', 'DepartmentController')->only([
        'index',
        'show',
    ]);

    Route::resource('faculties', 'FacultyController')->only(['index', 'show']);

    Route::resource('students', 'StudentController')->only(['index', 'show']);
});

Route::prefix('/auth')->group(function () {
    Route::post('/register', 'Auth\RegisterController@store');
    Route::post('/login', 'Auth\LoginController@attempt');
});
