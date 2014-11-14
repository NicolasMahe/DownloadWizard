angular.module('webservice')

.factory('Meta', ['$http', function($http) {
    return {
    	get: function(title, year, imdbID) {
            return $http.get('backend/?page=meta&action=get&title='+title+'&year='+year+'&imdbID='+imdbID);
    	},
        search: function(search) {
            return $http.get('backend/?page=meta&action=search&search='+search);
    	}
    }
}]);