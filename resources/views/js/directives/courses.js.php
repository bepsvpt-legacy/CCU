'use strict';

(function () {
    angular.module('ccu')
        .directive('coursesCommentsBody', function() {
            return {
                restrict: 'E',
                scope: {
                    comment: '=',
                    vote: '=',
                    isSubComment: '@',
                    disableAction: '@'
                },
                templateUrl: '{{ routeAssets("templates.directives.courses.commentsBody") }}?' + VERSION
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
                templateUrl: '{{ routeAssets("templates.directives.courses.info") }}?' + VERSION
            }
        })
        .directive('coursesExams', function() {
            return {
                restrict: 'E',
                scope: {
                    exams: '=',
                    heading: '@'
                },
                templateUrl: '{{ routeAssets("templates.directives.courses.exams") }}?' + VERSION
            }
        });
})();