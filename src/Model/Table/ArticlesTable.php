<?php

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Created by PhpStorm.
 * User: jan
 * Date: 30/10/16
 * Time: 14:20
 */
class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsTo('Users');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('title')
            ->requirePresence('title')
            ->notEmpty('body')
            ->requirePresence('body');

        return $validator;
    }

    public function isOwnedBy($articleId, $userId)
    {
        return $this->exists(['id' => $articleId, 'user_id' => $userId]);
    }
}