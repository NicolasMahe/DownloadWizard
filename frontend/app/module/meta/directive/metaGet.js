angular.module('module_meta')

.directive('metaGetDirective', function() {
    return {
        restrict: 'E',
        scope: {
            imdbID: '@imdbId',
            resultFunction: '=resultFunction'
        },
        controller: "Module_MetaGetController",
        templateUrl: 'frontend/app/module/meta/template/metaGet.tpl.html',
        link: function(scope) {
            
        }
    };
});