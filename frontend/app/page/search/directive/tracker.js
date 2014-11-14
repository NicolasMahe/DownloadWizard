angular.module('page')

.directive('trackerDirective', function() {
    return {
        //restrict: 'E',
        templateUrl: 'frontend/app/page/search/template/trackerDirective.tpl.html',
        link: function(scope, element, attrs) {
        }
    };
});