'use strict';

(function () {
    angular.module('ccu').config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
        $stateProvider
            .state('home', {
                url: '/',
                templateUrl: '{{ routeAssets("templates.home") }}?v=' + VERSION
            })
            .state('auth-register', {
                url: '/auth/register',
                templateUrl: '{{ routeAssets("templates.auth.register") }}?v=' + VERSION,
                controller: 'RegisterController'
            })
            .state('auth-signIn', {
                url: '/auth/sign-in',
                templateUrl: '{{ routeAssets("templates.auth.sign-in") }}?v=' + VERSION,
                controller: 'SignInController'
            })
            .state('auth-signOut', {
                url: '/auth/sign-out',
                template: '',
                controller: 'SignOutController'
            })
            .state('courses', {
                url: '/courses',
                templateUrl: '{{ routeAssets("templates.courses.index") }}?v=' + VERSION,
                controller: 'CoursesController'
            })
            .state('courses-show', {
                url: '/courses/:courseId',
                templateUrl: '{{ routeAssets("templates.courses.show") }}?v=' + VERSION,
                controller: 'CoursesShowController',
                onEnter: function ($state, $stateParams) {
                    if (0 === $stateParams.courseId.length) {
                        $state.go('courses');
                    }
                }
            })
            .state('courses-comments-list', {
                url: '/courses/:courseId/comments',
                templateUrl: '{{ routeAssets("templates.courses.comments.list") }}?v=' + VERSION
            })
            .state('dormitories-roommates', {
                url: '/dormitories/roommates',
                templateUrl: '{{ routeAssets("templates.dormitories.roommates") }}?v=' + VERSION,
                controller: 'RoommatesController'
            })
            .state('member', {
                url: '/member',
                templateUrl: '{{ routeAssets("templates.member.index") }}?v=' + VERSION,
                controller: 'MemberController',
                onEnter: function ($rootScope, $state) {
                    if ((undefined === $rootScope.user) || ( ! $rootScope.user.signIn)) {
                        $state.go('home');
                    }
                }
            })
            .state('about', {
                url: '/about',
                templateUrl: '/api/information/about?v=' + VERSION
            })
            .state('policy', {
                url: '/policy',
                templateUrl: '/api/information/policy?v=' + VERSION
            });

        $urlRouterProvider.otherwise("/");
    }]);
})();