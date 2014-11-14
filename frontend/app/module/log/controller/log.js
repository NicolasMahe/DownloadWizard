angular.module('module_log')

.controller('Module_LogController', ['$scope', '$http', '$timeout', 'Log', function ($scope, $http, $timeout, Log) {

    $scope.loading = 0;
    $scope.doRotation = false;

    $scope.getLog = function()
    {
        $scope.loading++;

        Log.getAll(function(response) {
            $scope.logArray = response.data.reverse();
            $scope.loading--;
        });
    }

    $scope.getLog();
	
}]);