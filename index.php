<?php
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/app/AppHttpKernel.php';

umask(0000);

$dotenv = new Dotenv\Dotenv(__DIR__ . '/app/');
$dotenv->load();

$debug = $_ENV['DEBUG'];
$env = $_ENV['ENV'];

if($debug){
    Debug::enable();
}

$kernel = new AppHttpKernel($env, $debug);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
