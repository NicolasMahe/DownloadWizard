angular.module('module_downloader')

.controller('Module_DownloaderTorrentListController', function ($scope, qBittorrent, $timeout, Subtitle) {
    
    $scope.torrentList = null;
    $scope.loading = 0;
    $scope.timeoutReload = null;
    $scope.speedLimit = null;
    $scope.torrentCurrentInfo = null;
    
    $scope.$on('$destroy', function(){
        $timeout.cancel($scope.timeoutReload);
    });
    
    $scope.showPoperOver = function($event) {
        $($event.target).popover('toggle');
    }
    
    $scope.getTorrentList = function() {
        $scope.loading++;
        qBittorrent.torrentList().then(function(response) {
            $scope.torrentList = response.data.data;
            
            angular.forEach($scope.torrentList, function(torrent, key) {
                torrent.progressPR = Math.round(torrent.progress * 10000) / 100;
            });
            
            /*if($scope.torrentCurrentInfo) {
                $scope.torrentInfo($scope.torrentCurrentInfo.torrent);
            }*/
            
            $scope.loading--;
        });
        $scope.getGlobalSpeed();
    };
    
    $scope.torrentPause = function(torrent) {
        $scope.loading++;
        
        var dataPost = {
            'hash': torrent.hash
        };
        
        qBittorrent.torrentPause(dataPost).then(function(response) {
            $scope.loading--;
            $scope.getTorrentList();
        });
    }
    $scope.torrentResume = function(torrent) {
        $scope.loading++;
        
        var dataPost = {
            'hash': torrent.hash
        };
        
        qBittorrent.torrentResume(dataPost).then(function(response) {
            $scope.loading--;
            $scope.getTorrentList();
        });
    }
    $scope.torrentDelete = function(torrent) {
        if (confirm("Delete '" + torrent.name + "' ?") == true) {
            $scope.loading++;
        
            var dataPost = {
                'hash': torrent.hash
            };

            qBittorrent.torrentDelete(dataPost).then(function(response) {
                $scope.loading--;
                $('#DownloaderTorrentListModal').modal('hide');
                $scope.getTorrentList();
            });
        }
    }
    $scope.torrentExtract = function(torrent) {
        $scope.loading++;

        var dataPost = {
            'hash': torrent.hash
        };

        qBittorrent.torrentExtract(dataPost).then(function(response) {
            $scope.loading--;
        });
    }
    $scope.torrentDownloadSubtitle = function(torrent) {
        $scope.loading++;

        Subtitle.downloadFirst(torrent.name).then(function(response) {
            $scope.loading--;
        });
    }
    $scope.torrentInfo = function(torrent) {
        $scope.loading++;
        
        var data = {
            'info': null,
            'trackers': null,
            'files': null,
            'torrent': torrent
        };

        qBittorrent.torrentInfo(torrent.hash).then(function(response) {
            data.info = response.data.data;
            qBittorrent.torrentTrackers(torrent.hash).then(function(response) {
                data.trackers = response.data.data;
                qBittorrent.torrentFiles(torrent.hash).then(function(response) {
                    data.files = response.data.data;
                    $scope.torrentCurrentInfo = data;
                    
                    angular.forEach($scope.torrentCurrentInfo.files, function(file, key) {
                        file.progressPR = Math.round(file.progress * 10000) / 100;
                    });
                    
                    $scope.loading--;
                    if($('#DownloaderTorrentListModal').css('display') != "block") {
                        $('#DownloaderTorrentListModal').modal('show');
                    }
                });
            });
        });
    }
    
    $scope.getGlobalSpeed = function() {
        $scope.loading++;
        qBittorrent.globalSpeed().then(function(response) {
            $scope.globalSpeed = response.data.data;
            $scope.loading--;
        });
    };
    $scope.getSpeedLimit = function() {
        $scope.loading++;
        qBittorrent.speedLimit().then(function(response) {
            $scope.speedLimit = response.data.data;
            $scope.loading--;
        });
    };
    $scope.setSpeedLimit = function(download, upload) {
        $scope.loading++;
        
        var dataPost = {
            'download': download,
            'upload': upload
        };
        
        qBittorrent.speedLimitSet(dataPost).then(function(response) {
            $scope.loading--;
            $scope.getSpeedLimit();
        });
    };
    
    $scope.lauchTimeoutReload = function() {
        $scope.timeoutReload = $timeout(function() {
            $scope.getTorrentList();
            $scope.lauchTimeoutReload();
        }, 5000);
    }
    
    $scope.$watch(
        function() {
            return $scope.reload;
        },
        function() {
            $scope.getTorrentList();
        }
    );

    //$scope.lauchTimeoutReload();
    $scope.getTorrentList();
    $scope.getSpeedLimit();
});