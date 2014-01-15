<?php
$router = new \Phalcon\Mvc\Router();
$router->add("/hello/:name", array(
    "controller" => "hello",
    "action"     => "say",
    "name"       => 1,
));
$router->handle();
