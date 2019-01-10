ktur.service('TemplateResources', ["$http", function($http) {
    this.pathsToGetResources = {
        'mainResources' : window.location + '/resources',
    }

    this.getResources = function(scope) {
        $http({
            method: "GET",
            url: this.pathsToGetResources['mainResources']
        }).then(function successCallback(response) {
            console.log(response.data);
            scope.resourcesForTamplate = response.data;
        }, function errorCallback(response) {
            console.log("error from /main-action-controllers/serives/post-actions/add-statement/template-resources,js")
        });
    }
}]);