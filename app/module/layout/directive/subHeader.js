angular.module('layout')

.directive('subHeaderDirective', function() {
	return {
		restrict: 'E',
		templateUrl: 'app/module/layout/template/subHeader.tpl.html'
	};
});