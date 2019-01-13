ktur.controller("AuthenticatedUserCtrl", ["$scope", function($scope) {
    $scope.displayed = false;
    $scope.showDropDown = function() {
        if (!$scope.displayed) {
            document.getElementById("user-relative-links").classList.add("show");
            $scope.displayed = true;
        }

        else {
            var elWithShow = document.getElementsByClassName("show");
            elWithShow[0].classList.remove("show");

            $scope.displayed = false;
        }
    }
}]);