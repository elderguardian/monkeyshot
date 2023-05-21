<?php

class Router
{
    private array $routes;


    function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    private function executeMiddlewares(array $middlewares, IKernel $diContainer): void
    {
        foreach ($middlewares as $middleware) {
            $passes = (new $middleware)->canPass($diContainer);

            if (!$passes) {
                die;
            }
        }
    }

    function route(): void
    {
        $path = $_GET["path"] ?? '';
        $pathChars = str_split($path);
        $lastChar = array_pop($pathChars);

        if ($lastChar === '/') {
            $lastChar = '';
        }

        $path = implode($pathChars) . $lastChar;

        if (!array_key_exists("/{$path}", $this->routes)) {
            $path = 'error';
        }

        $routerResult = $this->routes["/" . $path];

        if (is_array($routerResult)) {
            $controllerName = $routerResult[0];
            $actionName = $routerResult[1];
            $middlewares = $routerResult[2] ?? '';
            $diContainer = new Kernel();

            if (is_array($middlewares)) {
                $this->executeMiddlewares($middlewares, $diContainer);
            }

            echo (new $controllerName)->$actionName($diContainer);
        } else {
            echo $routerResult();
        }
    }


}