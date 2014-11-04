<?php

namespace Vector\Silex;

use Silex\Application as SilexApplication;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vector\Silex\Provider\Router\RouterBuilder;
use Vector\Silex\Provider\Auth\AuthBuilder;
use Vector\Silex\Provider\Mongo\MongoBuilder;
use Vector\Silex\Provider\Tokenizer\TokenBuilder;

class Application extends SilexApplication
{
    public function __construct(array $values = [])
    {
        parent::__construct($values);

        MongoBuilder::mountProviderIntoApplication($this);
        TokenBuilder::mountProviderIntoApplication($this);
        AuthBuilder::mountProviderIntoApplication('/auth', $this);
        RouterBuilder::mountProviderIntoApplication($this);


        $this->after(function (Request $request, Response $response) {
            $response->headers->set('Access-Control-Allow-Origin', '*');
        });
    }
}