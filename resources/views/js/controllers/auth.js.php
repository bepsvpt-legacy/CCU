'use strict';

(function ($) {
    angular.module('ccu')
        .controller('SignInController', ['$scope', '$http', '$window', 'errorsModal', function ($scope, $http, $window, errorsModal) {
            $scope.signIn = {rememberMe: true};

            $scope.submit = function () {
                $http.post('{{ route("api.auth.signIn") }}', {
                    email: $scope.signIn.email,
                    password: $scope.signIn.password,
                    rememberMe: $scope.signIn.rememberMe
                })
                    .then(function (response) {
                        $window.location.href = '/';
                    }, function (response) {
                        errorsModal.make(response);
                    });
            };
        }])
        .controller('SignOutController', ['$http', '$window', function ($http, $window) {
            $http.get('{{ route("api.auth.signOut") }}')
                .then(function (response) {
                    $window.location.href = '/';
                }, function (response) {
                    $window.location.href = '/';
                });
        }])
        .controller('RegisterController', ['$scope', '$http', '$window', 'errorsModal', function ($scope, $http, $window, errorsModal) {
            $scope.register = {};

            $scope.submit = function () {
                $http.post('{{ route("api.auth.register") }}', {
                    email: $scope.register.email,
                    password: $scope.register.password,
                    password_confirmation: $scope.register.password_confirmation,
                    'g-recaptcha-response': $('#g-recaptcha-response').val()
                })
                    .then(function (response) {
                        $window.location.href = '/';
                    }, function (response) {
                        errorsModal.make(response);
                    });
            };
        }]);
})(jQuery);