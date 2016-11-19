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
        //echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";
        //echo ("</br>");
        // now try it
        $staticSessionDataTable = TableRegistry::get('StaticSessionDatas');

        $sessionData = $staticSessionDataTable->find(1)->first();
    }


}