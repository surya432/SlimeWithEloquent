<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;

class BaseController
{
    protected $container;

    public function __construct(ContainerInterface  $container)
    {
        $this->container = $container;
    }
    public function __get($name)
    {
        if ($this->container->has($name)) {
            return $this->container->get($name);
        }
    }
    public function isDebug()
    {
        if ($this->container->has('debug')) {
            return $this->container->get('debug');
        }
        return false;
    }

    public function logger()
    {
        if ($this->container->has('logger')) {
            return $this->container->get('logger');
        }
    }
    public function validator()
    {
        if ($this->container->has('validator')) {
            return $this->container->get('validator');
        }
    }
}
