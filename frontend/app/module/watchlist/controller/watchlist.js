angular.module('module_watchlist')

.controller('Module_WatchlistController', ['$scope', '$http', 'Watchlist', 'Cron', 'Tracker', function ($scope, $http, Watchlist, Cron, Tracker) {

	$scope.trackerArray = null;
	$scope.watchListArray = null;
	$scope.itemTmp = null;
	$scope.lastFetch = "";
	$scope.editMode = false;
	$scope.isLoading = false;

        $scope.dateShowIconDownloaded = moment().subtract('days', 3);

	$scope.showAdd = function()
	{
		$scope.editMode = false;

		$scope.itemTmp = {
			'tracker': 'IPTorrents',
			'isActive': true
		};

		$('#watchListModal').modal('show');
	}

	$scope.doAdd = function(itemTmp)
	{
            if($scope.editMode == true)
            {
                $scope.isLoading = true;

                Watchlist.update({
                        'data': itemTmp
                }, function(response) {
                    if(response.status == 'success')
                    {
                        $scope.getWatchList(function() {
                            $scope.isLoading = false;
                            $('#watchListModal').modal('hide');
                        });
                    }
                });
            }
            else
            {
                itemTmp.isDownloaded = false;

                $scope.isLoading = true;

                Watchlist.add({
                        'data': itemTmp
                }, function(response) {
                    if(response.status == 'success')
                    {
                        $scope.getWatchList(function() {
                            $scope.isLoading = false;
                            $('#watchListModal').modal('hide');
                        });
                    }
                });
            }
	}


	$scope.doDelete = function(itemTmp)
	{
            $scope.isLoading = true;

            Watchlist.delete(itemTmp.id, function(response) {
                if(response.status == 'success')
                {
                    $scope.getWatchList(function() {
                        $scope.isLoading = false;
                        $('#watchListModal').modal('hide');
                    });
                }
            });
	}

	$scope.getWatchList = function(finishFunc)
	{
		$scope.isLoading = true;

		Watchlist.getAll(function(response) {
			$scope.watchListArray = response.data;

			if(finishFunc)
                            finishFunc();
                        else
                            $scope.isLoading = false;
		});
	}


	$scope.fetchNow = function()
	{
		$scope.isLoading = true;

		Cron.doIt(function(response) {
			$scope.getLastFetch(function(){
                            $scope.getWatchList(function() {
				$scope.isLoading = false;
                            });
			});
		});
	}


	$scope.getLastFetch = function(finishFunc)
	{
		$scope.isLoading = true;

		Cron.getLastFetch(function(response) {
                    $scope.lastFetch = response.data;

			if(finishFunc)
                            finishFunc();
                        else
                            $scope.isLoading = false;

		});
	}




	$scope.showDelete = function(item, index, element)
	{
		var alert = confirm("Delete "+item.name+" ?");
		if (alert == true)
		{
                    $scope.doDelete(item);
		}
	}


	$scope.showEdit = function(item, index, element)
	{
		$scope.itemTmp = angular.copy(item);
		$scope.itemTmpIndex = index;

		$scope.editMode = true;

		$('#watchListModal').modal('show');
	}


	$scope.initTracker = function() {
		$scope.isLoading = true;
		Tracker.getAll(function(response) {
			$scope.trackerArray = response.data;
			$scope.isLoading = false;
		});
	}


	$scope.getWatchList();
	$scope.initTracker();
        $scope.getLastFetch();

}]);
