<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

class ExpediteursTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('expediteurs');
        $this->belongsTo('users')
            ->setForeignKey('iduser') // Avant la version CakePHP 3.4, utilisez foreignKey() au lieu de setForeignKey()
            ->setJoinType('INNER');
        $this->hasMany('smss')
            ->setForeignKey('idexpediteur')
            ->setDependent(true);

    }

    static function expediteur(){
        $expediteurs = array();
        $expediteurTable = TableRegistry::get('Expediteurs');
        $expd = $expediteurTable->find()->orderDesc('defaut')->all();
        foreach($expd as $ex){
            $expediteurs[$ex->id] = $ex->titre;
        }
        return $expediteurs;
    }

}