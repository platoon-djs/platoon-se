
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
