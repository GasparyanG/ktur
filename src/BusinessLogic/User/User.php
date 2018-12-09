<?php
namespace BusinessLogic\User;

use DataBase\DBSpecificRequests\User\UserDataFetcher as UserDataFetcher;
use Augmention\Convertion\JsonConverter as JsonConverter;
use RESTfull\HATEOSA\JsonPrepareness as JsonPrepareness;
use RESTfull\HATEOSA\HateSupporter as HateSupporter;

class User
{
    public function __consturct()
    {
        $this->dataForClient = [
        ];
    }

    public function getUser($req, $res, $routeInfo)
    {
        $cookies = $req->getCookieParams();
        $username = $cookies['username'];

        $res->render('/user/user.html', ['title' => $username]);
    }

    /** 
     * response to ajax call by obaying to RESTful API
     * more specifically to HATEOAS :
     * 
     * 1) user image uri
     * 
     * returned MUST be in json format!
     */
    public function populateUser($req, $res, $routeInfo)
    {
        $username = $routeInfo['user-name'];

        // objects to rely on
        $userDataFetcher = new UserDataFetcher();
        $jsonConverter = new JsonConverter();
        $jsonPrepareness = new JsonPrepareness();
        $hateSupporter = new HateSupporter();


        // add all data to this array to convert to json for client
        $dataToSendToClient = [];

        $userImageFileName = $userDataFetcher->fetchImageFileName($username);
        
        $defaultUserImageServingPath = $hateSupporter->combinePathSegments(['photos', 'user', 'default'], $userImageFileName['user_image']);
        $jsonPreparedHrefAndRel = $jsonPrepareness->makeHrefRestfull($defaultUserImageServingPath, "user_image");
        $dataToSendToClient['user'][] = [$jsonPreparedHrefAndRel];

        $statementAdditionPath = $hateSupporter->combinePathSegments(['actions', 'post-actions', 'add-statement'], $username, true);
        $jsonPreparedStatement = $jsonPrepareness->makeHrefRestfull($statementAdditionPath, "add-statement");
        $dataToSendToClient['user'][] = [$jsonPreparedStatement];

        echo $jsonConverter->convertArrayToJson($dataToSendToClient);
    }
}