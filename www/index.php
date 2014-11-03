<?php

include __DIR__ . '/../vendor/autoload.php';


use Vector\Silex\Application;

$app = new Application();
$app['debug'] = true;
$mongo= $app['mongo.factory']('mongodb://localhost:27017')->selectDB('vector');
$app['vectordb'] = $app['mongo.factory']('mongodb://localhost:27017')->selectDB('vector');



$app->get('/api/v1/info', function (Application $app) {
    return $app->json([
        'status' => 'active',
        'info'   => [
            'version'    => 'v1',
            'creation' => '2014'
        ]]);
});



$app->get('/api/v1/writers/{id}', function (Application $app, $id) use ($mongo){



});







$app->run();