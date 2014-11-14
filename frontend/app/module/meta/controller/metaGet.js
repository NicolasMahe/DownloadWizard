angular.module('module_meta')

.controller('Module_MetaGetController', function ($scope, Meta) {
    
    $scope.isLoading = false;
    $scope.metaResult = null;
    
    $scope.getMeta = function(imdbID) {
        $scope.isLoading = true;
        
        $scope.metaResult = null;
        //$scope.trackerResult = null;
        
        Meta.get("", "", imdbID).then(function(response) {
            $scope.metaResult = response.data.data;
            $scope.isLoading = false;
            
            if($scope.metaResult && $scope.resultFunction) {
                $scope.resultFunction($scope.metaResult);
            }
        });
    }
    
    $scope.$watch(
        function() {
            return $scope.imdbID;
        },
        function() {
            $scope.getMeta($scope.imdbID);
        }
    );
    
});