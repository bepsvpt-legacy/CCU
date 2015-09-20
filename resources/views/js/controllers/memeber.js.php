'use strict';

(function () {
    var _errorsModal, handleErrorResponse = function (response) {
        _errorsModal.make(response);
    };

    angular.module('ccu')
        .run(['errorsModal', function(errorsModal) {
            _errorsModal = errorsModal;
        }])
        .controller('MemberController', ['$http', '$rootScope', '$scope', '$window', 'toaster', 'Upload', function ($http, $rootScope, $scope, $window, toaster, Upload) {
            $scope.changeNickname = {show: false};

            $scope.changeNicknameFormSubmit = function () {
                $http.patch('{{ route("api.member.update.nickname") }}', {
                    nickname: $scope.changeNickname.nickname
                })
                    .then(function (response) {
                        $rootScope.user.nickname = $scope.changeNickname.nickname;
                        $scope.changeNickname.show = false;
                        toaster.pop({type: 'success', title: '更新成功', timeout: 4500, showCloseButton: true});
                    }, handleErrorResponse);
            };

            $scope.changeProfilePicture = function (file) {
                if (file && ! file.$error) {
                    file.upload = Upload.upload({
                        method: 'POST',
                        url: '{{ route("api.member.update.profilePicture") }}',
                        file: file
                    }).then(function (response) {
                        toaster.pop({
                            type: 'success',
                            title: '上傳成功',
                            body: '大頭貼更新可能需花費數分鐘',
                            timeout: 4500,
                            showCloseButton: true
                        });
                    }, handleErrorResponse);
                }
            };
        }]);
})();