angular.module('module_library')

.controller('Module_LibraryMovieListController', function ($scope, Library, Meta) {
    
    $scope.loading = 0;
    
    $scope.getMovieList = function() {
        $scope.loading++;
        Library.listMovies().then(function(response) {
            $scope.listMovies = response.data.data;
            
            angular.forEach($scope.listMovies, function(movie, key) {
                $scope.loading++;
                Meta.get(movie.recognize.title, movie.recognize.year, "").then(function(response) {
                    movie.meta = response.data.data;
                    $scope.loading--;
                    console.log(movie);
                });
            });
            console.log($scope.listMovies);
            $scope.loading--;
        });
    };
    
    $scope.getMovieList();
});