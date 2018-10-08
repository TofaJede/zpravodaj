<?php
/**
 * Created by PhpStorm.
 * User: krystofkosut
 * Date: 03.08.18
 * Time: 14:24
 */

namespace App;


class core
{

    /**
     * @return array
     */
    static function requestURL($rootURL){
       $requestURL = str_replace($rootURL, "", $_SERVER['REQUEST_URI']);
       $parsedURL  = parse_url($requestURL);
       $parsedURL  = explode("/", $parsedURL['path']);
        return $parsedURL;
    }


}