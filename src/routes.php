<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();
    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    $app->group('/api', function () use ($app) {
        $app->get('/tutorial','\App\Controller\TestController:index');
        $app->get('/tutorial/{id}[/{notlp}]','\App\Controller\TestController:show');
    });
};
