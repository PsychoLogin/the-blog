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
        $userid = $this->request->query('userid');
        if($userid !== null) {
            $this->loadModel('Articles');
            $this->set('articles', $this->Articles->find()
                ->where(['user_id' => $userid]));
        }
        else {
            $this->loadModel('Articles');
            $this->set('articles', $this->Articles->find('all'));
        }
        $this->loadModel('Users');
        $this->set('users', $this->Users->find('all'));
    }
}