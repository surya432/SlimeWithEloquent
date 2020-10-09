<?php

namespace App\Midleware;

use Slim\Http\Request;
use Slim\Http\Response;

class TokenAuth
{
    private $container;
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, $response, $next)
    {
        
    }
}
