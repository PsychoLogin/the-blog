<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 30/10/16
 * Time: 14:22
 */

namespace App\Controller;
use Cake\ORM\TableRegistry;

class CapturesController extends AppController{



    public function index(){
        $browser = get_browser(null, true);
        print_r($browser);
    }


}