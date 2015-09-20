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
                templateUrl: '{{ routeAssets("templates.directives.courses.commentsBody") }}?v=' + VERSION,
                link: function(scope, element, attrs) {
                    if (angular.isUndefined(scope.disableAction)) {
                        scope.disableAction = false;
                    }

                    if (angular.isUndefined(scope.isSubComment)) {
                        scope.isSubComment = false;
                    }
                }
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
                templateUrl: '{{ routeAssets("templates.directives.courses.info") }}?v=' + VERSION
            }
        })
        .directive('coursesExams', function() {
            return {
                restrict: 'E',
                scope: {
                    exams: '=',
                    heading: '@'
                },
                templateUrl: '{{ routeAssets("templates.directives.courses.exams") }}?v=' + VERSION
            }
        });
})();