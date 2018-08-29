<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

class ContactsmssTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('contactsmss');
        $this->belongsTo('Smss')
            ->setForeignKey('sms_id') // Avant la version CakePHP 3.4, utilisez foreignKey() au lieu de setForeignKey()
            ->setJoinType('INNER');
    }

}