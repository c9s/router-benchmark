<?php return Pux\Mux::__set_state(array(
   'id' => NULL,
   'routes' => 
  array (
    0 => 
    array (
      0 => true,
      1 => '#^    /hello
    /(?P<name>[^/]+?)
$#xs',
      2 => 
      array (
        0 => 'HelloController',
        1 => 'helloAction',
      ),
      3 => 
      array (
        'regex' => '    /hello
    /(?P<name>[^/]+?)
',
        'compiled' => '#^    /hello
    /(?P<name>[^/]+?)
$#xs',
        'pattern' => '/hello/:name',
      ),
    ),
  ),
   'routesById' => 
  array (
  ),
   'staticRoutes' => 
  array (
  ),
   'submux' => 
  array (
  ),
   'expand' => true,
)); /* version */