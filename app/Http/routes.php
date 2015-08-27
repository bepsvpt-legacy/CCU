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

get('api/information/{name}', ['as' => 'api.information', 'uses' => 'HomeController@information']);

Route::group(['prefix' => 'api', 'namespace' => 'Api', 'as' => 'api.'], function ()
{
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function ()
    {
        post('sign-in', ['as' => 'signIn', 'uses' => 'AuthController@signIn']);
        get('sign-out', ['as' => 'signOut', 'uses' => 'AuthController@signOut']);
        post('register', ['as' => 'register', 'uses' => 'AuthController@register']);
    });

    Route::group(['prefix' => 'courses', 'as' => 'courses.'], function ()
    {
        get('departments', ['as' => 'departments', 'uses' => 'CoursesController@departments']);
        get('dimensions', ['as' => 'dimensions', 'uses' => 'CoursesController@dimensions']);
        get('search', ['as' => 'search', 'uses' => 'CoursesController@search']);
        get('votes', ['middleware' => 'auth', 'as' => 'comments.getVotes', 'uses' => 'CoursesCommentsController@getVotes']);
        get('{courseId?}', ['as' => 'show', 'uses' => 'CoursesController@show']);
        get('{courseId}/comments', ['as' => 'comments.list', 'uses' => 'CoursesCommentsController@index']);

        Route::group(['middleware' => 'auth'], function ()
        {
            post('{courseId}/comments/{commentId?}', ['as' => 'comments.store', 'uses' => 'CoursesCommentsController@store']);
            post('{commentId}/vote', ['as' => 'comments.vote', 'uses' => 'CoursesCommentsController@vote']);
            delete('{commentId}/vote', ['as' => 'comments.voteWithdraw', 'uses' => 'CoursesCommentsController@voteWithdraw']);
        });
    });

    Route::group(['prefix' => 'dormitories', 'as' => 'dormitories.'], function ()
    {
        Route::group(['prefix' => 'roommates', 'as' => 'roommates.'], function ()
        {
            get('search', ['as' => 'search', 'uses' => 'RoommatesController@search']);
            get('status', ['as' => 'status', 'uses' => 'RoommatesController@status']);
            post('/', ['as' => 'store', 'uses' => 'RoommatesController@store']);
        });
    });
});

Route::group(['prefix' => 'assets'], function ()
{
    Route::group(['prefix' => 'css'], function ()
    {
        get('{sub1}.css', ['uses' => 'AssetsController@styles']);
    });

    Route::group(['prefix' => 'js'], function ()
    {
        get('{sub1}.js', ['uses' => 'AssetsController@scripts']);
        get('{sub1}/{sub2}.js', ['uses' => 'AssetsController@scripts']);
        get('{sub1}/{sub2}/{sub3}.js', ['uses' => 'AssetsController@scripts']);
    });

    Route::group(['prefix' => 'templates'], function ()
    {
        get('{sub1}.html', ['uses' => 'AssetsController@templates']);
        get('{sub1}/{sub2}.html', ['uses' => 'AssetsController@templates']);
        get('{sub1}/{sub2}/{sub3}.html', ['uses' => 'AssetsController@templates']);
    });
});

Route::group(['prefix' => 'errors', 'as' => 'errors.'], function ()
{
    get('browser-not-support', ['as' => 'browserNotSupport', 'uses' => 'ErrorsController@browserNotSupport']);
});