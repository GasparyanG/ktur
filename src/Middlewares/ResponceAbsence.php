<?php
namespace Middlewares;

use Psr\Http\Server\MiddlewareInterface as MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandlerInterface;

class ResponceAbsence implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, $handler)
    {
        echo "Not found: 404";
    }
}