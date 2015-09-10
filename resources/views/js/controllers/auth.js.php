'use strict';

(function () {
    var _errorsModal, redirectToHomePage = function () {
            window.location.href = '{{ route("home") }}';
        }, handleErrorResponse = function (response) {
            _errorsModal.make(response);
        };

    angular.module('ccu')
        .run(['errorsModal', function(errorsModal) {
            _errorsModal = errorsModal;
        }])
        .controller('SignInController', ['$scope', '$http', function ($scope, $http) {
            $scope.signIn = {rememberMe: true};

            $scope.signInFormSubmit = function () {
                $http.post('{{ route("api.auth.signIn") }}', {
                    email: $scope.signIn.email,
                    password: $scope.signIn.password,
                    rememberMe: $scope.signIn.rememberMe
                })
                    .then(redirectToHomePage, handleErrorResponse);
            };
        }])
        .controller('SignOutController', ['$http', function ($http) {
            $http.get('{{ route("api.auth.signOut") }}')
                .then(redirectToHomePage, redirectToHomePage);
        }])
        .controller('RegisterController', ['$scope', '$http', function ($scope, $http) {
            $scope.register = {};

            $scope.registerFormSubmit = function () {
                $http.post('{{ route("api.auth.register") }}', {
                    email: $scope.register.email,
                    password: $scope.register.password,
                    password_confirmation: $scope.register.password_confirmation,
                    'g-recaptcha-response': angular.element('textarea[name="g-recaptcha-response"]').val() || ''
                })
                    .then(redirectToHomePage, handleErrorResponse);
            };
        }]);
})();