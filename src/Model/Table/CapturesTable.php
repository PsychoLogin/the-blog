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
        return $this;
    }

    function setSession($session) {
        $this->session = $session;
        return $this;
    }

    private function getSessionEntity() {
        return $this->session->read(CapturesTable::SESSION_ENTITY_KEY);
    }

    public function login($username) {
        if (!$this->session->check(CapturesTable::SESSION_ENTITY_KEY)) {
            $user = $this->saveUser($username);
            $entity = $this->sessionsTable->newEntity();
            $entity->blog_user = $user;
            $entity->start = Time::now()->toDateTimeString();
            $entity->stop = Time::maxValue()->toDateTimeString();
            $this->sessionsTable->save($entity);
            $this->session->write(CapturesTable::SESSION_ENTITY_KEY, $entity);
        }
    }

    public function logout() {
        $entity = $this->getSessionEntity();
        $entity->stop = Time::now()->toDateTimeString();
        $this->sessionsTable->save($entity);
    }

    private function saveUser($username)
    {
        $blogUser = $this->usersTable->findByUsername($username)->first();
        if (!$blogUser) {
            $bloguser = new BlogUser([
                'username' => $username
            ]);
            if (!$this->usersTable->save($bloguser)) {
                throw new ServiceUnavailableException();
            }
        }
        return $blogUser;
    }
}