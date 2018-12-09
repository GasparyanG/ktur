var ktur = angular.module("ktur", ["ngRoute"]);

ktur.config(function($interpolateProvider){
    $interpolateProvider.startSymbol("//").endSymbol("//");
});