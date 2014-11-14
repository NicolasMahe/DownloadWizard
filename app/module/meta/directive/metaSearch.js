angular.module('module_meta')

.directive('metaSearchDirective', function() {
    return {
        restrict: 'E',
        scope: {
            searchValue: '@searchValue',
            selectItemFunction: "=selectItemFunction"
        },
        controller: "Module_MetaSearchController",
        templateUrl: 'app/module/meta/template/metaSearch.tpl.html',
        link: function(scope) {
            
        }
    };
});