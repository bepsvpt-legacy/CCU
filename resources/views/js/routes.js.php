'use strict';

(function () {
    angular.module('ccu').config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
        $stateProvider
            .state('home', {
                url: '/',
                templateUrl: '{{ routeAssets("templates.home", true) }}'
            })
            .state('auth-register', {
                url: '/auth/register',
                templateUrl: '{{ routeAssets("templates.auth.register", true) }}',
                controller: 'RegisterController'
            })
            .state('auth-signIn', {
                url: '/auth/sign-in',
                templateUrl: '{{ routeAssets("templates.auth.sign-in", true) }}',
                controller: 'SignInController'
            })
            .state('auth-signOut', {
                url: '/auth/sign-out',
                template: '',
                controller: 'SignOutController'
            })
            .state('courses', {
                url: '/courses',
                templateUrl: '{{ routeAssets("templates.courses.index", true) }}',
                controller: 'CoursesController'
            })
            .state('courses-show', {
                url: '/courses/:courseId',
                templateUrl: '{{ routeAssets("templates.courses.show", true) }}',
                controller: 'CoursesShowController',
                onEnter: ['$state', '$stateParams', function ($state, $stateParams) {
                    if (0 === $stateParams.courseId.length) {
                        $state.go('courses');
                    }
                }]
            })
            .state('courses-comments-list', {
                url: '/courses/:courseId/comments',
                templateUrl: '{{ routeAssets("templates.courses.comments.list", true) }}'
            })
            .state('dormitories-roommates', {
                url: '/dormitories/roommates',
                templateUrl: '{{ routeAssets("templates.dormitories.roommates", true) }}',
                controller: 'RoommatesController'
            })
            .state('member', {
                url: '/member',
                templateUrl: '{{ routeAssets("templates.member.index", true) }}',
                controller: 'MemberController',
                onEnter: ['$rootScope', '$state', function ($rootScope, $state) {
                    if ((undefined === $rootScope.user) || ( ! $rootScope.user.signIn)) {
                        $state.go('home');
                    }
                }]
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