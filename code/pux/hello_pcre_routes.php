<?php
// pux has zero dependency, so we even don't use composer autoloader.
use Pux\Mux;
$mux = new Mux;
$mux->add('/hello/:name', ['HelloController','helloAction']);
return $mux;
