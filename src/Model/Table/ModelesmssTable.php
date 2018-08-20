<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

class ModelesmssTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('modelesmss');
        $this->belongsTo('users')
            ->setForeignKey('iduser') // Avant la version CakePHP 3.4, utilisez foreignKey() au lieu de setForeignKey()
            ->setJoinType('INNER');
        $this->belongsToMany('smss', ['propertyName' => 'Sms']);

    }

    static function modele(){
        $modeles = array();
        $modeleTable = TableRegistry::get('Modelesmss');
        $mod = $modeleTable->find()->all();
        /*foreach($mod as $m){
            $modeles[$m->id] = $m->libelle;
        }*/
        return $mod;
    }

}