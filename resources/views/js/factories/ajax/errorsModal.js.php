(function ($) {
    'use strict';

    angular.module('ccu')
        .factory('errorsModal', ['$rootScope', function ($rootScope) {
            return {
                make: function (response) {
                    switch (response.status)
                    {
                        case 301:
                        case 302:
                            return;
                    }

                    this.init();

                    (422 === response.status) ? this.unprocessableEntity(response.data) : this.otherwise(response.status);

                    this.show();
                },
                init: function () {
                    $rootScope.errors = [];
                },
                unprocessableEntity: function (messages) {
                    angular.forEach(messages, function (message) {
                        angular.forEach(message, function (value) {
                            $rootScope.errors.push(value);
                        });
                    });
                },
                otherwise: function (httpCode) {
                    switch (httpCode) {
                        case 401:
                        case 403:
                            $rootScope.errors.push('Unauthorized request.');
                            break;
                        case 400:
                        case 404:
                        case 405:
                            $rootScope.errors.push('Sorry, the page you are looking for could not be found.');
                            break;
                        default :
                            $rootScope.errors.push('Sorry, there is something wrong on server.');
                            break;
                    }
                },
                show: function () {
                    $('#ajaxErrorsModal').modal('show');
                }
            }
        }]);
})(jQuery);