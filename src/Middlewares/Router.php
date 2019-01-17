<?php
namespace Middlewares;

use Psr\Http\Server\MiddlewareInterface as MiddlewareInterface;
use GuzzleHttp\Psr7\ServerRequest as ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Prs\Http\Server\RequestHandlerInterface as RequestHandlerInterface;
use FastRoute;
use BusinessLogic\Dispatcher as Dispatcher;
use Response\Response as Response;

class Router implements MiddlewareInterface
{
    private $uri;

    public function __construct()
    {
        $this->uri = ServerRequest::getUriFromGlobals();
        $this->response = new Response();
    }
    
    public function process(ServerRequestInterface $request, $handler)
    {
        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r)
        {
            // HOME
            $r->addRoute("GET", "/home", "Home, getHomePage");
            // hrefs
            $r->addRoute("GET", "/home/hrefs", "Home, getPageSupportingHrefs");
            // statements
            $r->addRoute("GET", "/home/statement-resources", "Home, getStatementResources");
            
            // App supporting serrvices
            $r->addRoute("GET", "/drop-down-lists", "DropDownLists, getLists");

            $r->addRoute("GET", "/sign-up", "SignUp, getPage");
            $r->addRoute("POST", "/sign-up", "SignUp, createAccount");
            $r->addRoute("GET", "/log-in", "LogIn, getPage");
            $r->addRoute("POST", "/log-in", "LogIn, accessToAccout");
            $r->addRoute('GET', "/nav-bar", "NavBar, populateNavBar");
            $r->addRoute("GET", "/{user-name}", "User, getUser");
            $r->addRoute("GET", "/{user-name}/resources", "User, populateUser");
            
            // user page post actions
            $r->addRoute("GET", "/{user-name}/statement-addition", "PostActions, getStatementAddition");
            
            // user page get actions
            // STATEMENTS
            $r->addRoute("GET", "/{user-name}/statements", "UserStatements, getUserStatements");
            // XHR for resource return, POST is needed to receive data
            $r->addRoute("POST", "/{user-name}/statements/statements-data", "UserStatements, getResources");
            // BASKET
            $r->addRoute("GET", "/{user-name}/basket", "UserBasket, getUserBasketContent");
            // XHR for resource return, Post is needed to receive data
            $r->addRoute("POST", "/{user-name}/basket/user-basket-content", "UserBasket, getResources");
            // STARS
            $r->addRoute("GET", "/{user-name}/stars", "UserStars, getUserStatementsStars");
            // XHR for resource return, Post is needed to receive data
            $r->addRoute("POST", "/{user-name}/stars/user-statements-stars", "UserStars, getResources");

            $r->addRoute("POST", "/{user-name}/statement-addition", "PostActions, postAction");
            $r->addRoute("POST", "/{user-name}/statement-addition/add-statement-image", "FileSystemManipulation, addStatementImage");
            // get template creation important information
            $r->addRoute("GET", "/{user-name}/statement-addition/resources", "PostActions, fetchStatementAdditionInfo");
            // this aprouach may rise error try to erase navbar from calss namespace and include to Dispatcher!

            // statements
            // independent houses
            $r->addRoute("GET", "/statements/ind-houses/{ind-house-id}", "IndependentHouse, getStatement");
            // resources for page rendering XHR request
            $r->addRoute("GET", "/statements/ind-houses/{ind-house-id}/resources", "IndependentHouse, sendRequiredResourcesToClient");
            // resources for action (comment amount, star amount, basket amount, user stared state, etc.)
            $r->addRoute("GET", "/statements/{statement-type}/{unique-identifier}/action-resources", "ActorOnStatement, getActionsResources");
            
            // actions over statements
            $r->addRoute("POST", "/statements/{table-name}/{unique-identifier}/star", "ActorOnStatement, star");
            $r->addRoute("POST", "/statements/{table-name}/{unique-identifier}/basket", "ActorOnStatement, basket");
            $r->addRoute("POST", "/statements/{table-name}/{unique-identifier}/deletion", "ActorOnStatement, delete");
            // get users who stared the statement
            $r->addRoute("POST", "/statements/{table-name}/{unique-identifier}/see-stars", "ActorOnStatement, seeStars");
            // COMMENTING
            $r->addRoute("POST", "/statements/{table-name}/{unique-identifier}/comment", "ActorOnStatement, commentOnStatement");
        });

        $httpMethod = $request->getMethod();
        $uri = $this->uri->getPath();
        
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        
        if ($routeInfo[0] === FastRoute\Dispatcher::NOT_FOUND){
            $handler->handle($request);
        }

        elseif ($routeInfo[0] === FastRoute\Dispatcher::FOUND){
            $this->accessBusinessLogic($request, $routeInfo);
        }
    }

    public function accessBusinessLogic($request, $routeInfo)
    {
        $dispatcher = new Dispatcher();
        $dispatcher->dispatchToHandler($request, $this->response, $routeInfo);
    }
}