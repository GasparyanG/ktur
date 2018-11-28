<?php
namespace Response;

class TemplateEngineConfig
{
    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . "/../../resources/views");
        $this->twig = new \Twig_Environment($loader);
    }

    public function getTwig()
    {
        return $this->twig;
    }
}