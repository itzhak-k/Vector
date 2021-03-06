<?php

namespace Vector\Silex\Provider\Auth {

    use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
    use Symfony\Component\HttpFoundation\Request;
    use Silex\ControllerProviderInterface;
    use Silex\Application;

    class AuthControllerProvider implements ControllerProviderInterface
    {
        const VALIDATE_CREDENTIALS = '/validateCredentials';
        const TOKEN_HEADER_KEY = 'X-Token';
        const TOKEN_REQUEST_KEY = '_token';

        private $baseRoute;

        public function setBaseRoute($baseRoute)
        {
            $this->baseRoute = $baseRoute;

            return $this;
        }

        public function connect(Application $app)
        {
            $this->setUpMiddlewares($app);

            return $this->extractControllers($app);
        }

        private function extractControllers(Application $app)
        {
            $controllers = $app['controllers_factory'];

            $controllers->get(self::VALIDATE_CREDENTIALS, function (Request $request) use ($app) {
                $client = $request->get('client');
                $pass = $request->get('pass');
                $status = $app[AuthServiceProvider::AUTH_VALIDATE_CREDENTIALS]($client, $pass);

                return $app->json([
                    'status' => $status,
                    'info' => $status ? ['token' => $app[AuthServiceProvider::AUTH_NEW_TOKEN]($client)] : []

                ]);
            });

            return $controllers;
        }

        private function setUpMiddlewares(Application $app)
        {
            $app->before(function (Request $request) use ($app) {
                if (!$this->isAuthRequiredForPath($request->getPathInfo())) {
                    if (!$this->isValidTokenForApplication($app, $this->getTokenFromRequest($request))) {
                        throw new AccessDeniedHttpException('Access Denied');
                    }
                }
            });
        }

        private function getTokenFromRequest(Request $request)
        {
            return $request->headers->get(self::TOKEN_HEADER_KEY, $request->get(self::TOKEN_REQUEST_KEY));
        }

        private function isAuthRequiredForPath($path)
        {
            return in_array($path, [$this->baseRoute . self::VALIDATE_CREDENTIALS, '/', '/info']);
        }

        private function isValidTokenForApplication(Application $app, $token)
        {
            return $app[AuthServiceProvider::AUTH_VALIDATE_TOKEN]($token);
        }
    }
}