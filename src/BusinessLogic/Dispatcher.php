<?php
namespace BusinessLogic;

class Dispatcher
{
    public function __construct()
    {
        $this->dirs = [
            'BusinessLogic\PageObjects',
        ];
    }

    public function dispatchToHandler($request, $routeInfo)
    {
        list($className, $methodName) = $this->getHandlerAsList($routeInfo);

        foreach($this->dirs as $dir) {
            $fullPath = $dir . "\\" . $className;
            echo $fullPath;

            if (class_exists($fullPath)) {
                $placeholders = $routeInfo[2];

                $obj = new $fullPath();
                $obj->$methodName($request, $placeholders);
                break;
            }
        }
    }

    private function getHandlerAsList($routeInfo)
    {
        $handler = $routeInfo[1];
        // i.e. class name and class's method name
        $handlerComponents = explode(",", $handler);

        $trimedHandlerComponets = [];
        foreach ($handlerComponents as $component) {
            $trimedHandlerComponet = trim($component);
            $trimedHandlerComponets[] = $trimedHandlerComponet;
        }

        return $trimedHandlerComponets;
    }
}