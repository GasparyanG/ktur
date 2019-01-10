ktur.service("StaredUsersRendering", ['UserInfoFetcher', function(UserInfoFetcher) {
    this.showStaredUsers = function(usersData, url) {
        var metadata = UserInfoFetcher.fetchMetadata(usersData);
        
        var staredUsersSection = this.createDivForStaredUsers();
        for (var i = 0; i < metadata.length; i++) {
            var currentUserInfo = metadata[i];
            var href = UserInfoFetcher.fetchSelf(currentUserInfo);
            var username = UserInfoFetcher.fetchUsername(currentUserInfo);
            
            var userRepresentingElement = this.createDivElementWithUserInfo(href, username);
            staredUsersSection.appendChild(userRepresentingElement);
        }

        var parentOfActoinEl = this.getElementsParent(url);
        parentOfActoinEl.appendChild(staredUsersSection);
    }

    this.createDivElementWithUserInfo = function(href, username) {
        var divEl = document.createElement('div');
        var anchor = document.createElement('a');
        anchor.href = href;
        var textEl = this.textElement(username);
        anchor.appendChild(textEl);
        divEl.appendChild(anchor);

        return divEl;        
    }

    this.textElement = function(text) {
        var textEl = document.createTextNode(text);
        return textEl;
    }

    this.getElementsParent = function(className) {
        var elements = document.getElementsByClassName(className);
        element = elements[0];

        return element.parentNode;
    }

    this.createDivForStaredUsers = function() {
        var divEl = document.createElement('div');
        divEl.classList.add("stared-users");

        return divEl;
    }
}]);