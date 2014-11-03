<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11/3/2014
 * Time: 12:35 PM
 */

namespace Vector\Silex\Provider\Router;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

class RouterServiceProvider implements ServiceProviderInterface {



    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $app['routes'] = $app->share($app->extend('routes', function ($routes, $app) {
            $loader = new YamlFileLoader(new FileLocator(__DIR__.'/../../../../../config'));
            $collection = $loader->load('routing.yml');

            $routes->addCollection($collection);

            return $routes;
        }));
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registers
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
    }

} 