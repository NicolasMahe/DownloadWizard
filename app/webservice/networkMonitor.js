angular.module('webservice')

.factory('NetworkMonitor', ['$http', function($http) {
    return {
    	getAll: function() {
            return $http.get('phparse/?page=networkmonitor&action=get');
    	}
    }
}]);