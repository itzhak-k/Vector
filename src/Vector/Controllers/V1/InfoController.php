<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11/3/2014
 * Time: 3:35 PM
 */

namespace Vector\Controllers\V1 {

    use Silex\Application;


    class InfoController
    {
        public function infoAction(Application $app)
        {

            return $app->json([
                'status' => 'active',
                'info'   => [
                    'version'    => 'v1',
                    'creation' => '2014'
                ]]);
        }
    }
}