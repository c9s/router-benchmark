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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Phux\Mux;

$bench = new SimpleBench;
$bench->setN( 10000 );

$bench->iterate( 'symfony/routing' , function() {
    $routes = new RouteCollection();
    $routes->add('hello', new Route('/hello', array('controller' => 'foo', 'action' => 'bar' )));
    $context = new RequestContext();
    // this is optional and can be done without a Request instance
    $context->fromRequest(Request::createFromGlobals());
    $matcher = new UrlMatcher($routes, $context);
    $route = $matcher->match('/hello');
});

$bench->iterate( 'phux extension' , function() {
    $mux = require 'phux/hello_mux.php';
    $route = $mux->dispatch('/hello');
});
$result = $bench->compare();
echo $result->output('console');
