'use strict';

(function () {
    var _errorsModal, handleErrorResponse = function (response) {
        _errorsModal.make(response);
    };

    angular.module('ccu')
        .run(['errorsModal', function(errorsModal) {
            _errorsModal = errorsModal;
        }])
        .controller('MemberController', ['$http', '$rootScope', '$scope', '$window', 'Upload', function ($http, $rootScope, $scope, $window, Upload) {
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

            $scope.changeProfilePicture = function (file) {
                if (file && ! file.$error) {
                    file.upload = Upload.upload({
                        method: 'POST',
                        url: '{{ route("api.member.update.profilePicture") }}',
                        file: file
                    }).then(function (response) {
                        $window.location.reload();
                        setTimeout(function() {alert('上傳成功');}, 1);
                    }, handleErrorResponse);
                }
            };
        }]);
})();