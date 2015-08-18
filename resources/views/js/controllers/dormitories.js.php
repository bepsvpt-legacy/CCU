(function ($) {
    'use strict';

    angular.module('ccu')
        .controller('RoommatesController', ['$scope', '$http', 'errorsModal', function ($scope, $http, errorsModal) {

            $http.get('{{ route("api.dormitories.roommates.status") }}', {cache: true})
                .then(function (response) {
                    $scope.status = response.data;
                }, function (response) {
                    errorsModal.make(response);
                });

            $scope.searchFormSubmit = function () {
                $http.get('{{ route("api.dormitories.roommates.search") }}', {
                    params: {
                        name: $scope.search.name,
                        room: $scope.search.room
                    }
                })
                    .then(function (response) {
                        $scope.searchResults = response.data;
                    }, function (response) {
                        errorsModal.make(response);
                    });
            };

            $scope.createFormSubmit = function () {
                $http.post('{{ route("api.dormitories.roommates.store") }}', {
                    room: $scope.create.room,
                    bed: $scope.create.bed,
                    name: $scope.create.name,
                    fb: $scope.create.fb,
                    'g-recaptcha-response': $('#g-recaptcha-response').val()
                })
                    .then(function (response) {
                        $scope.create = {};
                        alert('新增成功');
                    }, function (response) {
                        errorsModal.make(response);
                    });
            };
        }]);
})(jQuery);