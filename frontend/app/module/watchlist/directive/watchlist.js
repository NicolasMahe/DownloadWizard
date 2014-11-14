angular.module('module_watchlist')

.directive('watchlistDirective', function() {
    return {
        restrict: 'E',
        scope: {
        },
        controller: "Module_WatchlistController",
        templateUrl: 'frontend/app/module/watchlist/template/watchlist.tpl.html',
        link: function(scope) {
            
        }
    };
});