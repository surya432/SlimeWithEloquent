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

        $app->group('/books', function () use ($app) {
            $app->get('', \App\Controller\BooksController::class . ':index');
            $app->post('', \App\Controller\BooksController::class . ':create');
            $app->get('/{id}', \App\Controller\BooksController::class . ':show');
            $app->post('/books/{id}', \App\Controller\BooksController::class . ':edit');
            $app->delete('', \App\Controller\BooksController::class . ':delete');
        });
    });
};
