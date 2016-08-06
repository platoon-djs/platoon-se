
angular
    .module('pages.about', [])

    .controller('AboutController', AboutController)

    .directive('platoonMember', memberDirective)
    .directive('platoonProspect', prospectDirective);


AboutController.$inject = ['$http'];
function AboutController($http) {
    var _this = this;

    // $http.get('/api/members.php').then(function(resp) {
    //  var data = resp.data;
    //  _this.members = data.members;
    //  _this.prospects = data.prospects;
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
