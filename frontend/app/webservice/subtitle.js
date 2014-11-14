angular.module('webservice')

.factory('Subtitle', ['$http', function($http) {
    return {
    	downloadFirst: function(search) {
            return $http.get('/backend/?page=subtitle&action=downloadFirst&search='+search);
    	}
    }
}]);