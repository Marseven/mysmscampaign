<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Mailer\Email;

class SearchForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('lieu_depart', 'string')
            ->addField('lieu_arriver', ['type' => 'string'])
            ->addField('type', ['type' => 'string'])
            ->addField('date_depart', ['type' => 'string'])
            ->addField('date_arriver', ['type' => 'string'])
            ->addField('marque', ['type' => 'string'])
            ->addField('prix', ['type' => 'string']);
    }

    public function setErrors(array $errors)
    {
        $this->_errors = $errors;
    }
}