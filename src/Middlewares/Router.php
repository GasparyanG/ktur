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
            $r->addRoute("GET", "/sign-up", "SignUp, getPage");
            $r->addRoute("POST", "/sign-up", "SignUp, createAccount");
            $r->addRoute("GET", "/log-in", "LogIn, getPage");
            $r->addRoute("POST", "/log-in", "LogIn, accessToAccout");
            $r->addRoute("GET", "/{user-name}", "User, getUser");
            $r->addRoute("GET", "/{user-name}/resources", "User, populateUser");
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