'use strict';

(function () {
    var _errorsModal, handleErrorResponse = function (response) {
        _errorsModal.make(response);
    };

    angular.module('ccu')
        .run(['errorsModal', function(errorsModal) {
            _errorsModal = errorsModal;
        }])
        .controller('RoommatesController', ['$http', '$scope', 'toaster', function ($http, $scope, toaster) {
            var ls = JSON.parse(localStorage.getItem('dormitories'));

            $scope.showCreateForm = ((null !== ls) && (ls.hasOwnProperty('roommates')) && (ls.roommates.hasOwnProperty('showCreateForm'))) ? ls.roommates.showCreateForm : true;
            $scope.search = {};
            $scope.create = {};

            $http.get('{{ route("api.dormitories.roommates.status") }}', {cache: true})
                .then(function (response) {
                    $scope.status = response.data;
                }, handleErrorResponse);

            $scope.searchFormSubmit = function () {
                $http.get('{{ route("api.dormitories.roommates.search") }}', {
                    params: {
                        name: $scope.search.name,
                        room: $scope.search.room
                    }
                })
                    .then(function (response) {
                        $scope.searchResults = response.data;
                    }, handleErrorResponse);
            };

            $scope.createFormSubmit = function () {
                $http.post('{{ route("api.dormitories.roommates.store") }}', {
                    room: $scope.create.room,
                    bed: $scope.create.bed,
                    name: $scope.create.name,
                    fb: $scope.create.fb,
                    'g-recaptcha-response': angular.element('textarea[name="g-recaptcha-response"]').val() || ''
                })
                    .then(function () {
                        $scope.createFormHide();
                        toaster.pop({type: 'success', title: '新增成功', timeout: 4500, showCloseButton: true});
                    }, handleErrorResponse);
            };

            $scope.createFormShow = function () {
                $scope.createFormHide(true);
            };

            $scope.createFormHide = function (reverse) {
                localStorage.setItem('dormitories', JSON.stringify({roommates: {showCreateForm: $scope.showCreateForm = !!reverse}}));
            };
        }]);
})();