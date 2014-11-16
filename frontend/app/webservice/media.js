angular.module('webservice')

.factory('Media', ['$http', function($http) {
    return {
    	getAll: function() {
            return $http.get('/backend/?page=media&action=get');
    	}
    }
}]);