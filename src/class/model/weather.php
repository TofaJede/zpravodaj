<?php
/**
 * Created by PhpStorm.
 * User: krystofkosut
 * Date: 14.09.18
 * Time: 14:44
 */

namespace App\model;
use PDO;

class weather
{

    private $server = 'api.openweathermap.org/data/2.5/';
    private $table = 'weather';
    private $object;
    private $url;
    private $getParams;

    public function __construct(){
        $query = "SELECT * FROM $this->table LIMIT 1";
        $stmt   = getConnection()->query($query);
        $wines  = $stmt->fetchAll(PDO::FETCH_OBJ);
        $this->object = $wines[0];
        $this->getParams = 'id='.$this->object->cityId.'&APPID='.$this->object->apiKey.'&units=metric';
    }

    public function currentData(){
        // units=metric = Celsius
        $this->url = $this->server.'/weather?'.$this->getParams;
        return $this->callApi('now');
    }

    public function forecastData(){
        $this->url = $this->server.'/forecast?'.$this->getParams;
        return $this->callApi('forecast');
    }

    private function callApi($type = 'now'){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $JSONoutput = curl_exec($ch);
        if ($JSONoutput == FALSE) {
            return "cURL Error: " . curl_errno($ch) . " " . curl_error($ch);
        }
        curl_close($ch);

        $r = json_decode($JSONoutput);
        $body = array();

        if ($type=="forecast"){
            $header = array (
                'cod'       => $r->cod,
                'message'   => $r->message,
                'cnt'       => $r->cnt
            );
            foreach($r->list as $list){

                    if (substr($list->dt_txt, 0,9) == date('Y-m-d')){
                        continue;
                    }
                    if ( substr($list->dt_txt, -8) == '12:00:00'){
                        $body[] = $list;
                    }
            }

            $footer['city'] = array (
                'id'        => $r->city->id,
                'name'      => $r->city->name,
                'country'   => $r->city->country
            );
        } else {
            $body = json_decode($JSONoutput);
        }

        // If now, merge with forecast
        if($type == "now"){
            $forecastJSON = json_decode(file_get_contents('json/weatherforecast.json'));
            (array)$newJSON = array_merge((array)$forecastJSON, (array)$body);
        } else {
            $newJSON = array_merge($header, $body, $footer);
        }
        return json_encode($newJSON);
    }


}