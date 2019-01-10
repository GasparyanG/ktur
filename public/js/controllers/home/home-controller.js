ktur.controller("HomeCtrl", ["$scope", "$http", "HrefSupporter", "DropDown", "AllFetcher", "ResentAdded", "MostStared", "AdvancedSearch",
function($scope, $http, HrefSupporter, DropDown, AllFetcher, ResentAdded, MostStared, AdvancedSearch) {
    var hrefArray = HrefSupporter.getHrefs($http);
    DropDown.prepareDropDown($scope, $http);
    AllFetcher.getAllStatements($http, $scope);
    ResentAdded.setButtonToReturnResentAdded($scope, $http);
    MostStared.setButtonToReturnMostStared($scope, $http);
    AdvancedSearch.setAdvancedSearch($scope, $http);
}]);