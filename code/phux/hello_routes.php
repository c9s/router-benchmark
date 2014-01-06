<?php
// phux has zero dependency, so we even don't use composer autoloader.
use Phux\Mux;
$mux = new Mux;
$mux->add('/hello', ['HelloController','helloAction']);
return $mux;