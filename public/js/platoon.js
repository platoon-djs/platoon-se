(function(window, angular) {
"use strict";


angular
	.module('components', [
		'components.navbar',
		'components.footer'
	])

angular
	.module('components.footer', [])

	.directive('currentYear', currentYearDirective)
	//.directive('platoonRatings', ratingsDirective)
	.directive('platoonRating', ratingDirective);


function currentYearDirective() {
	return {
		link: function(scope, element) {
			element.html(new Date().getFullYear());
		}
	}
}


ratingsDirective.$inject = ['$http', '$interval', '$timeout']
function ratingsDirective($http, $interval, $timeout) {

	var template = [
		'<div class="platoon-rating-container">',
			'<div class="platoon-rating" platoon-rating="rating" ng-repeat="rating in ratings"></div>',
		'</div>'
	].join('');

	return {
		replace: true,
		scope: {
			url: '@platoonRatings',
			ratings: '=?',
			interval: '@?'
		},
		link: function(scope, element) {
			var looptime = scope.interval ? parseInt(scope.interval) : 6000;

			$http.get(scope.url)
				.then(function(resp) {
					var ratings = scope.ratings = resp.data;

					if (ratings.length > 1) {
						$timeout(function() {
							var children = element.children(),
								idx = 0;
							children.hide().first().show();
							$interval(function() {
								idx++;
								children.fadeOut(200);
								setTimeout(function() {
									children.eq(idx%children.length).fadeIn();
								}, 220);
							}, looptime)
						})
					}
				});
		},
		template: template
	}
}

function ratingDirective() {

	var template = [
		'<span class="stars">',
			'<i class="fa fa-star" ng-class="{faded:s>rating.rating}" ng-repeat="s in [1, 2, 3, 4, 5]"></i>',
		'</span>',
		'<p>{{ rating.text }}</p>',
		'<p><em>- {{ rating.name }}</em></p>'
	].join('');

	return {
		scope: {
			rating: '=platoonRating'
		},
		template: template
	}
}

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


angular
	.module('pages', [
		'pages.about',
		'pages.booking'
	]);

angular
	.module('pages.about', [])

	.controller('AboutController', AboutController)

	.directive('platoonMember', memberDirective)
	.directive('platoonProspect', prospectDirective);


AboutController.$inject = ['$http'];
function AboutController($http) {
	var _this = this;

	// $http.get('/api/members.php').then(function(resp) {
	// 	var data = resp.data;
	// 	_this.members = data.members;
	// 	_this.prospects = data.prospects;
	// });
}


function memberDirective() {

	var template = [
		'<div class="col-md-12">',
			'<div class="thumbnail site-about-member media-object">',
				'<div class="media-left">',
					'<img ng-src="{{ member.image }}" alt="{{ member.name }}">',
				'</div>',
				'<div class="media-body">',
					'<h3>{{ member.name }}</h3>',
					'<p class="info" ng-if="member.post">{{ member.post }}</p>',
					'<p>{{ member.description }}</p>',
				'</div>',
			'</div>',
		'</div>'
	].join('');

	return {
		restrict: 'A',
		scope: {
			member: '=platoonMember'
		},
		template: template
	}
}

function prospectDirective() {

	var template = [
		'<div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">',
			'<div class="thumbnail site-about-prospect">',
				'<img ng-src="{{ prospect.image }}" alt="{{ prospect.name }}">',
				'<div class="caption">',
					'<h3>{{ prospect.name }}</h3>',
					'<p class="info">{{ prospect.post ? prospect.post : \'&nbsp;\' }}</p>',
					//'<p>{{ prospect.description }}</p>',
				'</div>',
			'</div>',
		'</div>'
	].join('');

	return {
		restrict: 'A',
		scope: {
			prospect: '=platoonProspect'
		},
		template: template
	}
}

angular
	.module('pages.booking', ['ui.bootstrap'])

	.controller('BookingController', BookingController);



BookingController.$inject = ['$scope', '$http'];
function BookingController($scope, $http) {
	
	$scope.msg = {};
	$scope.pending;

	$scope.getLocation = function(input) {
		if (!input || input.length < 2) return [];

		return $http.get('/booking/place/' + input)
			.then(function(response){
				if (!response.data.predictions) return [];
				return response.data.predictions.map(function(item) {
					return item.description
				});
			});
	}

	$scope.submit = function(form) {
		var valid = form.$valid && ($scope.msg.captcha !== undefined && $scope.msg.captcha !== false);

		if (valid) {
			$scope.pending = true;
			$http.post('/booking/send', $scope.msg)
				.then(function(resp) {
					console.log(resp.data);
					$scope.messageSent = true;
				}, function(resp) {
					console.log(resp.data);
				}).finally(function() {
					$scope.pending = false;
				});
		}
	}

}


angular
	.module('platoon', [
		'pages',
		'components'
	])
})(window, window.angular);