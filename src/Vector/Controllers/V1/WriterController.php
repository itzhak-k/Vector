<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11/2/2014
 * Time: 6:51 PM
 */

namespace Vector\Controllers\V1 {

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    class WriterController {


        public function writerAction(Request $request, Application $app)
        {
            $collection = new \MongoCollection($app['vectordb'], 'writers');

            if(!is_numeric($request->get('id'))) {
                $cursor = $collection->find();
                $data = iterator_to_array($cursor, true);

                return $app->json($data);

            } else {
                $cursor = $collection->findOne(['id' => (int)$request->get('id')]);

                return $app->json([
                    'id' => $cursor['id'],
                    'info' => [
                        'lname' => $cursor['lname'],
                        'fname' => $cursor['fname']
                    ]]);
            }
        }

    }
}