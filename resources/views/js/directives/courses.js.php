(function () {
    'use strict';

    angular.module('ccu')
        .directive('coursesCommentsBody', function() {
            return {
                restrict: 'E',
                scope: {
                    comment: '=',
                    vote: '='
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
        });
})();