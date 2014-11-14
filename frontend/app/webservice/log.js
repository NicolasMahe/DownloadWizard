angular.module('webservice')

.factory('Log', ['$http', function($http) {
    return {
    	getAll: function(successFunction, errorFunction) {
	    	$http.get('backend/?page=log&action=getAll').
			success(function(data, status, headers, config) {
				if(successFunction)
					successFunction(data);
			})
		    .error(function(data, status, headers, config) {
				if(errorFunction)
					errorFunction(data, status);
		    });
    	}
    }
}]);