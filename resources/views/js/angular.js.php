'use strict';

(function () {
    var app = angular.module('ccu', ['ngRoute', 'angular-loading-bar', 'angulartics', 'angulartics.google.analytics']);

    app.config(['$httpProvider', function($httpProvider) {
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    }]);
})();