ktur.controller("ImageUpload", ['$scope', '$http', 'AddingToDom', function($scope, $http, AddingToDom) {
    $scope.filesState = {
        "deleteAll" : true,
        "deleteFrom" : [],
        "saveTo" : []
    };

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
            $scope.addToTableListAndShow(response.data);
            console.log(response.data);
        }, function errorCallback(response) {
            console.log("error");
        })
    }

    $scope.addToTableListAndShow = function(dataFromResponse) {
        var fileName = dataFromResponse[0]["data"];
        $scope.filesState.saveTo.push(fileName);
        console.log($scope.filesState);

        AddingToDom.showInView(dataFromResponse, $scope);
    }

    $scope.removeImage = function(fileName) {
        $scope.filesState.deleteFrom.push(fileName);
        // this dose not need to be saved in table!
        $scope.removeFromSaveToArray(fileName);
        AddingToDom.removeFromDom(fileName);
    }

    $scope.removeFromSaveToArray = function(fileName) {
        var indexOfItem = $scope.filesState.saveTo.indexOf(fileName);
        $scope.filesState.saveTo.splice(indexOfItem, 1);
    }
}]);