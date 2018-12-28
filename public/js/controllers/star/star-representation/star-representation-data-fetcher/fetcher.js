ktur.service("StarDataFetcher", [function() {
/*  
{
actions : {
    href: "/statements/ind-houses/5/see-stars",
    rel: "see-stars"
    },

metadata : {
    ind_house_id: "5",
    title: "Independent house for rent",
    amount_of_stars: "2"
    },

references :{
    href: "/statements/ind-houses/5",
    rel: "self"
    },
    {
    href: "/public/photos/business-logic-photos/statement-photos/admin-added-photo-1545159254.jpeg",
    rel: "image"
    }
}
*/

    this.fetchMetadata = function(jsonObject) {
        return jsonObject["metadata"];
    }

    this.fetchTitle = function(jsonObject) {
        var metadata = this.fetchMetadata(jsonObject);

        return metadata["title"];
    }

    this.fetchAmountOfStars = function(jsonObject) {
        var metadata = this.fetchMetadata(jsonObject);

        return metadata["amount_of_stars"];
    }

    this.fetchSelf = function(jsonObject) {
        return this.fetchReferenceHref(jsonObject, "self");
    }
    
    this.fetchImage = function(jsonObject) {
        return this.fetchReferenceHref(jsonObject, "image");
    }

    this.fetchSeeStars = function(jsonObject) {
        return this.fetchActionHref(jsonObject, "see-stars");
    }

    this.fetchActionHref = function(jsonObject, rel) {
        var actions = jsonObject["actions"];

        for (var i = 0; i < actions.length; i++) {
            if (actions[i]["rel"] === rel) {
                return actions[i]["href"];
            }
        }
    }

    this.fetchReferenceHref = function(jsonObject, rel) {
        var refereces = jsonObject["references"];

        for (var i = 0; i < refereces.length; i++) {
            if (refereces[i]["rel"] === rel) {
                return refereces[i]["href"];
            }
        }
    }

}]);