angular.module('webservice')

.factory('Tracker', ['$http', function($http) {
    return {
    	getAll: function() {
	    	return $http.get('phparse/?page=tracker&action=getall');
    	},
    	search: function(tracker, searchValue) {
	    	return $http.get('phparse/?page=tracker&tracker='+tracker+'&action=search&search='+searchValue);
    	},
    	download: function(tracker, url) {
	    	return $http.get('phparse/?page=tracker&tracker='+tracker+'&action=download&url='+url);
    	}
    }
}]);