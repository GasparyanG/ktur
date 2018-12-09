<?php
namespace BusinessLogic\PostActions;

class PostActions
{
    public function __construct()
    {
        $this->clientSideData = [
            'statement-addition' => 'Statement Addition',
        ];
    }

    public function getStatementAddition($req, $res, $routeInfo)
    {
        $res->render("/user/post-actions/statement/add-statement.html", ["title" => $this->clientSideData['statement-addition']]);
    }
}