<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

class UsersTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('users');
        $this->hasMany('api')
             ->setForeignKey('iduser')
             ->setDependent(true);
        $this->hasMany('campagnes')
             ->setForeignKey('iduser')
             ->setDependent(true);
        $this->hasMany('contacts')
            ->setForeignKey('iduser')
            ->setDependent(true);
        $this->hasMany('expediteurs')
            ->setForeignKey('iduser')
            ->setDependent(true);
        $this->hasMany('listecontacts')
            ->setForeignKey('iduser')
            ->setDependent(true);
        $this->hasMany('modelesmss')
            ->setForeignKey('iduser')
            ->setDependent(true);
        $this->hasMany('smss')
            ->setForeignKey('iduser')
            ->setDependent(true);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('nom')
            ->notEmpty('nom', 'Ce champ doit être rempli.')
            ->requirePresence('email')
            ->add('email', [
                'length' => [
                    'rule' => 'email',
                    'message' => 'Ex : abc@xyz.cfr',
                ]
            ])
            ->requirePresence('telephone')
            ->notEmpty('telephone', 'Ce champ doit être rempli.')
            ->requirePresence('ville')
            ->notEmpty('ville', 'Ce champ doit être rempli.')
            ->requirePresence('password')
            ->notEmpty('password', 'Ce champ doit être rempli.')
            ->requirePresence('password_verify')
            ->notEmpty('password_verify', 'Ce champ doit être rempli.');

        return $validator;
    }

}