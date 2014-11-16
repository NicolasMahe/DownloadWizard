angular.module('page')

.controller('QuickSearchController', function ($scope, Meta, $filter) {
    
    $scope.trackerorderby = "";
    $scope.searchvaluetracker = null;
    $scope.selectItemImdbID = "";
    
    
    $scope.metaSearchSelectItem = function(item) {
        $scope.selectItemImdbID = item.imdbID;
    }
    
    
    $scope.metaGetResult = function(item) {
        if(item.title && item.year) {
            var searchString = item.title;

            if(item.type == "movie") {
                $scope.trackerorderby = '-completed';
                searchString += " "+item.year + " 1080p";
            }else if(item.type == "series") {
                $scope.trackerorderby = '';
                searchString += " 720p";
            }
            $scope.searchvaluetracker = searchString;
        }
    }
    
    
    //$scope.doSearch("need for speed", "2014");
    //$scope.searchMeta("defiance");
    
    /*$scope.searchMetaFromTypeahead = function(query, process) {
        $scope.isLoading = true;
        
        Meta.search(query).then( function(response) {
            console.log(response.data.data);
            process(response.data.data);
            $scope.isLoading = false;
        });
    };
    
    $("#typehead").typeahead({
        source: $scope.searchMetaFromTypeahead,
        minLength: 3,
        matcher: function (item) {
            return true;
        },
        sorter: function (items) {
            return items;
        },
        highlighter: function (item) {
            return item.title + " ("+item.year+") ["+item.type+"]";
        },
        updater: function (item) {
            console.log(item);
            return item.title + " ("+item.year+") ["+item.type+"]";
        }
    });*/
    
});