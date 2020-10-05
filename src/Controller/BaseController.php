<?php
namespace App\Controller;
use Psr\Container\ContainerInterface;
class BaseController {
protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
}