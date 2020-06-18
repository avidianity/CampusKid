<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'Auth\LoginController@check');

    Route::apiResources([
        'detail' => 'DetailController',
        'posts' => 'PostController',
    ]);

    Route::prefix('/post')->group(function () {
        Route::apiResources([
            'comments' => 'PostCommentController',
        ]);
    });

    Route::middleware('only.admin')->group(function () {
        Route::apiResources([
            'administrators' => 'AdministratorController',
        ]);

        Route::apiResource('faculties', 'FacultyController')->only([
            'store',
            'update',
            'destroy',
        ]);
    });

    Route::middleware('only.faculty')->group(function () {
        Route::apiResources([
            'classrooms' => 'ClassroomController',
        ]);

        Route::prefix('/classroom')->group(function () {
            Route::apiResource('tasks', 'TaskController');
            Route::apiResource('grades', 'GradeController')->except('index');
        });
    });

    Route::apiResource('classroom/task/comments', 'TaskCommentController');

    Route::middleware('only.student')->group(function () {
        Route::get('classroom/grades', 'GradeController@index');
        Route::apiResource(
            'student/classes',
            'ClassroomSubscriptionController'
        );

        Route::apiResource(
            '/classroom/task/submissions',
            'TaskSubmissionController'
        )->except(['index', 'show']);
    });

    Route::apiResource(
        '/classroom/task/submissions',
        'TaskSubmissionController'
    )->only(['index', 'show']);

    Route::middleware('forbid.student')->group(function () {
        Route::apiResource('occupations', 'OccupationController')->only([
            'store',
            'update',
            'destroy',
        ]);

        Route::apiResource('departments', 'DepartmentController')->only([
            'store',
            'update',
            'destroy',
        ]);

        Route::apiResource('students', 'StudentController')->only([
            'store',
            'update',
            'destroy',
        ]);

        Route::apiResource('subjects', 'SubjectController')->only([
            'store',
            'update',
            'destroy',
        ]);
    });

    Route::apiResource('faculties', 'FacultyController')->only([
        'index',
        'show',
    ]);

    Route::apiResource('students', 'StudentController')->only([
        'index',
        'show',
    ]);

    Route::apiResource('subjects', 'SubjectController')->only([
        'index',
        'show',
    ]);
});

Route::apiResource('occupations', 'OccupationController')->only([
    'index',
    'show',
]);

Route::apiResource('departments', 'DepartmentController')->only([
    'index',
    'show',
]);

Route::prefix('/auth')->group(function () {
    Route::post('/register', 'Auth\RegisterController@store');
    Route::post('/login', 'Auth\LoginController@attempt');
});
