<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', 'SelfController@index');
    Route::get('/auth/logout', 'Auth\LoginController@logout');

    Route::apiResources([
        'detail' => 'DetailController',
        'posts' => 'PostController',
        'files' => 'FileController',
    ]);

    Route::prefix('/post')->group(function () {
        Route::get('/comments', 'PostCommentController@index')->name(
            'post.comments.index'
        );
        Route::put('/comments/{comment}', 'PostCommentController@update')->name(
            'post.comments.update'
        );
        Route::get('/comments/{comment}', 'PostCommentController@show')->name(
            'post.comments.show'
        );
        Route::post('/comments', 'PostController@store')->name(
            'post.comments.store'
        );
        Route::delete(
            '/comments/{comment}',
            'PostCommentController@destroy'
        )->name('post.comments.destroy');
    });

    Route::middleware('only.admin')->group(function () {
        Route::apiResources([
            'administrators' => 'AdministratorController',
            'users' => 'UserController',
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

Route::group(['middleware' => ['auth:sanctum', 'only.admin']], function () {
    Route::get('/avidian', 'AnalyticsController@index');

    Route::get('/avidian/registers', 'AnalyticsController@registeredUsers');
    Route::get('/avidian/administrators', 'AnalyticsController@administrators');
    Route::get('/avidian/faculties', 'AnalyticsController@faculties');
    Route::get('/avidian/students', 'AnalyticsController@students');
    Route::get('/avidian/classrooms', 'AnalyticsController@classrooms');
    Route::get('/avidian/logins', 'AnalyticsController@logins');
});

Route::prefix('/auth')->group(function () {
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/login', 'Auth\LoginController@attempt');
});

Route::fallback('SelfController@fourZeroFour');
