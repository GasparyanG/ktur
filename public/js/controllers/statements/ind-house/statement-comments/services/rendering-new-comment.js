ktur.service("NewCommentRepr", ["CommentSpecificFetcher", function(CommentSpecificFetcher) {
    this.repr = function(requiredData) {
        var parentElement = this.getMainElement();
        var commentBox = this.createDivWithClassName("individual-comments");
        // user repr
        var userRepresentation = this.createUserRepr(requiredData);
        commentBox.appendChild(userRepresentation);
        // comment section
        var commentSection = this.createCommentSection(requiredData);
        commentBox.appendChild(commentSection);

        parentElement.prepend(commentBox);
    }

    this.getMainElement = function() {
        return document.getElementById("actual-comments");
    }

    this.createDivWithClassName = function(className) {
        var div = document.createElement("div");
        div.classList.add(className);
        
        return div;
    }

    this.createUserRepr = function(requiredData) {
        var userReprDiv = this.createDivWithClassName("user-repr");
        var imageDiv = this.createDivWithClassName("image");
        
        var imgEl = document.createElement("img");
        imgEl.src = CommentSpecificFetcher.fetchImagePathData(requiredData)["href"];

        imageDiv.appendChild(imgEl);
        userReprDiv.appendChild(imageDiv);

        return userReprDiv;
    }

    this.createCommentSection = function(requiredData) {
        var commentSectionMainEl = this.createDivWithClassName("comment");
        var userDataDiv = this.createDivWithClassName("username");
        var userReferenceEl = this.createUserReferenceDiv(requiredData);

        userDataDiv.appendChild(userReferenceEl);
        commentSectionMainEl.appendChild(userDataDiv);

        // time
        var timeDiv = this.createDivWithClassName("time");
        var spanEl = document.createElement("span");
        var currentTime = this.getTime();
        var textEl = this.createTextElWithContent("Added In: " + currentTime);

        spanEl.appendChild(textEl);
        timeDiv.appendChild(spanEl);
        userDataDiv.appendChild(timeDiv);

        var actualCommentEl = this.prepareCommentEl(requiredData);
        commentSectionMainEl.appendChild(actualCommentEl);

        return commentSectionMainEl;
    }

    this.createUserReferenceDiv = function(requiredData) {
        var divEl = document.createElement("div");
        var anchorEl = document.createElement("a");

        var referenceHoldingObject = CommentSpecificFetcher.fetchUserData(requiredData);
        var reference = referenceHoldingObject["href"];
        anchorEl.href = reference;
        anchorEl.append(this.createTextEl(requiredData));

        divEl.appendChild(anchorEl);

        return divEl;
    }

    this.createTextEl = function(requiredData) {
        return document.createTextNode(CommentSpecificFetcher.fetchUsername(requiredData));
    }

    this.createTextElWithContent = function(content) {
        return document.createTextNode(content);
    }

    this.getTime = function()
    {
        return Date();
    }

    this.prepareCommentEl = function(requiredData) {
        var comment = CommentSpecificFetcher.fetchComment(requiredData);
        var commentDivEl = this.createDivWithClassName("actual-comment");

        var textEl = this.createTextElWithContent(comment);
        commentDivEl.appendChild(textEl);

        return commentDivEl;
    }
}]);