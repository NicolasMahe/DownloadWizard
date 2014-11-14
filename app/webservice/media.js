angular.module('webservice')

.factory('Media', ['$http', function($http) {
    return {
    	getAll: function() {
            return $http.get('/phparse/?page=media&action=get');
    	}
    }
}]);