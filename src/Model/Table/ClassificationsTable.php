<?php
/**
 * Created by PhpStorm.
 * User: othma
 * Date: 16.11.2016
 * Time: 14:05
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class ClassificationsTable extends Table
{
    public static function defaultConnectionName() {
        return 'psylogincapture';
    }
    public function initialize(array $config)
    {
        $this->belongsTo('Resources');
        $this->belongsTo('Tags');
    }
}