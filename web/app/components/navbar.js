
angular
	.module('components.navbar', [])

	.directive('scrollSpy', scrollSpyDirective);



scrollSpyDirective.$inject = ['$window'];
function scrollSpyDirective($window) {

	return {
		restrict: 'A',
		scope: {
			delta: '@scrollDelta',
			scroll: '@scrollSpy'
		},
		link: link
	}

	function link(scope, element) {
		if (!scope.delta || isNaN(scope.delta) || !scope.scroll) return;

		var noclass = true,
			delta = parseInt(scope.delta);

		$($window).scroll(function(e) {
			if (!noclass && $window.scrollY < delta) {
				noclass = true;
				element.toggleClass(scope.scroll);
			} else if (noclass && $window.scrollY > delta) {
				noclass = false;
				element.toggleClass(scope.scroll);
			}
		});
	}
}