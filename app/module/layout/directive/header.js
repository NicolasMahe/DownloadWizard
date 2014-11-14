angular.module('layout')

.directive('headerDirective', function() {
	return {
		restrict: 'E',
		templateUrl: 'app/module/layout/template/header.tpl.html',
                link: function(scope) {
                    $('.navbar-collapse a').click(function() {
                        console.log('click');
                        $('.navbar-collapse').collapse('hide');
                    })
                }
	};
});