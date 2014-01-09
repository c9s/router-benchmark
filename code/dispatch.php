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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use pux\Mux;

$bench = new SimpleBench;
$bench->setN( 10000 );


$mux = require 'pux/hello_mux.php';
$bench->iterate( 'pux extension (dispatch)' , function() use ($mux) {
    $route = $mux->dispatch('/hello');
});

$routes = new RouteCollection();
$routes->add('hello', new Route('/hello', array('controller' => 'foo', 'action' => 'bar' )));

$bench->iterate( 'symfony/routing (dispatch)' , function() use ($routes) {
    $context = new RequestContext();
    // this is optional and can be done without a Request instance
    $context->fromRequest(Request::createFromGlobals());
    $matcher = new UrlMatcher($routes, $context);
    $route = $matcher->match('/hello');
});


$result = $bench->compare();
echo $result->output('console');
