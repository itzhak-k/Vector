<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11/3/2014
 * Time: 12:35 PM
 */

namespace Vector\Silex\Provider\Router;

use Silex\Application;

class RouterBuilder {

    public static function mountProviderIntoApplication(Application $app)
    {
        $app->register(new RouterServiceProvider());
    }
} 