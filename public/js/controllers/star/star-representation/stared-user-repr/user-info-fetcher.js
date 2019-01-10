ktur.service("UserInfoFetcher", [function() {
    /* 
    metadata : {
        href: "/Gasparyan", 
        rel: "self", 
        data: "Gasparyan"
    }
     */
    this.fetchMetadata = function(userInfo) {
        return userInfo["metadata"];
    }

    this.fetchSelf = function(currentUserInfo) {
        return currentUserInfo['href'];
    }

    this.fetchUsername = function(currentUserInfo) {
        return currentUserInfo['data'];
    }
}]);