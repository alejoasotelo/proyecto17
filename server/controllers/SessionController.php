<?php

namespace Controllers;

use Slim\Container;

class SessionController{

    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }
   
   public function __invoke($request, $response) {
    var_dump($response);
    die();
        // your code
        // to access items in the container... $this->container->get('');
        return $response;
   }

    public function login($request, $response, $args) {
        return $response;
    }

    public function register($request, $response, $args) {
        return $response;
    }

}