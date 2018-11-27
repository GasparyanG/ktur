<?php
namespace DataBase\Implementations;

trait Common
{
    public function getMethodName($methodNames, $flag)
    {
        $upperFlag = strtoupper($flag);

        if (isset($methodNames[$upperFlag])) {
            $methodName = $methodNames[$upperFlag];
            return $methodName;
        }
    }
}