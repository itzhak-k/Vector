<?php

namespace Vector\Silex\Provider\Auth {

    use Silex\Application;
    use Silex\ServiceProviderInterface;
    use Vector\Silex\Provider\Tokenizer\TokenServiceProvider;

    class AuthServiceProvider implements ServiceProviderInterface
    {
        const AUTH_VALIDATE_CREDENTIALS = 'auth.validate.credentials';
        const AUTH_VALIDATE_TOKEN = 'auth.validate.token';
        const AUTH_NEW_TOKEN = 'auth.new.token';

        public function register(Application $app)
        {
            $app[self::AUTH_VALIDATE_CREDENTIALS] = $app->protect(function ($client, $pass) use ($app) {
                return $this->validateCredentials($client, $pass, $app);
            });

            $app[self::AUTH_VALIDATE_TOKEN] = $app->protect(function ($token) use ($app) {
                return $this->validateToken($token, $app);
            });

            $app[self::AUTH_NEW_TOKEN] = $app->protect(function ($client) use ($app) {
                return $this->getNewTokenForUser($client, $app);
            });
        }

        public function boot(Application $app)
        {
        }

        private function validateCredentials($client, $pass, $app)
        {
            return $app[TokenServiceProvider::TOKENS_VALIDATE_CLIENT]($client, $pass);
        }

        private function validateToken($token, $app)
        {
            return $app[TokenServiceProvider::TOKENS_VALIDATE_TOKEN]($token);
        }

        private function getNewTokenForUser($client, $app)
        {
            return $app[TokenServiceProvider::TOKENS_GET_TOKEN]($client);
        }
    }
}