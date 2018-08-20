<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Mailer\Email;

class DemandeForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('name', 'string')
            ->addField('email', ['type' => 'string'])
            ->addField('telephone', ['type' => 'string'])
            ->addField('message', ['type' => 'text']);
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator->add('name', 'length', [
            'rule' => ['minLength', 2],
            'message' => 'Le nom et le prénom sont requis'
        ])->add('email', 'format', [
            'rule' => 'email',
            'message' => 'Une adresse email valide est requise',
        ])->add('message', 'format', [
            'rule' => ['minLength', 2],
            'message' => 'Un contenu est requis',
        ]);
    }

    /**
     * @param array $errors
     */
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
            ->setSubject('Demande Spéciale Aux Transports Citadins')
            ->setEmailFormat('html')
            ->setTemplate('demande')
            ->setViewVars(['contenu' => $data])
            ->send();
        return true;
    }
}