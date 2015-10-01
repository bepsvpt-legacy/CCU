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

$router->get('/', ['as' => 'home', 'uses' => 'HomeController@home']);

$router->group(['prefix' => 'api', 'namespace' => 'Api', 'as' => 'api.'], function ($router) {
    $router->get('information/{name}', ['as' => 'information', 'uses' => 'WebsiteController@information']);

    $router->group(['prefix' => 'auth', 'as' => 'auth.'], function ($router) {
        $router->post('sign-in', ['as' => 'signIn', 'uses' => 'AuthController@signIn']);
        $router->get('sign-out', ['as' => 'signOut', 'uses' => 'AuthController@signOut']);
        $router->post('register', ['as' => 'register', 'uses' => 'AuthController@register']);
        $router->get('register/verify-email/{token}', ['as' => 'verifyEmail', 'uses' => 'AuthController@verifyEmail']);
        $router->get('roles-permissions', ['as' => 'rolesPermissions', 'uses' => 'AuthController@rolesPermissions']);
        $router->get('facebook', ['as' => 'facebook.signIn', 'uses' => 'OAuthController@facebook']);
        $router->get('facebook/callback', ['as' => 'facebook.callback', 'uses' => 'OAuthController@facebookCallback']);
    });

    $router->group(['prefix' => 'member', 'middleware' => 'auth', 'as' => 'member.'], function ($router) {
        $router->group(['prefix' => 'member', 'as' => 'update.'], function ($router) {
            $router->patch('nickname', ['as' => 'nickname', 'uses' => 'MemberController@updateNickname']);
            $router->post('profile-picture', ['as' => 'profilePicture', 'uses' => 'MemberController@updateProfilePicture']);
        });
    });

    $router->group(['prefix' => 'courses', 'namespace' => 'Course', 'as' => 'courses.'], function ($router) {
        $router->get('departments', ['as' => 'departments', 'uses' => 'CoursesController@departments']);
        $router->get('dimensions', ['as' => 'dimensions', 'uses' => 'CoursesController@dimensions']);
        $router->get('semesters', ['as' => 'semesters', 'uses' => 'CoursesController@semesters']);
        $router->get('search', ['as' => 'search', 'uses' => 'CoursesController@search']);
        $router->get('exams/newest-hottest', ['as' => 'exams.newestHottest', 'uses' => 'ExamsController@newestHottest']);
        $router->get('exams/{exam_id}', ['middleware' => 'auth', 'as' => 'exams.download', 'uses' => 'ExamsController@download']);

        $router->group(['prefix' => '{courseId}'], function ($router) {
            $router->get('/', ['as' => 'show', 'uses' => 'CoursesController@show']);
            $router->get('exams', ['as' => 'exams.index', 'uses' => 'ExamsController@index']);
            $router->post('exams', ['middleware' => 'auth', 'as' => 'exams.store', 'uses' => 'ExamsController@store']);
            $router->get('comments', ['as' => 'comments.list', 'uses' => 'CommentsController@index']);
            $router->post('comments/{commentId?}', ['middleware' => 'auth', 'as' => 'comments.store', 'uses' => 'CommentsController@store']);
        });

        $router->group(['prefix' => 'comments', 'as' => 'comments.'], function ($router) {
            $router->get('newest', ['as' => 'newest', 'uses' => 'CommentsController@newest']);
            $router->get('votes', ['as' => 'getVotes', 'uses' => 'CommentsController@getVotes']);
            $router->post('{commentId}/vote', ['middleware' => 'auth', 'as' => 'vote', 'uses' => 'CommentsController@vote']);
            $router->delete('{commentId}/vote', ['middleware' => 'auth', 'as' => 'voteWithdraw', 'uses' => 'CommentsController@voteWithdraw']);
        });
    });

    $router->group(['prefix' => 'dormitories', 'as' => 'dormitories.'], function ($router) {
        $router->group(['prefix' => 'roommates', 'as' => 'roommates.'], function ($router) {
            $router->get('search', ['as' => 'search', 'uses' => 'RoommatesController@search']);
            $router->get('status', ['as' => 'status', 'uses' => 'RoommatesController@status']);
            $router->post('/', ['as' => 'store', 'uses' => 'RoommatesController@store']);
        });
    });

    $router->post('check', ['as' => 'prtSc', 'uses' => 'WebsiteController@prtSc']);
});

$router->group(['prefix' => 'images', 'as' => 'images.'], function ($router) {
    $router->get('profile-picture/{nickname?}', ['as' => 'profilePicture', 'uses' => 'ImagesController@profilePicture']);
    $router->get('{hash}/{time}', ['as' => 'show', 'uses' => 'ImagesController@show']);
    $router->get('{hash}/{time}/s', ['as' => 'show.small', 'uses' => 'ImagesController@show_s']);
});

$router->group(['prefix' => 'assets'], function ($router) {
    $router->group(['prefix' => 'css'], function ($router) {
        $router->get('{sub1}.css', ['uses' => 'AssetsController@styles']);
    });

    $router->group(['prefix' => 'js'], function ($router) {
        $router->get('{sub1}.js', ['uses' => 'AssetsController@scripts']);
        $router->get('{sub1}/{sub2}.js', ['uses' => 'AssetsController@scripts']);
        $router->get('{sub1}/{sub2}/{sub3}.js', ['uses' => 'AssetsController@scripts']);
    });

    $router->group(['prefix' => 'templates'], function ($router) {
        $router->get('{sub1}.html', ['uses' => 'AssetsController@templates']);
        $router->get('{sub1}/{sub2}.html', ['uses' => 'AssetsController@templates']);
        $router->get('{sub1}/{sub2}/{sub3}.html', ['uses' => 'AssetsController@templates']);
    });
});

$router->group(['prefix' => 'errors', 'as' => 'errors.'], function ($router) {
    $router->get('browser-not-support', ['as' => 'browserNotSupport', 'uses' => 'ErrorsController@browserNotSupport']);
    $router->get('noscript', ['as' => 'noscript', 'uses' => 'ErrorsController@noscript']);
});