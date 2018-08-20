<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

class CampagnesTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('campagnes');
        $this->belongsTo('users')
            ->setForeignKey('iduser') // Avant la version CakePHP 3.4, utilisez foreignKey() au lieu de setForeignKey()
            ->setJoinType('INNER');
        $this->hasMany('smss')
            ->setForeignKey('idcampagne')
            ->setDependent(true);

    }

    static function campagne(){
        $campagnes = array();
        $campagneTable = TableRegistry::get('Campagnes');
        $camp = $campagneTable->find()->orderDesc('dateCreation')->all();
        foreach($camp as $cp){
            $campagnes[$cp->id] = $cp->libelle;
        }
        return $campagnes;
    }
}