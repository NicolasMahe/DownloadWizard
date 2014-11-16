angular.module('webservice')

.factory('Watchlist', ['$http', function($http) {
    return {
    	update: function(dataToPost, successFunction, errorFunction) {
	    	$http.post('backend/?page=watchlist&action=update', dataToPost).
			success(function(data, status, headers, config) {
				if(successFunction)
					successFunction(data);
			})
		    .error(function(data, status, headers, config) {
				if(errorFunction)
					errorFunction(data, status);
		    });
    	},
    	add: function(dataToPost, successFunction, errorFunction) {
	    	$http.post('backend/?page=watchlist&action=add', dataToPost).
			success(function(data, status, headers, config) {
				if(successFunction)
					successFunction(data);
			})
		    .error(function(data, status, headers, config) {
				if(errorFunction)
					errorFunction(data, status);
		    });
    	},
    	get: function(id, successFunction, errorFunction) {
	    	$http.get('backend/?page=watchlist&action=get&id='+id).
			success(function(data, status, headers, config) {
				if(successFunction)
					successFunction(data);
			})
		    .error(function(data, status, headers, config) {
				if(errorFunction)
					errorFunction(data, status);
		    });
    	},
    	getAll: function(successFunction, errorFunction) {
	    	$http.get('backend/?page=watchlist&action=get').
			success(function(data, status, headers, config) {
				if(successFunction)
					successFunction(data);
			})
		    .error(function(data, status, headers, config) {
				if(errorFunction)
					errorFunction(data, status);
		    });
    	},
    	delete: function(id, successFunction, errorFunction) {
	    	$http.get('backend/?page=watchlist&action=delete&id='+id).
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