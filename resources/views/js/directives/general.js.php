'use strict';

(function () {
    angular.module('ccu')
        .directive('actionSeparation', function () {
            return {
                restrict: 'E',
                template: '<span> · </span>'
            };
        });
})();