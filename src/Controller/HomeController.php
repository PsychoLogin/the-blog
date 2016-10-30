<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 30/10/16
 * Time: 15:42
 */

namespace App\Controller;


class HomeController extends AppController
{
    public function index()
    {
        $this->loadModel('Articles');
        $this->set('articles', $this->Articles->find('all'));

    }
}