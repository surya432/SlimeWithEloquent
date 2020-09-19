<?php

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
        // $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    /// koneksi database
    // $container['db'] = function ($c) {
    //     $settings = $c->get('settings')['db'];
    //     $server = $settings['driver'] . ":host=" . $settings['host'] . ";port=" . $settings['port'] . ";dbname=" . $settings['database'];
    //     $conn = new PDO($server, $settings["username"], $settings["password"]);
    //     $conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_EXCEPTION);
    //     $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    //     return $conn;
    // };
    $container['db'] = function ($container) {
        $settings = $container->get('settings');
        $config = [
            'driver' => 'mysql',
            'host' => $settings['db']['host'],
            'database' => $settings['db']['database'],
            'username' => $settings['db']['username'],
            'password' => $settings['db']['password'],
            'charset'  => $settings['db']['charset'],
            'collation' => $settings['db']['collation'],
            'port' => $settings['db']['port'],
            'prefix' => '',
        ];
        $capsule2 = new \Illuminate\Database\Connectors\ConnectionFactory(new \Illuminate\Container\Container());
        $capsule2 = $capsule2->make($config);
        return $capsule2;
    };
};
