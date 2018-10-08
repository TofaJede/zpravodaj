<?php
/**
 * Created by PhpStorm.
 * User: krystofkosut
 * Date: 12.09.18
 * Time: 14:31
 */

namespace App\controller;
use App\model\rssChannel;
use App\model\weather;

class get {

    public function zpravy($name){
        return json_decode(file_get_contents('json/'.$name.'.json'));
    }

    public function routes($active = 1){
        if(file_exists('json/routes.json')){
            return json_decode(file_get_contents('json/routes.json'));
        } else {
            $rssModel = new rssChannel();
            return $rssModel->getRoutes($active);
        }
    }

    public function weather($type = 'my'){
        //TODO: More sofisticated
        return json_decode(file_get_contents('json/weather'.$type.'.json'));
    }

}