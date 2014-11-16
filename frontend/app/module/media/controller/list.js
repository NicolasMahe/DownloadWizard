angular.module('module_media')

.controller('Module_MediaListController', function ($scope, Media) {
    
    $scope.loading = 0;
    $scope.list = null;
    
    $scope.getList = function() {
        $scope.loading++;
        Media.getAll().then(function(response) {
            $scope.loading--;
            $scope.list = response.data.data;
        });
    };
    
    $scope.getList();
});