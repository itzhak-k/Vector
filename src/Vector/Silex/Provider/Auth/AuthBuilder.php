<?php

namespace Vector\Silex\Provider\Auth;

use Silex\Application;

class AuthBuilder
{
    public static function mountProviderIntoApplication($route, Application $app)
    {
        $app->register(new AuthServiceProvider());
        $app->mount($route, (new AuthControllerProvider())->setBaseRoute($route));
    }
}