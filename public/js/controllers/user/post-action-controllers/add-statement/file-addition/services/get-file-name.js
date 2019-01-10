ktur.service("FileNameGetter", [function(){
    this.getFileName = function(url) {
        var regExp = new RegExp("\.+/([a-zA-Z0-9-]+.[a-zA-Z-]+)");
        var matches = regExp.exec(url);
        
        return matches[1];
    }
}]);