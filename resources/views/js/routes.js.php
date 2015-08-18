(function () {
    'use strict';

    angular.module('ccu').config(function ($routeProvider) {
        $routeProvider.when('/', {
            templateUrl: '{{ routeAssets("templates.home") }}'
        }).when('/auth/register', {
            templateUrl: '{{ routeAssets("templates.auth.register") }}',
            controller: 'RegisterController',
            controllerAs: 'RegisterCtrl'
        }).when('/auth/sign-in', {
            templateUrl: '{{ routeAssets("templates.auth.sign-in") }}',
            controller: 'SignInController',
            controllerAs: 'SignInCtrl'
        }).when('/auth/sign-out', {
            template: '',
            controller: 'SignOutController'
        }).when('/courses', {
            templateUrl: '{{ routeAssets("templates.courses.list") }}',
            controller: 'CoursesListController',
            controllerAs: 'CoursesListCtrl'
        }).when('/courses/:courseId', {
            templateUrl: '{{ routeAssets("templates.courses.show") }}',
            controller: 'CoursesShowController',
            controllerAs: 'CoursesShowCtrl'
        }).when('/courses/:courseId/comments', {
            templateUrl: '{{ routeAssets("templates.courses.comments.list") }}'
        }).when('/dormitories/roommates', {
            templateUrl: '{{ routeAssets("templates.dormitories.roommates") }}',
            controller: 'RoommatesController',
            controllerAs: 'RoommatesCtrl'
        }).when('/about', {
            templateUrl: '/api/information/about'
        }).when('/policy', {
            templateUrl: '/api/information/policy'
        }).otherwise({
            redirectTo: '/'
        });
    });
})();