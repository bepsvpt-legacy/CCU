'use strict';

(function () {
    angular.module('ccu')
        .directive('actionSeparation', function () {
            return {
                restrict: 'E',
                template: '<span> · </span>'
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