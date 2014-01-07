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
use Pux\Mux;

$bench = new SimpleBench;
$bench->setN(5000);

$mux = new Mux;
$mux->add('/product/:id', [ 'ProductController' , 'index' ]);
$bench->iterate( 'pux extension (dispatch)' , function() use ($mux) {
    $route = $mux->dispatch('/product/23');
});

$routes = new RouteCollection();
$routes->add('product', new Route('/product/{id}', array('controller' => 'foo', 'action' => 'bar' )));

$bench->iterate( 'symfony/routing (dispatch)' , function() use ($routes) {
    $context = new RequestContext();
    // this is optional and can be done without a Request instance
    $context->fromRequest(Request::createFromGlobals());
    $matcher = new UrlMatcher($routes, $context);
    $route = $matcher->match('/product/23');
});


$result = $bench->compare();
echo $result->output('console');
