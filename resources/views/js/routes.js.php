'use strict';

(function () {
    angular.module('ccu').config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
        $stateProvider
            .state('home', {
                url: '/',
                templateUrl: '{{ routeAssets("templates.home") }}?' + VERSION
            })
            .state('auth-register', {
                url: '/auth/register',
                templateUrl: '{{ routeAssets("templates.auth.register") }}?' + VERSION,
                controller: 'RegisterController'
            })
            .state('auth-signIn', {
                url: '/auth/sign-in',
                templateUrl: '{{ routeAssets("templates.auth.sign-in") }}?' + VERSION,
                controller: 'SignInController'
            })
            .state('auth-signOut', {
                url: '/auth/sign-out',
                template: '',
                controller: 'SignOutController'
            })
            .state('courses', {
                url: '/courses',
                templateUrl: '{{ routeAssets("templates.courses.index") }}?' + VERSION,
                controller: 'CoursesController'
            })
            .state('courses-show', {
                url: '/courses/:courseId',
                templateUrl: '{{ routeAssets("templates.courses.show") }}?' + VERSION,
                controller: 'CoursesShowController',
                onEnter: function ($state, $stateParams) {
                    if (0 === $stateParams.courseId.length) {
                        $state.go('courses');
                    }
                }
            })
            .state('courses-comments-list', {
                url: '/courses/:courseId/comments',
                templateUrl: '{{ routeAssets("templates.courses.comments.list") }}?' + VERSION
            })
            .state('dormitories-roommates', {
                url: '/dormitories/roommates',
                templateUrl: '{{ routeAssets("templates.dormitories.roommates") }}?' + VERSION,
                controller: 'RoommatesController'
            })
            .state('member', {
                url: '/member',
                templateUrl: '{{ routeAssets("templates.member.index") }}?' + VERSION,
                controller: 'MemberController',
                onEnter: function ($rootScope, $state) {
                    if ((undefined === $rootScope.user) || ( ! $rootScope.user.signIn)) {
                        $state.go('home');
                    }
                }
            })
            .state('about', {
                url: '/about',
                templateUrl: '/api/information/about?' + VERSION
            })
            .state('policy', {
                url: '/policy',
                templateUrl: '/api/information/policy?' + VERSION
            });

        $urlRouterProvider.otherwise("/");
    }]);
})();