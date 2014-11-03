<?php

include __DIR__ . '/../vendor/autoload.php';


use Vector\Silex\Application;
use Silex\Provider\HttpCacheServiceProvider;

$app = new Application();
$app['debug'] = true;
$app['vectordb'] = $app['mongo.factory']('mongodb://localhost:27017')->selectDB('vector');

$app->register(new HttpCacheServiceProvider(), array("http_cache.cache_dir" => "../storage/cache",));


$app->run();