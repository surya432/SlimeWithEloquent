<?php

use App\Midleware\TokenAuth;
use Slim\App;

return function (App $app) {
    // e.g: $app->add(new \Slim\Csrf\Guard);
    // $app->add(function ($request, $response, $next) {
    //     // add media parser
    //     $request->registerMediaTypeParser(
    //         "text/javascript",
    //         function ($input) {
    //             return json_decode($input, true);
    //         }
    //     );

    //     return $next($request, $response);
    // });
};
