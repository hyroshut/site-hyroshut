<?php

namespace Hyroshut\Controllers;

use Slim\Container;

abstract class BaseController
{
    public function __construct($container)
    {
        /** @var Container container */
        $this->container = $container;
    }

    public function render($response, $view, $folder = "pages", $data = []) {
        $this->container->view->render($response, "{$folder}/{$view}.twig", $data);
    }
}