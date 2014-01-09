<?php
// http://github.com/c9s/php-SimpleBench.git
require 'SimpleBench/Task.php';
require 'SimpleBench/Utils.php';
require 'SimpleBench/ComparisonMatrix.php';
require 'SimpleBench/MatrixWriter/Writer.php';
require 'SimpleBench/MatrixWriter/JsonWriter.php';
require 'SimpleBench/MatrixPrinter/EzcGraph.php';
require 'SimpleBench/MatrixPrinter/Console.php';
require 'SimpleBench/SystemInfo/Darwin.php';
require 'SimpleBench.php';

// requirement from symfon
require 'symfony/vendor/autoload.php';
require 'pux/PatternCompiler.php';
require 'klein/vendor/autoload.php';
require 'ham/ham/ham/ham.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use pux\Mux;

$bench = new SimpleBench;
$bench->setN( 10000 );

// plain php dispatch function
$phparray = array( 
    '/hello' => array( 'hello' )
);
function phparray_dispatch($path) {
    global $phparray;
    if ( isset($phparray[$path]) ) {
        return $phparray[$path];
    }
    foreach( $phparray as $pattern => $route ) {
        if ( preg_match('#' . $pattern . '#', $path) ) {
            return $route;
        }
    }
}
$bench->iterate( 'php array' , function() use ($phparray) {
    $route = phparray_dispatch('/hello');
});


$mux = require 'pux/hello_mux.php';
$bench->iterate( 'pux' , function() use ($mux) {
    $route = $mux->match('/hello');
});







// klein
$klein = new \Klein\Klein();
$klein->respond('GET', '/hello', function () {
    return 'hello';
});

$bench->iterate( 'klein' , function() use ($klein) {
    $klein->dispatch();
});



// ham
$_SERVER['REQUEST_URI'] = '/hello';
$ham = new Ham('example');
$ham->route('/hello', function($ham) {
});
$bench->iterate( 'ham' , function() use ($ham) {
    $ham->run();
});


// aura
$aura = require 'aura/aura/scripts/instance.php';
$aura->add('hello', '/hello');
$bench->iterate( 'aura' , function() use ($aura) {
    $route = $aura->match('/hello', $_SERVER);
});

// Symfony

$routes = new RouteCollection();
$routes->add('hello', new Route('/hello', array('controller' => 'foo', 'action' => 'bar' )));

$bench->iterate( 'symfony/routing' , function() use ($routes) {
    $context = new RequestContext();
    // this is optional and can be done without a Request instance
    $context->fromRequest(Request::createFromGlobals());
    $matcher = new UrlMatcher($routes, $context);
    $route = $matcher->match('/hello');
});


$result = $bench->compare();
echo $result->output('console');
