<?php
namespace Middlewares\Store;

use Psr\Http\Server\MiddlewareInterface as MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

class QueueRequestHandler implements RequestHandlerInterface
{
    private $middlewares = [];

    public function add(MiddlewareInterface $middleware) 
    {
        $this->middlewares[] = $middleware;
    }

    public function handle(ServerRequestInterface $serverRequest)
    {
        $middleware = array_shift($this->middlewares);
        // if middleware handles request then req and res cycle need to be stoped!
        $middleware->process($serverRequest, $this);
        
    }
}