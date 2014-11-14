angular.module('webservice')

.factory('Library', ['$http', function($http) {
    return {
    	listTVShows: function() {
            return $http.get('/phparse/?page=library&action=listTVShows');
    	},
    	listMovies: function() {
            return $http.get('/phparse/?page=library&action=listMovie');
    	}
    }
}]);