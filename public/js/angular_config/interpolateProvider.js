var ktur = angular.module("ktur", []);

ktur.config(function($interpolateProvider){
    $interpolateProvider.startSymbol("//").endSymbol("//");
});