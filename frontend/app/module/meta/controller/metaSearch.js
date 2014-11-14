angular.module('module_meta')

.controller('Module_MetaSearchController', function ($scope, Meta) {
    
    $scope.isLoading = false;
    $scope.searchResult = null;
    
    $scope.searchMeta = function(search) {
        $scope.isLoading = true;
        
        Meta.search(search).then(function(response) {
            $scope.searchResult = response.data.data;
            $scope.isLoading = false;
            
            if($scope.searchResult.length == 1 && $scope.selectItemFunction) {
                $scope.selectItemFunction($scope.searchResult[0]);
            }
        });
    };
    
    $scope.select = function(item, $event) {
        if($event) {
            $($event.currentTarget).parents('table').find('tr').removeClass('active');
            $($event.currentTarget).addClass('active');
        }
        
        if($scope.selectItemFunction) {
            $scope.selectItemFunction(item);
        }
    };
    
    $scope.$watch(
        function() {
            return $scope.searchValue;
        },
        function() {
            $scope.searchMeta($scope.searchValue);
        }
    );
    
});