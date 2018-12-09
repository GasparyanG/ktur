ktur .config(function ($routeProvider, $locationProvider) {
    $locationProvider.hashPrefix('');
    $routeProvider
    .when("/add-statement", {
        templateUrl: "/resources/views/user/post-actions/statement/add-statement.html",
    }).when("/statements", {
        templateUrl: "/resources/views/user/get-actions/statement/user-statements.html",
    });
});