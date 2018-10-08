<?php
/**
 * Created by PhpStorm.
 * User: krystofkosut
 * Date: 16.09.18
 * Time: 0:25
 */

namespace App\model;
use PDO;

class params{

    static public function getValue($implementationName, $defaultValue = false){
        $query = "SELECT value FROM params WHERE implementationName = '$implementationName' LIMIT 1";
        $stmt   = getConnection()->query($query);
        $stmt   = $stmt->fetchColumn();
        if (is_string($stmt)){
            return $stmt;
        } else {
            return $defaultValue;
        }
    }
}