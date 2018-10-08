<?php
/**
 * Created by PhpStorm.
 * User: krystofkosut
 * Date: 02.08.18
 * Time: 4:58
 */

namespace App\Controller;
use App\model\params;
use App\Twitter\twitter;
use PDO;

class test
{
    public function __construct(){

    }

    public function getHi(){
        return 'Hello from the other side!';
    }

    public function database(){
        $query  = "SELECT * FROM siteinfo LIMIT 100;";
        $stmt   = getConnection()->query($query);
        $wines  = $stmt->fetchAll(PDO::FETCH_OBJ);
        var_dump($wines[0]);
    }

    public function fetchColumn(){

        $params = new params();
        $result = $params::getValue('twitter_APIkey', false);

    }

    public function twitter(){
        $t = twitter::getInstance();
        $t->authenticate();
    }

    public function info(){
        phpinfo(); die();
    }


}