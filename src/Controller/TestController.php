<?php

namespace App\Controller;

use \App\Model\TutorialModel as TutorialModel;

class TestController extends BaseController
{
    public function index($request,$response){
        $this->container->get('logger')->addInfo('Request: users->get-one');
        return $response->withJson(TutorialModel::Popular());
    }
    
    public function show($request,$response,$arg){
        $this->container->get('logger')->addInfo('Request: users->get-one');
        return $response->withJson(TutorialModel::where($arg)->first());
    }
}
