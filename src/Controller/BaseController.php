<?php

namespace App\Controller;


use Slim\Http\Request;
use Slim\Http\Response;

class BaseController
{
    function jsonRespond($result = [], $massage)
    {
        if ($massage != "OK") {
            $data = array('status' => false, "data" => [], "message" => $massage);
        } else {
            $data = array('status' => true, "data" => $result, "message" => 'OK');
        }
        return $data;
    }
}
