<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Mailer\Email;

class ReservationForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('name', 'string')
            ->addField('email', ['type' => 'string'])
            ->addField('phone', ['type' => 'string'])
            ->addField('message', ['type' => 'text'])
            ->addField('lieu_depart', ['type' => 'text'])
            ->addField('lieu_arriver', ['type' => 'text'])
            ->addField('voiture', ['type' => 'text'])
            ->addField('date_depart', ['type' => 'datetime-local'])
            ->addField('date_arriver', ['type' => 'datetime-local']);
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator->add('name', 'length', [
            'rule' => ['minLength', 2],
            'message' => 'Un nom est requis'
        ])->add('email', 'format', [
            'rule' => 'email',
            'message' => 'Une adresse email valide est requise',
        ])->add('lieu_depart', 'format', [
            'rule' => ['minLength', 2],
            'message' => 'Un lieu de depart est requis',
        ])->add('lieu_arriver', 'format', [
            'rule' => ['minLength', 2],
            'message' => 'Un lieu d\'arrivé est requis',
        ])
        ->requirePresence('date_depart', 'Une date de départ est requise')
        ->notEmpty('date_depart', 'La date de départ doit être remplie')
        ->requirePresence('date_arriver', 'Une date d\'arrivé est requise')
        ->notEmpty('date_arriver', 'La date d\'arrivé doit être remplie')
            ;
    }

    public function setErrors(array $errors)
    {
        $this->_errors = $errors;
    }

    protected function _execute(array $data)
    {
        // Envoie un email.
        $mail = new Email();
        $mail->setFrom('richard.mebodo@jobs-conseil.com')
            ->setTo('noreply@transports-citadins.com')
            ->setSubject('Réservation Spéciale Chez Les Transports Citadins')
            ->setEmailFormat('html')
            ->setTemplate('reservation_speciale')
            ->setViewVars([
                'contenu' => $data,
            ])
            ->send();
        return true;
    }
}