'use strict';

(function () {
    angular.module('ccu')
        .directive('coursesCommentsBody', function() {
            return {
                restrict: 'E',
                scope: {
                    comment: '=',
                    vote: '=',
                    action: '@'
                },
                templateUrl: '{{ routeAssets("templates.directives.courses.commentsBody") }}'
            }
        })
        .directive('coursesInfo', function() {
            return {
                restrict: 'E',
                scope: {
                    icon: '@',
                    type: '@',
                    value: '@'
                },
                templateUrl: '{{ routeAssets("templates.directives.courses.info") }}'
            }
        })
        .directive('coursesExams', function() {
            return {
                restrict: 'E',
                scope: {
                    exams: '=',
                    heading: '@'
                },
                templateUrl: '{{ routeAssets("templates.directives.courses.exams") }}'
            }
        });
})();