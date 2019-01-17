var ktur = angular.module("ktur", ["ngRoute"]);
ktur.config(function($interpolateProvider, $locationProvider){
    $locationProvider.hashPrefix('');
    $interpolateProvider.startSymbol("//").endSymbol("//");
});