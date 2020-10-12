<?php

use App\Handlers\CustomError;
use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    /// koneksi database
    // $container['db2'] = function ($c) {
    //     $settings = $c->get('settings')['db'];
    //     $server = $settings['driver'] . ":host=" . $settings['host'] . ";port=" . $settings['port'] . ";dbname=" . $settings['database'];
    //     $conn = new PDO($server, $settings["username"], $settings["password"]);
    //     $conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_EXCEPTION);
    //     $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    //     return $conn;
    // };

    // validasi setting
    $container['validator'] = function () {
        return new \Awurth\SlimValidation\Validator();
    };

    //error custom json
    $container['errorHandler'] = function ($container) {
        return function ($request, $response, $exception) use ($container) {
            // retrieve logger from $container here and log the error
            $container->logger->addCritical('Unhandled Exception: ' . $exception->getMessage());
            $response->getBody()->rewind();
            return $response->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(array(
                    "status" => false,
                    'message' => $exception->getMessage(),
                    "line" => $exception->getLine()
                )));
        };
    };

    $container['phpErrorHandler'] = function ($container) {
        return function ($request, $response, $exception) use ($container) {
            $container->logger->addCritical('Unhandled Exception: ' . $exception->getMessage());
            // retrieve logger from $container here and log the error
            $response->getBody()->rewind();
            return $response->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(array(
                    "status" => false,
                    'message' => $exception->getMessage(),
                    "line" => $exception->getLine()
                )));
        };
    };

    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    //use 2 or more connection database
    // $capsule->addConnection($container['settings']['db2'], 'db2');
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    // $container['db'] = function ($container) use ($capsule) {
    //     //container for Database Eloquent

    //     return $capsule;
    // };
};
