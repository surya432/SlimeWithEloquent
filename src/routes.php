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
        $app->post('/login', \App\Controller\AuthController::class . ':login')->setName("login");
        $app->post('/signup', \App\Controller\AuthController::class . ':signup')->setName("register");
        $app->post('/changePassword/{id}', \App\Controller\AuthController::class . ':changePassword')->setName("changePassword");

        $app->group('/books', function () use ($app) {
            $app->get('', \App\Controller\BooksController::class . ':index')->setName("indexBooks");
            $app->get('/exportcsv', \App\Controller\BooksController::class . ':exportcsv')->setName("exportExcelAllBooks");
            $app->post('', \App\Controller\BooksController::class . ':create')->setName("createBooks");
            $app->get('/{id}', \App\Controller\BooksController::class . ':show')->setName("showBooks");
            $app->post('/{id}', \App\Controller\BooksController::class . ':edit')->setName("editBooks");
            $app->delete('', \App\Controller\BooksController::class . ':delete')->setName("deleteBooks");
        });

        $app->group('/author', function () use ($app) {
            $app->get('', \App\Controller\AuthorController::class . ':index')->setName("indexAuthor");
            $app->post('', \App\Controller\AuthorController::class . ':create')->setName("createAuthor");
            $app->get('/{id}', \App\Controller\AuthorController::class . ':show')->setName("showAuthor");
            $app->post('/{id}', \App\Controller\AuthorController::class . ':edit')->setName("editAuthor");
            $app->delete('', \App\Controller\AuthorController::class . ':delete')->setName("deleteAuthor");
        });
    });
};
