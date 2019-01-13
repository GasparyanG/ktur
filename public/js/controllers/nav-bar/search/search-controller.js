ktur.controller("SerachController", ["$scope", function($scope) {
    $scope.searchForData = function() {
        window.location.href = "/home/statement-resources?search=" + $scope.searchKtur;
    }
}]);