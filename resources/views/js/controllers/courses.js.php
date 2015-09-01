'use strict';

(function () {
    angular.module('ccu')
        .controller('CoursesListController', ['$scope', '$http', 'errorsModal', function ($scope, $http, errorsModal) {
            $scope.options = {};
            $scope.search = {keyword: ''};

            $http.get('{{ route("api.courses.departments") }}', {cache: true})
                .then(function (response) {
                    $scope.options.departments = response.data;
                }, function (response) {
                    errorsModal.make(response);
                });

            $http.get('{{ route("api.courses.dimensions") }}', {cache: true})
                .then(function (response) {
                    $scope.options.dimensions = response.data;
                }, function (response) {
                    errorsModal.make(response);
                });

            $scope.searching = function () {
                $http.get('{{ route("api.courses.search") }}', {
                    params: {
                        department: ($scope.search.department) ? $scope.search.department.id : 0,
                        dimension: ($scope.search.dimension) ? $scope.search.dimension.id : 0,
                        keyword: $scope.search.keyword
                    },
                    cache: true
                })
                    .then(function (response) {
                        $scope.courses = response.data;
                    }, function (response) {
                        errorsModal.make(response);
                    });
            };
        }])
        .controller('CoursesShowController', ['$scope', '$rootScope', '$routeParams', '$http', '$filter', 'errorsModal', function ($scope, $rootScope, $routeParams, $http, $filter, errorsModal) {
            $scope.vote = {};
            $scope.postCommentsCommentForm = [];

            $http.get('{{ route("api.courses.show") }}/' + $routeParams.courseId, {cache: true})
                .then(function (response) {
                    $scope.info = response.data;
                }, function (response) {
                    errorsModal.make(response);
                });

            $scope.getComments = function (page) {
                if (undefined === page) {
                    page = 1;
                }

                $http.get('{{ route("api.courses.show") }}/' + $routeParams.courseId + '/comments?page=' + page)
                    .then(function (response) {
                        $scope.comments = response.data;
                    }, function (response) {
                        errorsModal.make(response);
                    });
            };

            if ( ! $rootScope.guest)
            {
                $http.get('{{ route("api.courses.comments.getVotes") }}')
                    .then(function (response) {
                        $scope.vote.votes = response.data;
                    }, function (response) {
                        errorsModal.make(response);
                    });
            }

            $scope.vote.voteComment = function (comment, agree) {
                $scope.vote.voteRequest('POST', comment, agree);
            };

            $scope.vote.voteWithdraw = function (comment, agree) {
                $scope.vote.voteRequest('DELETE', comment, agree);
            };

            $scope.vote.voteRequest = function (method, comment, agree) {
                agree = !!agree;

                $http({method: method, url: '/api/courses/' + comment.id + '/vote', data: {agree: agree}, ignoreLoadingBar: true})
                    .then(function (response) {
                        comment.agree = response.data.agree;
                        comment.disagree = response.data.disagree;

                        if ('POST' === method) {
                            $scope.vote.votes.push({agree: agree, courses_comment_id: comment.id});
                        } else {
                            delete $scope.vote.votes[$scope.vote.findIndex(comment.id)];
                        }
                    }, function (response) {
                        errorsModal.make(response);
                    });
            };

            $scope.vote.findIndex = function (id) {
                for (var i in $scope.vote.votes) {
                    if ($scope.vote.votes.hasOwnProperty(i) && (id === $scope.vote.votes[i].courses_comment_id)) {
                        return i;
                    }
                }

                return -1;
            };

            $scope.postComments = function (commentId) {
                var url = '/api/courses/' + $routeParams.courseId + '/comments';

                if (undefined !== commentId) {
                    url += '/' + commentId;
                    $scope.postCommentsCommentForm[commentId].submit = true;
                } else {
                    $scope.postCommentForm.submit = true;
                }

                $http.post(url, {
                    content: (undefined !== commentId) ? $scope.postCommentsCommentForm[commentId].content : $scope.postCommentForm.content,
                    anonymous: (undefined !== commentId) ? $scope.postCommentsCommentForm[commentId].anonymous :  $scope.postCommentForm.anonymous
                }).then(function (response) {
                    $scope.getComments($scope.comments.current_page);

                    if (undefined !== commentId) {
                        $scope.postCommentsCommentForm[commentId] = {submit: false};
                    } else {
                        $scope.postCommentForm = {submit: false};
                    }
                }, function (response) {
                    errorsModal.make(response);

                    if (undefined !== commentId) {
                        $scope.postCommentsCommentForm[commentId] = {submit: false};
                    } else {
                        $scope.postCommentForm = {submit: false};
                    }
                });
            };

            $scope.commentsPaginate = function (nextPage, url) {
                if (null !== url) {
                    $http.get(url, {cache: true})
                        .then(function (response) {
                            $scope.comments = response.data;
                        }, function (response) {
                            errorsModal.make(response);
                        });
                }
            };

            $scope.getComments();
        }]);
})();