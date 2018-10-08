<?php
/**
 * Created by PhpStorm.
 * User: krystofkosut
 * Date: 10.09.18
 * Time: 20:54
 */

namespace App\model;
use PDO;

class rssChannel
{
    private $table = 'rssChannel';

    public function add($args){

        $query  = "INSERT INTO $this->table";
        $query .= " (`".implode("`, `", array_keys($args))."`)";
        $query .= " VALUES ('".implode("', '", $args)."') ";

        $stmt   = getConnection()->query($query);
    }

    public function update($args = NULL, $where = ''){

        $query  = "UPDATE $this->table SET ";

        if ($args != NULL){
            $updates = array();

            foreach( $args as $field => $value ) {
                $updates[] = "`$field` = '$value'";
            }
            $query .= implode(', ', $updates);
            $query .= ',';
        }
        $query .= " `update` = CURRENT_TIMESTAMP ";

        if ($where != ''){
            $query .= ' WHERE '.$where;
        }

        $stmt   = getConnection()->query($query);
        return $stmt;

    }

    public function getOne($name){

        $query = 'SELECT * FROM '.$this->table;
        if (is_string($name)){
            $query .= ' WHERE name = \''.$name.'\'';
        } elseif (is_int($name)){
            $query .= " WHERE id = $name";
        } else {
            return false;
        }
        $query .= ' LIMIT 1';

        $stmt   = getConnection()->query($query);
        $wines  = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $wines[0];
    }

    public function getAll($active = 1){
        $query  = "SELECT * FROM $this->table 
                  WHERE active = $active
                    LIMIT 100;";
        $stmt   = getConnection()->query($query);
        $wines  = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $wines;
    }

    public function getRoutes($active = 1){
        $rss = $this->getAll($active);
        $route = [];
        foreach($rss as $channel){
            $route[] = ['name' => $channel->readableName, 'route' => '/get/zpravy/'.$channel->name];
        }
        return $route;
    }

}