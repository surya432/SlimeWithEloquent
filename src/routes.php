<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();
    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });
    $app->get('/koneksi', function (Request $request, Response $response, array $args) use ($container) {
        $data = new \App\Controller\TestController;
        $data->db1 = $this->db;
        $dataResponse = $data->Test();
        return $response->withJson($dataResponse)->withStatus(200);
    });
};
