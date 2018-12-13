ktur.controller("ImageUpload", ['$scope', '$http', function($scope, $http) {
    $scope.triggerFileUploader = function() {
        document.getElementById("imageUpload").click();
    }

    $scope.uploadFile = function() {
        var formData = new FormData();
        var fileInput = document.getElementById('imageUpload');
        formData.append('statementImageInput', fileInput.files[0]);
        $http({
            method: "POST",
            url: window.location.href + "/add-statement-image",
            data: formData,
            headers: {
                // browser will automatically set required Contetn-Type for us
                'Content-Type': undefined
            }
        }).then(function successCallback(response) {
            console.log(response.data);
        }, function errorCallback(response) {
            console.log("error");
        })
    }
}]);