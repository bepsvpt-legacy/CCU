'use strict';

(function () {
    var _errorsModal, handleErrorResponse = function (response) {
        _errorsModal.make(response);
    };

    angular.module('ccu')
        .run(['errorsModal', function(errorsModal) {
            _errorsModal = errorsModal;
        }])
        .controller('MemberController', ['$http', '$rootScope', '$scope', function ($http, $rootScope, $scope) {
            $scope.changeNickname = {};

            $scope.changeNicknameFormSubmit = function () {
                $http.patch('{{ route("api.member.update.nickname") }}', {
                    nickname: $scope.changeNickname.nickname
                })
                    .then(function (response) {
                        $rootScope.user.nickname = $scope.changeNickname.nickname;
                        $scope.showChangeNicknameForm = false;
                    }, handleErrorResponse);
            };
        }]);
})();