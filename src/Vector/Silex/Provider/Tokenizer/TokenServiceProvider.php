<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11/4/2014
 * Time: 2:46 PM
 */

namespace Vector\Silex\Provider\Tokenizer {

    use Silex\Application;
    use Silex\ServiceProviderInterface;

    class TokenServiceProvider implements ServiceProviderInterface {

        const TOKENS = 'tokens';
        const TOKENS_LOAD = 'tokens.load';
        const TOKENS_VALIDATE_CLIENT = 'tokens.validate.clients';
        const TOKENS_GET_TOKEN = 'tokens.get.token';
        const TOKENS_VALIDATE_TOKEN = 'tokens.validate.token';

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
            $app[self::TOKENS] = array();

            $app[self::TOKENS_LOAD] = $app->protect(function ($clients) use ($app) {
                $this->loadClients($clients, $app);
            });

            $app[self::TOKENS_VALIDATE_CLIENT] = $app->protect(function ($client, $pass) use ($app) {
                return $this->validateClient($client, $pass, $app);
            });

            $app[self::TOKENS_GET_TOKEN] = $app->protect(function ($client) use ($app) {
                return $this->getToken($client, $app);
            });

            $app[self::TOKENS_VALIDATE_TOKEN] = $app->protect(function ($token) use ($app) {
                return $this->validateToken($token, $app);
            });

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

        private function loadClients(\MongoCollection $clients, $app)
        {
            $cursor = $clients->find(array(), array("_id" => 0, "name" => 1, "password" => 1, "token" => 1));
            $app[TokenServiceProvider::TOKENS] =iterator_to_array($cursor, true);
            return;
        }

        private function validateClient($client, $pass, $app)
        {
            foreach ($app[TokenServiceProvider::TOKENS] as $k => $val) {
                if ($val['name'] === $client && $val['password'] === $pass) {
                    return true;
                }
            }

            return false;
        }

        private function getToken($client, $app)
        {
            foreach ($app[TokenServiceProvider::TOKENS] as $k => $val) {
                if ($val['name'] === $client) {
                    return $val['token'];
                }
            }

            return '';
        }

        private function validateToken($token, $app)
        {
            foreach ($app[TokenServiceProvider::TOKENS] as $k => $val) {
                if ($val['token'] === $token) {
                    return true;
                }
            }
            return false;
        }
    }
}