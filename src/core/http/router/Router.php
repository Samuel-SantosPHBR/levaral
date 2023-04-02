<?php

namespace App\Core\Http\Router;

use App\Core\Http\Request\Request;
use Exception;

class Router {

    private Request $request;

    private array $routes;

    public function __construct(private string $ignoreInUri = '')
    {
        $this->request = new Request;
    }

    public function get(string $path, mixed $calback) {
        $this->addRouter('GET', $path, $calback);
    }

    public function post(string $path, mixed $calback) {
        $this->addRouter('POST', $path, $calback);
    }

    private function addRouter(string $method, string $path, mixed $calback): void {
        $this->routes[$method][$path] = $calback;
    }

    private function getCorrectUri(): string {
        return str_replace($this->ignoreInUri, '', $this->request->getUri());
    }

    public function dispatch(): string {
        $routerList = $this->routes[$this->request->getHttpMethod()];

        $routeMethod = $routerList[$this->getCorrectUri()];

        if (is_callable($routeMethod)) {
            return $routeMethod($this->request);
        }

        $this->request->status(404);
        throw new Exception("Não foi possivel achar uma invocação valida para a rota {$this->getCorrectUri()}", 500);

    }
}