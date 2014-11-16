angular.module('module_networkMonitor')

.directive('networkMonitorGraphTrafficDirective', function() {
    return {
        restrict: 'E',
        controller: "module_networkMonitorGraphTrafficController",
        templateUrl: 'frontend/app/module/networkMonitor/template/graphTraffic.tpl.html',
        link: function($scope) {
            
        }
    };
});