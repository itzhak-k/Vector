<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11/4/2014
 * Time: 4:21 PM
 */

namespace Vector\Silex\Provider\Tokenizer {

    use Silex\Application;

    class TokenBuilder
    {

        public static function mountProviderIntoApplication(Application $app)
        {
            $app->register(new TokenServiceProvider());
        }
    }
}