<?php
/**
 * Created by PhpStorm.
 * User: krystofkosut
 * Date: 02.08.18
 * Time: 12:56
 */

namespace App;



class CustomHandler {
    public function __invoke($request, $response, $exception) {

        error_log("Caught $exception", 3, __DIR__."/../../log/ExcetionError_".date('Y-m-d H:i:s').".log");

        return $response
            ->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Something went wrong!');
    }
}