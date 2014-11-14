angular.module('module_media')

.directive('mediaListDirective', function() {
    return {
        restrict: 'E',
        scope: {
        },
        controller: "Module_MediaListController",
        templateUrl: 'app/module/media/template/list.tpl.html',
        link: function(scope) {
            
        }
    };
});