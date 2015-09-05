'use strict';

(function () {
    angular.module('ccu').config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
        $stateProvider
            .state('home', {
                url: '/',
                templateUrl: '{{ routeAssets("templates.home") }}'
            })
            .state('auth-register', {
                url: '/auth/register',
                templateUrl: '{{ routeAssets("templates.auth.register") }}',
                controller: 'RegisterController'
            })
            .state('auth-signIn', {
                url: '/auth/sign-in',
                templateUrl: '{{ routeAssets("templates.auth.sign-in") }}',
                controller: 'SignInController'
            })
            .state('auth-signOut', {
                url: '/auth/sign-out',
                template: '',
                controller: 'SignOutController'
            })
            .state('courses-list', {
                url: '/courses',
                templateUrl: '{{ routeAssets("templates.courses.list") }}',
                controller: 'CoursesListController'
            })
            .state('courses-show', {
                url: '/courses/:courseId',
                templateUrl: '{{ routeAssets("templates.courses.show") }}',
                controller: 'CoursesShowController'
            })
            .state('courses-comments-list', {
                url: '/courses/:courseId/comments',
                templateUrl: '{{ routeAssets("templates.courses.comments.list") }}'
            })
            .state('dormitories-roommates', {
                url: '/dormitories/roommates',
                templateUrl: '{{ routeAssets("templates.dormitories.roommates") }}',
                controller: 'RoommatesController'
            })
            .state('about', {
                url: '/about',
                templateUrl: '/api/information/about'
            })
            .state('policy', {
                url: '/policy',
                templateUrl: '/api/information/policy'
            });

        $urlRouterProvider.otherwise("/");
    }]);
})();