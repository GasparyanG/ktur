ktur.service("StatementDataFetcher", [function() {
    /**
     * [
     * actions : [
     *      {
     *          href : sth,
     *          rel : star
     *      },
     *      {
     *          href : sth,
     *          rel : basket
     *      },
     *      {
     *          href : sth,     
     *          rel : comment
     *      }
     * ],
     * 
     * metadata : {
     *          option_over : rent|sell,
     *          price : int,
     *          title : string
     * },
     * 
     * references : [
     *          {
     *              href : sth;
     *              rel : image
     *          },
     *          {
     *              href : sth,
     *              rel : self
     *          }
     * ]
     * ]
     */

    this.fetchImage = function(arrayOfRequiredData) {
        var references = arrayOfRequiredData['references'];

        for (var i = 0; i < references.length; i++) {
            if (references[i].rel === "image") {
                return references[i].href;
            }
        }
    }

    this.fetchSelf = function(arrayOfRequiredData) {
        var references = arrayOfRequiredData['references'];

        for (var i = 0; i < references.length; i++) {
            if (references[i].rel === "self") {
                return references[i].href;
            }
        }
    }

    this.fetchStar = function(arrayOfRequiredData) {
        return this.actionFetcher(arrayOfRequiredData, "star");
    }

    this.fetchBasket = function(arrayOfRequiredData) {
        return this.actionFetcher(arrayOfRequiredData, "basket");
    }

    this.fetchComment = function(arrayOfRequiredData) {
        return this.actionFetcher(arrayOfRequiredData, "comment");
    }

    this.actionFetcher = function(arrayOfRequiredData, relation) {
        var actions = arrayOfRequiredData['actions'];

        for (var i = 0; i < actions.length; i++) {
            if (actions[i].rel = relation) {
                return actions[i].href;
            }
        }
    }

    this.fetchAction = function(arrayOfRequiredData) {
        return arrayOfRequiredData['actions'];
    }

    // metadata 
    this.fetchTitle = function(arrayOfRequiredData) {
        var metadata = this.fetchMetadata(arrayOfRequiredData);

        return metadata['title'];
    }

    this.fetchPrice = function(arrayOfRequiredData) {
        var metadata = this.fetchMetadata(arrayOfRequiredData);

        return metadata['price'];
    }

    this.fetchOption = function(arrayOfRequiredData) {
        var metadata = this.fetchMetadata(arrayOfRequiredData);

        return metadata['option_over'];
    }

    this.fetchMetadata = function(arrayOfRequiredData) {
        return arrayOfRequiredData['metadata']
    }
}]);