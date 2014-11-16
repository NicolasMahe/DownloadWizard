angular.module('webservice')

.factory('Cron', ['$http', function($http) {
    return {
    	doIt: function(successFunction, errorFunction) {
	    	$http.get('backend/?page=cron&action=doit').
			success(function(data, status, headers, config) {
				if(successFunction)
					successFunction(data);
			})
		    .error(function(data, status, headers, config) {
				if(errorFunction)
					errorFunction(data, status);
		    });
    	},
    	getLastFetch: function(successFunction, errorFunction) {
	    	$http.get('backend/?page=cron&action=getLastFetch').
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