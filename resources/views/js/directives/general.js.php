'use strict';

(function () {
    angular.module('ccu')
        .directive('actionSeparation', function () {
            return {
                restrict: 'E',
                template: '<span> · </span>'
            };
        })
        .directive('profilePicture', function () {
            return {
                restrict: 'E',
                scope: {
                    nickname: '@',
                    size: '@'
                },
                template: '<img ng-src="/images/profile-picture/@{{ nickname }}" alt="profile-picture" class="img-circle @{{ size }}">'
            };
        })
        .directive('aPreventDefault', function () {
            return {
                restrict: 'A',
                link: function (scope, element, attrs) {
                    element.click(function (e) {
                        e.preventDefault();
                    });
                }
            };
        });
})();