angular.module('webservice')

.factory('Meta', ['$http', function($http) {
    return {
    	get: function(title, year, imdbID) {
            return $http.get('phparse/?page=meta&action=get&title='+title+'&year='+year+'&imdbID='+imdbID);
    	},
        search: function(search) {
            return $http.get('phparse/?page=meta&action=search&search='+search);
    	}
    }
}]);