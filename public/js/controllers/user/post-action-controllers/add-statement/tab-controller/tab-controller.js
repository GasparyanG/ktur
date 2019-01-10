ktur.controller('TabController', ['$scope', 'ReturnTab', function($scope, ReturnTab) {
    $scope.changeTab = function(elementId) {
        ReturnTab.showTab(elementId);
    }
}]);