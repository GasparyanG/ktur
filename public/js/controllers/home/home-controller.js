ktur.controller("HomeCtrl", ["$scope", "$http", "HrefSupporter", "DropDown", "AllFetcher", "ResentAdded", "MostStared", "AdvancedSearch", "RegExpSupporter", "UserStatementsRendering", "Cleaner",
function($scope, $http, HrefSupporter, DropDown, AllFetcher, ResentAdded, MostStared, AdvancedSearch, RegExpSupporter, UserStatementsRendering, Cleaner) {
    var urlDesiredPortion = RegExpSupporter.validateSearchQuery(window.location.href);
    if (urlDesiredPortion) {
        console.log(urlDesiredPortion);
        Cleaner.cleanAll();

        $http({
            method: "GET",
            url: "/home/statement-resources?ind-house-offset=0&filter=string-based-search&statement-being-searched=" + urlDesiredPortion
        }).then(function successCallback(response) {
            console.log(response.data);
            UserStatementsRendering.renderUserStatements(response.data, $scope);
        }, function errorCallback(response) {
            console.log("error");
        })
    }

    else {
        var hrefArray = HrefSupporter.getHrefs($http);
    }
    
    AllFetcher.getAllStatements($http, $scope);
    AdvancedSearch.setAdvancedSearch($scope, $http);
    MostStared.setButtonToReturnMostStared($scope, $http);
    ResentAdded.setButtonToReturnResentAdded($scope, $http);
    DropDown.prepareDropDown($scope, $http);
}]);