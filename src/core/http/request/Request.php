<?php

namespace App\Core\Http\Request;

class Request {
    private readonly array $headers;
    private readonly string $method;
    private readonly array $params;
    private readonly array $body;
    private readonly string $uri;

    public function __construct()
    {
        $this->headers = getallheaders();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->params = $_GET;
        $this->body = $this->getBodyRequest();
        $this->uri = $this->getCorretUri();
    }

    private function getCorretUri(): string {
        return explode('?', $_SERVER['REQUEST_URI'])[0];
    }

    private function getBodyRequest() {
        $body = [];

        $hastPost = count($_POST ?? []) > 0;

        $inputJson = file_get_contents('php://input');
        $inputJsonToArray = json_decode($inputJson, true);

        $hastInput = count($inputJsonToArray ?? []) > 0;
        
        $body = $this->returnArrayMerge($hastPost, [$body, $_POST]);
        $body = $this->returnArrayMerge($hastInput, [$body, $inputJsonToArray]);

        return $body;
    }

    private function returnArrayMerge($hasValue, $arraysToMerge) {
        if ($hasValue)
            return array_merge($arraysToMerge[0], $arraysToMerge[1]);
        return $arraysToMerge[0];
    }

    public function getParams(string $key = null): array | string {
        return isset($key) ? $this->params[$key] : $this->params;
    }

    public function getBody(string $key = null): array | string {
        return isset($key) ? $this->body[$key] : $this->body;
    }

    public function getHeaders(string $key = null): array | string {
        return isset($key) ? $this->headers[$key] : $this->headers;
    }

    public function getUri(): string {
        return $this->uri;
    }

    public function getHttpMethod(): string {
        return $this->method;
    }

    public function status($httpCode): void {
        http_response_code($httpCode);
    }
}