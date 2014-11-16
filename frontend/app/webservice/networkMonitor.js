angular.module('webservice')

.factory('NetworkMonitor', ['$http', function($http) {
    return {
    	getAll: function() {
            return $http.get('backend/?page=networkmonitor&action=get');
    	}
    }
}]);