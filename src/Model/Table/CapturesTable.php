<?php
/**
 * Created by PhpStorm.
 * User: othma
 * Date: 17.11.2016
 * Time: 19:45
 */

namespace App\Model\Table;

use App\Model\Entity\BlogUser;
use App\Model\Entity\Session;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use Cake\Log\Log;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Network\Exception\ServiceUnavailableException;


class CapturesTable extends Table
{
    public static function defaultConnectionName() {
        return 'psylogincapture';
    }

    const SESSION_ENTITY_KEY = 'session_entity';
    private $sessionsTable;
    private $usersTable;
    private $session;

    function __construct() {
        $this->sessionsTable = TableRegistry::get('Sessions');
        $this->usersTable = TableRegistry::get('BlogUsers');
        $this->staticSessionDataTable = TableRegistry::get('StaticSessionDatas');
        $this->actionsTable = TableRegistry::get('Actions');
        $this->actionTypesTable = TableRegistry::get('ActionTypes');
        $this->resourcesTable = TableRegistry::get('Resources');
        $this->classificationsTable = TableRegistry::get('Classifications');
        $this->tagsTable = TableRegistry::get('Tags');
        return $this;
    }

    function setSession($session) {
        $this->session = $session;
        return $this;
    }

    private function getSessionEntity() {
        return $this->session->read(CapturesTable::SESSION_ENTITY_KEY);
    }

    public function login($username, $keyboard_metadata) {
        if (!$this->checkAuth()) {
            $user = $this->saveUser($username);
            $entity = $this->sessionsTable->newEntity();
            $entity->blog_user = $user;
            $entity->start = Time::now()->toDateTimeString();
            $entity->stop = Time::maxValue()->toDateTimeString();
            $this->sessionsTable->save($entity);
            $this->session->write(CapturesTable::SESSION_ENTITY_KEY, $entity);
            if ($keyboard_metadata) {
                $keyboard_timestamps = explode(',', $keyboard_metadata);
                foreach ($keyboard_timestamps as $timestampInMilliseconds) {
                    $milliseconds = substr($timestampInMilliseconds, -3);
                    $timestampInSeconds = substr($timestampInMilliseconds, 0, -3);
                    $dateTimeText = Time::createFromTimestamp($timestampInSeconds)->toDateTimeString();
                    $dateTimeText .= '.'.$milliseconds;
                    $this->saveAction('keypress', 'password_input', $dateTimeText, null, null, null);
                }
            }
        }
    }

    public function checkAuth(){
        if ($this->session->check(CapturesTable::SESSION_ENTITY_KEY)) return true;
        return false;
    }

    public function saveStaticSessionData($referer, $clientIP){
        $browser = get_browser(null, null);
        $staticSession = $this->staticSessionDataTable->find()
            ->where((['session_id' => $this->getSessionEntity()->id]))->first();
        if (!$staticSession){
            $entity = $this->staticSessionDataTable->newEntity();
            $entity->os = $browser->platform;
            $entity->lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            $entity->browser = $browser->browser . " " . $browser->version;
            $entity->referrer = $referer;
            $entity->location = $clientIP;
            $entity->session = $this->getSessionEntity();
            $this->staticSessionDataTable->save($entity);
        }
    }

    public function logout() {
        $entity = $this->getSessionEntity();
        $entity->stop = Time::now()->toDateTimeString();
        if (!$this->sessionsTable->save($entity)) throw new ServiceUnavailableException();
    }

    private function saveUser($username)
    {
        $blogUser = $this->usersTable->findByUsername($username)->first();
        if (!$blogUser) {
            $bloguser = new BlogUser(['username' => $username]);
            if (!$this->usersTable->save($bloguser)) throw new ServiceUnavailableException();
        }
        return $blogUser;
    }

    public function saveAction($type, $description, $timestamp, $resource, $url, $content){
        if (!$timestamp) {
            $timestamp = Time::now()->toDateTimeString();
        }
        $actionTypeEntity = $this->actionTypesTable->find()
            ->where((['title' => $type, 'description' => $description]))->first();

        if (!$actionTypeEntity){
            $actionTypeEntity = $this->actionsTable->newEntity();
            $actionTypeEntity->title = $type;
            $actionTypeEntity->description = $description;
            if (!$this->actionTypesTable->save($actionTypeEntity)) throw new ServiceUnavailableException();
        }
        if (!$resource){
            $resourceEntity = null;
        }
        else{
            $resourceEntity = $this->resourcesTable->find()
                ->where((['url' => $url, 'content' => $content]))->first();
            if (!$resourceEntity){
                $resourceEntity = $this->resourcesTable->newEntity();
                $resourceEntity->url = $url;
                $resourceEntity->content = $content;
                if (!$this->resourcesTable->save($resourceEntity)) throw new ServiceUnavailableException();
            }
        }
        $entity = $this->actionsTable->newEntity();
        $entity->session = $this->getSessionEntity();
        $entity->action_type = $actionTypeEntity;
        $entity->resource = $resourceEntity;
        $entity->time_stamp = $timestamp;
        if (!$this->actionsTable->save($entity)) throw new ServiceUnavailableException();
    }
}