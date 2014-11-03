<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11/3/2014
 * Time: 12:46 PM
 */

namespace Vector\Controllers\V1 {

    use Silex\Application;


    class RootController {

        public function rootAction(Application $app)
        {

                return $app->sendFile('static/index.html');
        }

    }
}