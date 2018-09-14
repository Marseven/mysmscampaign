<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

class SmssTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('smss');
        $this->hasMany('contactsmss',[
            'dependent' => true,
            'cascadeCallbacks' => true,
            ])
             ->setForeignKey('sms_id')
             ->setDependent(true);
        $this->belongsTo('users')
            ->setForeignKey('iduser') // Avant la version CakePHP 3.4, utilisez foreignKey() au lieu de setForeignKey()
            ->setJoinType('INNER');
        $this->belongsTo('expediteurs')
            ->setForeignKey('idexpediteur') // Avant la version CakePHP 3.4, utilisez foreignKey() au lieu de setForeignKey()
            ->setJoinType('INNER');
        $this->belongsTo('campagnes')
            ->setForeignKey('idcampagne') // Avant la version CakePHP 3.4, utilisez foreignKey() au lieu de setForeignKey()
            ->setJoinType('INNER');
        $this->belongsToMany('modelesmss', ['propertyName' => 'ModeleSmss']);
    }

}