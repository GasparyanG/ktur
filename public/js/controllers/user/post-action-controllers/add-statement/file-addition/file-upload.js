ktur.controller("ImageUpload", ['$scope', '$http', 'FilesStateManipulator', function($scope, $http, FilesStateManipulator) {
    $scope.triggerFileUploader = function() {
        document.getElementById("imageUpload").click();
    }

    $scope.uploadFile = function() {
         var formData = new FormData();
         var fileInput = document.getElementById('imageUpload');
         // form/mapper.php
         formData.append('statementImageUpload', fileInput.files[0]);
         $http({
             method: "POST",
             url: window.location.href + "/add-statement-image",
             data: formData,
             headers: {
                 // browser will automatically set required Contetn-Type for us
                'Content-Type': undefined
            }
        }).then(function successCallback(response) {
            FilesStateManipulator.addToTableListAndShow(response.data);
            console.log(response.data);
        }, function errorCallback(response) {
            console.log("error");
        })
    }

    $scope.removeImage = function(fileName) {
        console.log(fileName);
        FilesStateManipulator.removeImage(fileName);
    }
}]);