'use strict';

(function () {
    var needLoaded = ['ui.router', 'angular-loading-bar', 'angulartics', 'ngFileUpload'];

    if ('undefined' !== typeof GA_IS_AVAILABLE) {
        needLoaded.push('angulartics.google.analytics');
    }

    var app = angular.module('ccu', needLoaded);

    app.config(['$httpProvider', function($httpProvider) {
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    }]);

    app.run(['$http', '$rootScope', function ($http, $rootScope) {
        $http.get('{{ route("api.auth.rolesPermissions") }}')
            .then(function (response) {
                $rootScope.user = {
                    signIn: response.data.signIn,
                    roles: response.data.roles,
                    permissions: response.data.permissions,
                    hasRole: function (role) {
                        var type = typeof role;

                        if (('object' !== type) && ('string' !== type)) {
                            return false;
                        }
                        else if ('string' === type) {
                            role = [role];
                        }

                        for (var i in role) {
                            if (role.hasOwnProperty(i) && (-1 !== this.roles.indexOf(role[i]))) {
                                return true;
                            }
                        }

                        return false;
                    },
                    can: function (action) {return -1 !== this.permissions.indexOf(action)}
                };
            });
    }]);

    app.filter('bytes', function() {
        return function(bytes, precision) {
            if (isNaN(parseFloat(bytes)) || !isFinite(bytes)) return '-';
            if (typeof precision === 'undefined') precision = 1;
            var units = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB'],
                number = Math.floor(Math.log(bytes) / Math.log(1024));
            return (bytes / Math.pow(1024, Math.floor(number))).toFixed(precision) +  ' ' + units[number];
        }
    });
})();