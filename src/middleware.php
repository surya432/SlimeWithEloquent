<?php

use App\Midleware\TokenAuth;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    // e.g: $app->add(new \Slim\Csrf\Guard);
    $container = $app->getContainer();
    ///log auto
    $app->add(function (Request $request, Response $response, $next) use ($container) {
        $route = $request->getAttribute('route');
        $arguments = $route->getArguments() ? $route->getArguments() : null;
        $data = json_decode($request->getBody()) ? json_encode(json_decode($request->getBody(), true)) : null;
        $container->get('logger')->addInfo("Akses " . $route->getName(), ["args" => $arguments, "body" => $data]);
        $response = $next($request, $response);
        return $response;
    });
};
