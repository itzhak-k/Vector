<?php

include __DIR__ . '/../vendor/autoload.php';


use Vector\Silex\Application;
use Silex\Provider\HttpCacheServiceProvider;
use Vector\Silex\Provider\Tokenizer\TokenServiceProvider;

$app = new Application();
$app['debug'] = true;
$app['vectordb'] = $app['mongo.factory']('mongodb://localhost:27017')->selectDB('vector');

$app[TokenServiceProvider::TOKENS_LOAD](new \MongoCollection($app['vectordb'], 'clients'));

$app->register(new HttpCacheServiceProvider(), array("http_cache.cache_dir" => "../storage/cache",));

$app->run();