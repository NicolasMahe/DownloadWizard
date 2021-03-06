angular.module('webservice')

.factory('qBittorrent', ['$http', function($http) {
    return {
    	torrentList: function() {
            return $http.get('/backend/?page=downloader&action=torrentList');
    	},
    	torrentInfo: function(hash) {
            return $http.get('/backend/?page=downloader&action=torrentInfo&hash='+hash);
    	},
    	torrentTrackers: function(hash) {
            return $http.get('/backend/?page=downloader&action=torrentTrackers&hash='+hash);
    	},
    	torrentFiles: function(hash) {
            return $http.get('/backend/?page=downloader&action=torrentFiles&hash='+hash);
    	},
    	torrentPause: function(data) {
            return $http.post('/backend/?page=downloader&action=torrentPause', data);
    	},
    	torrentResume: function(data) {
            return $http.post('/backend/?page=downloader&action=torrentResume', data);
    	},
    	torrentDelete: function(data) {
            return $http.post('/backend/?page=downloader&action=torrentDelete', data);
    	},Extract: function(data) {
            return $http.post('/backend/?page=downloader&action=torrentExtract', data);
    	},
    	torrentExtract: function(data) {
            return $http.post('/backend/?page=downloader&action=torrentExtract', data);
    	},
    	addLink: function(data) {
            return $http.post('/backend/?page=downloader&action=addLink', data);
    	},
    	speedLimit: function() {
            return $http.get('/backend/?page=downloader&action=speedLimit');
    	},
    	speedLimitSet: function(data) {
            return $http.post('/backend/?page=downloader&action=speedLimitSet', data);
    	},
    	globalSpeed: function() {
            return $http.get('/backend/?page=downloader&action=globalSpeed');
    	},
    }
}]);