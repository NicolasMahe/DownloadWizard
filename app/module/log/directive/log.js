angular.module('module_log')

.directive('logDirective', function() {
    return {
        restrict: 'E',
        scope: {
        },
        controller: "Module_LogController",
        templateUrl: 'app/module/log/template/log.tpl.html',
        link: function(scope) {
            
        }
    };
});