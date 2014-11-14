angular.module('page')

.controller('SearchController', ['$scope', '$http', 'Tracker', function ($scope, $http, Tracker) {

	$scope.trackerArray = null;
	$scope.isLoading = false;
	
	$scope.initTracker = function() {
		$scope.isLoading = true;
		Tracker.getAll().then(function(response) {
			$scope.trackerArray = response.data.data;
			$scope.isLoading = false;
		});
	}
    
	$scope.initTracker();
	
}]);