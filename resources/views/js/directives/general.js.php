(function () {
    'use strict';

    angular.module('ccu')
        .directive('actionSeparation', function () {
            return {
                restrict: 'E',
                template: '<span> · </span>'
            };
        });
})();