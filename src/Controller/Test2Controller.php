<?php

namespace App\Controller;


class TestController extends BaseController
{
    public $db1;
    public function Test()
    {
        return $this->jsonRespond($this->db1->table('users')->first(), "OK");
    }
}
