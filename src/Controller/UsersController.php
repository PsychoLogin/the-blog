<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 30/10/16
 * Time: 14:34
 */

namespace App\Controller;

use App\Model\Table\CapturesTable;
use Cake\Database\Schema\Table;
use Cake\Event\Event;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;

class UsersController extends AppController
{
    private $captureTable;

    public function __construct($request = null, $response = null, $name = null, $eventManager = null, $components = null)
    {
        parent::__construct($request, $response, $name, $eventManager, $components);
        $this->captureTable = TableRegistry::get('Captures')->setSession($this->request->session());
        return $this;
    }

    public function index()
    {
        $this->set('users', $this->Users->find('all'));
    }

    public function view($id)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->captureTable->saveUser($user->username);
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }

    public function testAdd($user){
        throw new ServiceUnavailableException();
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['add', 'logout']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->captureTable->login($this->Auth->user('username'), json_decode($this->request->data('keyboard_metadata')));
                $this->captureTable->saveStaticSessionData($this->referer(),$this->request->clientIp());

                $session = $this->request->session()->read(CapturesTable::SESSION_ENTITY_KEY);

                $http = new Client();
                $response = $http->post(
                    'http://localhost:8080/analyzer/resources/analyse',
                    '{
                        "currentSessionId":'.$session->id.' ,
                        "blogUserId":'.$session->blog_user_id.' 
                    }',
                    ['type' => 'json']
                );

                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        $this->captureTable->logout();
        $this->request->session()->destroy();
        return $this->redirect($this->Auth->logout());
    }

}