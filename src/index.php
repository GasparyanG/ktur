<?php
require __DIR__ . "/../vendor/autoload.php";

use GuzzleHttp\Psr7\ServerRequest as ServerRequest;

$queueRequestHandler = new Middlewares\Store\QueueRequestHandler();

$queueRequestHandler->add(new Middlewares\Router());
$queueRequestHandler->add(new Middlewares\ResponceAbsence());

$queueRequestHandler->handle(ServerRequest::fromGlobals());