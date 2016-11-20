<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 30/10/16
 * Time: 14:22
 */

namespace App\Controller;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class ArticlesController extends AppController
{
    public function __construct($request = null, $response = null, $name = null, $eventManager = null, $components = null)
    {
        parent::__construct($request, $response, $name, $eventManager, $components);
        $this->captureTable = TableRegistry::get('Captures')->setSession($this->request->session());
        return $this;
    }

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    public function index()
    {
        $userId = $this->Auth->user('id');
        $this->set('articles', $this->Articles->find()->where(['user_id' => $userId]));
        $this->saveNavigationAction();
    }

    public function view($id = null)
    {
        $article = $this->Articles->get($id);
        $this->set(compact('article'));
        $this->saveNavigationAction();
    }

    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->data);
            // Added this line
            $article->user_id = $this->Auth->user('id');
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                if ($this->captureTable->checkAuth()){
                    $this->captureTable->saveAction("add_article", $this->request->params['action'], null,
                        Router::url( $this->here, true ), $article->body);
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('article', $article);
        $this->saveNavigationAction();

    }

    public function edit($id = null)
    {
        $article = $this->Articles->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->data);
            if ($this->Articles->save($article)) {
                if ($this->captureTable->checkAuth()){
                    $this->captureTable->saveAction("edit_article", $this->request->params['action'], null,
                        Router::url( $this->here, true ), $this->request->data('body'));
                }
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }
        $this->set('article', $article);
        $this->saveNavigationAction();

    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
        }
        $this->saveNavigationAction();
    }

    public function isAuthorized($user)
    {
        // All registered users can add articles
        if ($this->request->action === 'add') {
            return true;
        }

        // The owner of an article can edit and delete it
        if (in_array($this->request->action, ['edit', 'delete'])) {
            $articleId = (int)$this->request->params['pass'][0];
            if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }

    private function saveNavigationAction(){
        if ($this->captureTable->checkAuth()){
            $this->captureTable->saveAction("navigation", $this->request->params['action'], null, null, null);
        }
    }

}