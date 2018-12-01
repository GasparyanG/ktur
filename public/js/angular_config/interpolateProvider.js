var appModule = angular.module("ktur", []);

appModule.config(function($interpolateProvider){
    $interpolateProvider.startSymbol("//").endSymbol("//");
});