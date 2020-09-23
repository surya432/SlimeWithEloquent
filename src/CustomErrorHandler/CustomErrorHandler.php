<?php

namespace App\CustomErrorHandler;

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Exception;

class CustomHandler
{
    public function __invoke($request, $response, $exception)
    {
        return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('Something went wrong!');
    }
}
