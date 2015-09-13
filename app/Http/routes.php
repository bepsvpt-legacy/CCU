<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

get('/', ['as' => 'home', 'uses' => 'HomeController@home']);

Route::group(['prefix' => 'api', 'namespace' => 'Api', 'as' => 'api.'], function () {
    get('information/{name}', ['as' => 'information', 'uses' => 'WebsiteController@information']);

    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        post('sign-in', ['as' => 'signIn', 'uses' => 'AuthController@signIn']);
        get('sign-out', ['as' => 'signOut', 'uses' => 'AuthController@signOut']);
        post('register', ['as' => 'register', 'uses' => 'AuthController@register']);
        get('register/verify-email/{token}', ['as' => 'verifyEmail', 'uses' => 'AuthController@verifyEmail']);
        get('roles-permissions', ['as' => 'rolesPermissions', 'uses' => 'AuthController@rolesPermissions']);
    });

    Route::group(['prefix' => 'member', 'middleware' => 'auth', 'as' => 'member.'], function () {
        Route::group(['prefix' => 'member', 'as' => 'update.'], function () {
            patch('nickname', ['as' => 'nickname', 'uses' => 'MemberController@updateNickname']);
        });
    });

    Route::group(['prefix' => 'courses', 'namespace' => 'Course', 'as' => 'courses.'], function () {
        get('departments', ['as' => 'departments', 'uses' => 'CoursesController@departments']);
        get('dimensions', ['as' => 'dimensions', 'uses' => 'CoursesController@dimensions']);
        get('semesters', ['as' => 'semesters', 'uses' => 'CoursesController@semesters']);
        get('search', ['as' => 'search', 'uses' => 'CoursesController@search']);
        get('exams/newest-hottest', ['as' => 'exams.newestHottest', 'uses' => 'ExamsController@newestHottest']);
        get('exams/{exam_id}', ['middleware' => 'auth', 'as' => 'exams.download', 'uses' => 'ExamsController@download']);

        Route::group(['prefix' => '{courseId}'], function () {
            get('/', ['as' => 'show', 'uses' => 'CoursesController@show']);
            get('exams', ['as' => 'exams.index', 'uses' => 'ExamsController@index']);
            post('exams', ['middleware' => 'auth', 'as' => 'exams.store', 'uses' => 'ExamsController@store']);
            get('comments', ['as' => 'comments.list', 'uses' => 'CommentsController@index']);
            post('comments/{commentId?}', ['middleware' => 'auth', 'as' => 'comments.store', 'uses' => 'CommentsController@store']);
        });

        Route::group(['prefix' => 'comments', 'as' => 'comments.'], function () {
            get('newest', ['as' => 'newest', 'uses' => 'CommentsController@newest']);
            get('votes', ['as' => 'getVotes', 'uses' => 'CommentsController@getVotes']);
            post('{commentId}/vote', ['middleware' => 'auth', 'as' => 'vote', 'uses' => 'CommentsController@vote']);
            delete('{commentId}/vote', ['middleware' => 'auth', 'as' => 'voteWithdraw', 'uses' => 'CommentsController@voteWithdraw']);
        });
    });

    Route::group(['prefix' => 'dormitories', 'as' => 'dormitories.'], function () {
        Route::group(['prefix' => 'roommates', 'as' => 'roommates.'], function () {
            get('search', ['as' => 'search', 'uses' => 'RoommatesController@search']);
            get('status', ['as' => 'status', 'uses' => 'RoommatesController@status']);
            post('/', ['as' => 'store', 'uses' => 'RoommatesController@store']);
        });
    });
});

Route::group(['prefix' => 'assets'], function () {
    Route::group(['prefix' => 'css'], function () {
        get('{sub1}.css', ['uses' => 'AssetsController@styles']);
    });

    Route::group(['prefix' => 'js'], function () {
        get('{sub1}.js', ['uses' => 'AssetsController@scripts']);
        get('{sub1}/{sub2}.js', ['uses' => 'AssetsController@scripts']);
        get('{sub1}/{sub2}/{sub3}.js', ['uses' => 'AssetsController@scripts']);
    });

    Route::group(['prefix' => 'templates'], function () {
        get('{sub1}.html', ['uses' => 'AssetsController@templates']);
        get('{sub1}/{sub2}.html', ['uses' => 'AssetsController@templates']);
        get('{sub1}/{sub2}/{sub3}.html', ['uses' => 'AssetsController@templates']);
    });
});

Route::group(['prefix' => 'errors', 'as' => 'errors.'], function () {
    get('browser-not-support', ['as' => 'browserNotSupport', 'uses' => 'ErrorsController@browserNotSupport']);
    get('noscript', ['as' => 'noscript', 'uses' => 'ErrorsController@noscript']);
});