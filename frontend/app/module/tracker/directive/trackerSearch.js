angular.module('tracker')

.directive('trackerSearchDirective', function() {
    return {
        restrict: 'E',
        scope: {
            searchValue: '@searchValue',
            trackerName: '@trackerName',
            trackerOrderBy: '@trackerOrderBy',
            trackerLimitTo: '@trackerLimitTo',
            activeIMDb: '@activeImdb'
        },
        controller: "TrackerSearchController",
        templateUrl: 'frontend/app/module/tracker/template/trackerSearch.tpl.html',
        link: function(scope) {
            
        }
    };
});