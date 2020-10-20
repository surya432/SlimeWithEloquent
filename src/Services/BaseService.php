<?php

namespace App\Services;

use Psr\Container\ContainerInterface;

class BaseService
{
    protected $container;

    public function __construct(ContainerInterface  $container)
    {
        $this->container = $container;
        return;
    }
    public function __get($name)
    {
        if ($this->container->has($name)) {
            return $this->container->get($name);
        }
    }
    public function dbConnect()
    {
        if ($this->container->has('db2')) {
            return $this->container->get('db2');
        }
    }
    public function dbConnect2()
    {
        if ($this->container->has('db')) {
            return $this->container->get('db');
        }
    }
}
