<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

class ContactsTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('contacts');
        $this->belongsTo('users')
            ->setForeignKey('iduser') // Avant la version CakePHP 3.4, utilisez foreignKey() au lieu de setForeignKey()
            ->setJoinType('INNER');
        $this->belongsToMany('smss', ['propertyName' => 'Sms']);
        $this->belongsToMany('listecontacts', ['propertyName' => 'ListeContacts']);

    }

    static function contact(){
        $contacts = array();
        $contactTable = TableRegistry::get('Contacts');
        $cts = $contactTable->find()->orderDesc('nom')->all();
        foreach($cts as $c){
            $contacts[$c->id] = $c->nom;
        }
        return $contacts;
    }

    static function nom_existe($nom){
        $result = false;

        $contactTable = TableRegistry::get('Contacts');
        $contact = $contactTable->find()->where(
            [
                'nom' => $nom,
            ]
        )->all();

        if ($contact->first()){
            $result = $contact->first();
        }

        return $result;
    }

    static function tel_existe($tel){
        $result = false;

        $contactTable = TableRegistry::get('Contacts');
        $contact = $contactTable->find()->where(
            [
                'telephone' => $tel,
            ]
        )->all();

        if ($contact->first()){
            $result = $contact->first();
        }

        return $result;
    }

    static function nom_tel_existe($nom, $tel){
        $result = false;

        $contactTable = TableRegistry::get('Contacts');
        $contact = $contactTable->find()->where(
            [
                'telephone' => $tel,
                'nom' => $nom,
            ]
        )->all();

        if ($contact->first()){
            $result = $contact->first();
        }

        return $result;
    }
}