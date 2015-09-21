'use strict';

(function () {
    var _errorsModal, handleErrorResponse = function (response) {
        _errorsModal.make(response);
    };

    angular.module('ccu')
        .run(['errorsModal', function(errorsModal) {
            _errorsModal = errorsModal;
        }])
        .controller('CoursesController', ['$http', '$scope', 'CourseService', function ($http, $scope, CourseService) {
            $scope.options = {};
            $scope.search = {keyword: ''};
            $scope.courses = CourseService.getCourses();

            var courses = JSON.parse(localStorage.getItem('courses')),
                pushLocalStorage = function (item, data) {
                    if ( ! (courses = JSON.parse(localStorage.getItem('courses')))) {
                        courses = {};
                    }
                    courses[item] = data;
                    localStorage.setItem('courses', JSON.stringify(courses));
                };

            if (courses) {
                $scope.options.departments = courses.departments;
                $scope.options.dimensions = courses.dimensions;
            } else {
                $http.get('{{ route("api.courses.departments") }}', {cache: true})
                    .then(function (response) {
                        $scope.options.departments = response.data;
                        pushLocalStorage('departments', response.data);
                    }, handleErrorResponse);

                $http.get('{{ route("api.courses.dimensions") }}', {cache: true})
                    .then(function (response) {
                        $scope.options.dimensions = response.data;
                        pushLocalStorage('dimensions', response.data);
                    }, handleErrorResponse);
            }

            $http.get('{{ route("api.courses.exams.newestHottest") }}', {cache: true})
                .then(function (response) {
                    $scope.exams = response.data;
                }, handleErrorResponse);

            $http.get('{{ route("api.courses.comments.newest") }}', {cache: true})
                .then(function (response) {
                    $scope.comments = response.data;
                }, handleErrorResponse);

            $scope.searchFormSubmit = function () {
                CourseService.searchCourse($scope.search)
                    .then(function (data) {
                        $scope.courses = data;
                    });
            };
        }])
        .controller('CoursesShowController', ['$http', '$scope', '$stateParams', function ($http, $scope, $stateParams) {
            if (0 !== $stateParams.courseId.length) {
                $http.get('/api/courses/' + $stateParams.courseId, {cache: true})
                    .then(function (response) {
                        $scope.info = response.data;
                    }, handleErrorResponse);
            }
        }])
        .controller('CoursesExamsController', ['$http',  '$scope', '$stateParams', 'toaster', 'Upload', function ($http, $scope, $stateParams, toaster, Upload) {
            $scope.exam = {};

            $scope.getExams = function () {
                $http.get('/api/courses/' + $stateParams.courseId + '/exams')
                    .then(function (response) {
                        $scope.exams = response.data;
                    }, handleErrorResponse);
            };

            $http.get('{{ route("api.courses.semesters") }}', {cache: true})
                .then(function (response) {
                    $scope.semesters = response.data;
                }, handleErrorResponse);

            $scope.examFormSubmit = function () {
                Upload.upload({
                    url: 'api/courses/' + $stateParams.courseId + '/exams',
                    fields: {semester: $scope.exam.semester.id},
                    file: $scope.exam.file
                }).then(function () {
                    $scope.exam = {};
                    $scope.getExams();
                    toaster.pop({type: 'success', title: '上傳成功', timeout: 4500, showCloseButton: true});
                }, handleErrorResponse)
            };

            $scope.getExams();
        }])
        .controller('CoursesCommentsController', ['$http', '$rootScope', '$scope', '$stateParams', 'CourseService', 'toaster', function ($http, $rootScope, $scope, $stateParams, CourseService, toaster) {
            $scope.vote = {votes: CourseService.getVotes()};
            $scope.comment = {showReply: true};
            $scope.commentsComment = [];

            $scope.$on('userVotesLoaded', function() {
                $scope.vote.votes = CourseService.getVotes();
            });

            $scope.getComments = function (page) {
                page = page || 1;

                $http.get('/api/courses/' + $stateParams.courseId + '/comments?page=' + page)
                    .then(function (response) {
                        $scope.comments = response.data;
                    }, handleErrorResponse);
            };

            $scope.vote.voteComment = function (comment, agree) {
                $scope.vote.voteRequest('POST', comment, agree);
            };

            $scope.vote.voteWithdraw = function (comment, agree) {
                $scope.vote.voteRequest('DELETE', comment, agree);
            };

            $scope.vote.voteRequest = function (method, comment, agree) {
                agree = !!agree;

                $http({method: method, url: '/api/courses/comments/' + comment.id + '/vote', data: {agree: agree}, ignoreLoadingBar: true})
                    .then(function (response) {
                        comment.agree = response.data.agree;
                        comment.disagree = response.data.disagree;

                        if ('POST' === method) {
                            CourseService.insertVote(comment.id, agree);
                        } else {
                            CourseService.deleteVote($scope.vote.findIndex(comment.id));
                        }

                        $scope.vote.votes = CourseService.getVotes();
                    }, handleErrorResponse);
            };

            $scope.vote.findIndex = function (id) {
                for (var i in $scope.vote.votes) {
                    if ($scope.vote.votes.hasOwnProperty(i) && (id === $scope.vote.votes[i].courses_comment_id)) {
                        return i;
                    }
                }

                return -1;
            };

            $scope.commentFormSubmit = function (commentId) {
                var isSubComment = ! angular.isUndefined(commentId),
                    url = '/api/courses/' + $stateParams.courseId + '/comments' + ((isSubComment) ? ('/' + commentId) : '');

                if ( ! isSubComment && ! $scope.checkCommentIsValid($scope.comment.content)) {
                    return;
                }

                $http.post(url, {
                    content: (isSubComment) ? $scope.commentsComment[commentId].content : $scope.comment.content,
                    anonymous: (isSubComment) ? $scope.commentsComment[commentId].anonymous :  $scope.comment.anonymous
                }).then(function () {
                    $scope.getComments($scope.comments.current_page);

                    if (isSubComment) {
                        $scope.commentsComment[commentId] = {};
                    } else {
                        $scope.comment = {};
                    }

                    toaster.pop({type: 'success', title: '評論成功', timeout: 4500, showCloseButton: true});
                }, handleErrorResponse);
            };

            $scope.checkCommentIsValid = function (content) {
                var message = '';

                if ((angular.isUndefined(content)) || (content.length < 17)) {
                    message = '文章過短';
                }

                if (message.length) {
                    toaster.pop({type: 'warning', title: message, timeout: 4500, showCloseButton: true});

                    return false;
                }

                return true;
            };

            $scope.commentsPaginate = function (nextPage, url) {
                if (null !== url) {
                    $http.get(url)
                        .then(function (response) {
                            $scope.comments = response.data;
                        }, handleErrorResponse);
                }
            };

            $scope.getComments();
        }]);
})();