'use strict';

(function () {
    angular.module('ccu')
        .factory('CourseService', ['$http', '$q', '$rootScope', 'errorsModal', function($http, $q, $rootScope, errorsModal) {
            var courses = [], votes = [];

            $http.get('{{ route("api.courses.comments.getVotes") }}')
                .then(function (response) {
                    votes = response.data;
                    $rootScope.$broadcast('userVotesLoaded');
                }, handleErrorResponse);

            function searchCourse(params) {
                var deferred = $q.defer();

                $http.get('{{ route("api.courses.search") }}', {
                    params: {
                        department: (params.department) ? params.department.id : 0,
                        dimension: (params.dimension) ? params.dimension.id : 0,
                        keyword: params.keyword
                    },
                    cache: true
                })
                    .then(function (response) {
                        deferred.resolve(courses = response.data);
                    }, handleErrorResponse);

                return deferred.promise;
            }

            function getCourses() {
                return courses;
            }

            function insertVote (id, agree) {
                votes.push({agree: agree, courses_comment_id: id});
            }

            function deleteVote(index) {
                if (-1 !== index) {
                    delete votes[index];
                }
            }

            function getVotes() {
                return votes;
            }

            function handleErrorResponse(response) {
                errorsModal.make(response);
            }

            return {
                searchCourse: searchCourse,
                getCourses: getCourses,
                insertVote: insertVote,
                deleteVote: deleteVote,
                getVotes: getVotes
            };
        }]);
})();