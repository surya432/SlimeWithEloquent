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
        $app->post('/login', \App\Controller\AuthController::class . ':login');
        $app->post('/signup', \App\Controller\AuthController::class . ':signup');
        $app->post('/changePassword/{id}', \App\Controller\AuthController::class . ':changePassword');

        $app->group('/books', function () use ($app) {
            $app->get('', \App\Controller\BooksController::class . ':index');
            $app->get('/exportcsv', \App\Controller\BooksController::class . ':exportcsv');
            $app->post('', \App\Controller\BooksController::class . ':create');
            $app->get('/{id}', \App\Controller\BooksController::class . ':show');
            $app->post('/{id}', \App\Controller\BooksController::class . ':edit');
            $app->delete('', \App\Controller\BooksController::class . ':delete');
        });

        $app->group('/author', function () use ($app) {
            $app->get('', \App\Controller\AuthorController::class . ':index');
            $app->post('', \App\Controller\AuthorController::class . ':create');
            $app->get('/{id}', \App\Controller\AuthorController::class . ':show');
            $app->post('/{id}', \App\Controller\AuthorController::class . ':edit');
            $app->delete('', \App\Controller\AuthorController::class . ':delete');
        });
    });
};
