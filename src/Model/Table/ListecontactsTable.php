<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

class ListecontactsTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('listecontacts');
        $this->belongsTo('users')
            ->setForeignKey('iduser') // Avant la version CakePHP 3.4, utilisez foreignKey() au lieu de setForeignKey()
            ->setJoinType('INNER');
        $this->belongsToMany('contacts',[
            'propertyName' => 'Contacts',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
    }

    static function nom_existe($nom){
        $result = false;
        //$nom = str_replace(' ', '_', $nom);
        //debug($nom);die;
        $contactTable = TableRegistry::get('Listecontacts');
        $contact = $contactTable->find()->where(
            [
                "libelle" => $nom,
            ]
        )->all();

        if ($contact->first()){
            $result = $contact->first();
        }

        return $result;
    }

    static function liste(){
        $contacts = array();
        $contactTable = TableRegistry::get('Listecontacts');
        $cts = $contactTable->find()->all();
        foreach($cts as $c){
            $contacts[$c->id] = $c->libelle;
        }
        return $contacts;
    }

}