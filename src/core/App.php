<?php

namespace App\Core;

use App\Core\Http\Router\Router as RouterRouter;
use Exception;

class App {

    private RouterRouter $routes;



    public function addRoutes(RouterRouter $routes): void {
        $this->routes = $routes;
    }

    public function execute(): void {
        $buffer = '';
        
        try {
            $buffer = $this->routes->dispatch();
        } catch (Exception $error) {
            $buffer = "Houve um erro inesperado {$error->getMessage()}";
        }

        echo $buffer;
    }
}