<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10/26/2014
 * Time: 3:33 PM
 */

namespace Vector\Silex\Provider\Mongo;

use Silex\Application;


class MongoBuilder {

    public static function mountProviderIntoApplication(Application $app)
    {
        $app->register(new MongoServiceProvider());
    }

} 