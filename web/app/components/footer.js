
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
