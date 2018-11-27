<?php
namespace Middlewares;

use Psr\Http\Server\MiddlewareInterface as MiddlewareInterface;
use GuzzleHttp\Psr7\ServerRequest as ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Prs\Http\Server\RequestHandlerInterface as RequestHandlerInterface;
use FastRoute;
use BusinessLogic\Dispatcher as Dispatcher;

class Router implements MiddlewareInterface
{
    private $uri;

    public function __construct()
    {
        $this->uri = ServerRequest::getUriFromGlobals();
    }

    public function process(ServerRequestInterface $request, $handler)
    {
        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r)
        {
            $r->addRoute("GET", "/users/{id: \d+}/picks/{pickId: \d+}", "Home, getHome");
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
        $dispatcher->dispatchToHandler($request, $routeInfo);
    }
}