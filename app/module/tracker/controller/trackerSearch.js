angular.module('tracker')

/*
 * TrackerSearchController
 * 
 * @param var searchValue
 * @param string trackerName
 * @param var trackerOrderBy
 * @param int trackerLimitTo
 * @param bool activeIMDb
 */
.controller('TrackerSearchController', ['$scope', '$http', '$location', 'Tracker', 'Meta', 'qBittorrent', function ($scope, $http, $location, Tracker, Meta, qBittorrent) {
          
    $scope.searchValueOld = "";
    $scope.tracker = null;
    $scope.trackerResult = null;
    $scope.isLoading = false;
    $scope.metaCache = [];
    $scope.metaCacheTmp = [];
    
    $scope.search = function(search) {
        if(search != $scope.searchValueOld) {
            $scope.isLoading = true;
            $scope.trackerResult = null;
            Tracker.search($scope.trackerName, search).then(function(response) {
                angular.forEach(response.data.data, function(value, key) {
                    value.completed = parseInt(value.completed);
                });
                $scope.searchValueOld = search;
                $scope.trackerResult = response.data.data;
                $scope.isLoading = false;
                
                
                
                if($scope.activeIMDb) {
                    angular.forEach(response.data.data, function(value, key) {
                        if(value.recognize.title) {
                            var cacheTmp = null;
                            value.cacheMetaName = value.recognize.title.toLowerCase().replace(/\s+/g, '') + (value.recognize.year ? value.recognize.year : "");
                            
                            cacheTmp = {
                                'cacheName': value.cacheMetaName,
                                'title': value.recognize.title,
                                'year': (value.recognize.year ? value.recognize.year : "")
                            };
                            
                            if(cacheTmp && !$scope.metaCacheTmp[value.cacheMetaName]) {
                                $scope.metaCacheTmp[value.cacheMetaName] = cacheTmp;
                            }
                        }
                    });
                    
                    var key;
                    for(key in $scope.metaCacheTmp) {
                        var cache = $scope.metaCacheTmp[key];
                        if(!$scope.metaCache[cache.cacheName]) {
                            if(cache.title) {
                                var func = function() {
                                    var cacheVar = cache;
                                    Meta.get(cacheVar.title, cacheVar.year, "").then(function(response) {
                                        $scope.metaCache[cacheVar.cacheName] = response.data.data;
                                    });
                                };
                                func();
                            }
                        }
                    }
                }
                
                
                
                
            });
        }
    };
    
    $scope.addToDowload = function(result, $event)
    {
        $scope.isLoading = true;

        var element = $event.target;

        if(!result.downloadLink)
            result.downloadLink = result.detailLink;

        Tracker.download($scope.trackerName, result.downloadLink).then(function(response) {
                $(element).removeClass('glyphicon-download-alt glyphicon-remove text-danger glyphicon-ok text-success');

            if(response.data.status == 'success')
                $(element).addClass('glyphicon-ok text-success');
            else
                $(element).addClass('glyphicon-remove text-danger');

            $scope.isLoading = false;
        });
        /*
        var dataPost = {
            'link': result.downloadLink
        };
        
        qBittorrent.addLink(dataPost).then(function(response) {
            $(element).removeClass('glyphicon-download-alt glyphicon-remove text-danger glyphicon-ok text-success');

            if(response.data.status == 'success')
                $(element).addClass('glyphicon-ok text-success');
            else
                $(element).addClass('glyphicon-remove text-danger');

            $scope.isLoading = false;
        });*/
    };

    $scope.initTracker = function() {
        $scope.isLoading = true;
        Tracker.getAll().then(function(response) {
            angular.forEach(response.data.data, function(tracker, key) {
                if(tracker.name == $scope.trackerName) {
                    $scope.tracker = tracker;
                }
            });
            $scope.isLoading = false;
        });
    };
    
    $scope.showAll = function() {
        $scope.trackerLimitTo = 999;
    };
    
    $scope.$watch(
        function() {
            return $scope.searchValue;
        },
        function() {
            $scope.search($scope.searchValue);
        }
    );
    
    $scope.initTracker();
}]);