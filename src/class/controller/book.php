<?php
/**
 * Created by PhpStorm.
 * User: krystofkosut
 * Date: 04.08.18
 * Time: 22:12
 */

namespace App\Controller;
use App\Model\book as model;

class book
{

    public function booklist(){
        $model = new model();
        return $model->getAllBooks();
    }
    
    
}