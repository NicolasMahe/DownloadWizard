angular.module('layout')

.directive('subHeaderDirective', function() {
	return {
		restrict: 'E',
		templateUrl: 'frontend/app/module/layout/template/subHeader.tpl.html'
	};
});