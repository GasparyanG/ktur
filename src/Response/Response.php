<?php
namespace Response;

class Response
{
    public function __construct()
    {
        $this->templateEngineConfig = "Response\TemplateEngineConfig";

        $this->twig = $this->getTwigEnvironment();
    }

    public function getTwigEnvironment()
    {
        $twigEnv = new $this->templateEngineConfig();

        $twig = $twigEnv->getTwig();

        return $twig;
    }

    public function render($file, $arrayOfValues = null)
    {
        echo $this->twig->render($file, $arrayOfValues);
    }

    public function redirect($path)
    {
        // path MUST be full!
        header("Location: $path");
    }
}