ktur.controller('MainActionCtrl',  ['$scope','TemplateResources', function($scope, TemplateResources) {
    TemplateResources.getResources($scope);
}]);