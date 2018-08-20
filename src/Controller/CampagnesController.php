<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

class CampagnesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['index']);
        $user = $this->Auth->user();
        if(isset($user)){
            $user['confirmed_at'] = new FrozenTime($user['confirmed_at']);
            $user['reset_at'] = new FrozenTime($user['reset_at']);
            $usersTable = TableRegistry::get('Users');
            if(is_array($user)){
                $user = $usersTable->newEntity($user);
            }
            $this->set('user', $user);
        }
        $campagneTable = TableRegistry::get('campagnes');
        $campagnes = $campagneTable->find()->all();
        $this->set(compact('campagnes'));
        $camp_count = $campagnes->count();
        $this->set('camp_count', $camp_count);
        $title = 'Gestion des Campagnes';
        $this->set('title', $title);

    }

    public function index()
    {
        $campagneTable = TableRegistry::get('campagnes');
        $campagne = $campagneTable->newEntity();
        $this->set(compact('campagne'));
    }

    public function programmation(){
        $campagneTable = TableRegistry::get('campagnes');
        $campagnes = $campagneTable->find()
            ->where(
            [
                'dateEnvoi >' => date('Y-m-d H:i:s'),
            ]
        )->all();
        $this->set(compact('campagnes'));

    }

    public function add(){
        if ($this->request->is('post')) {
            $campagneTable = TableRegistry::get('campagnes');
            $campagne = $campagneTable->newEntity($this->request->getData());
            if ($campagneTable->save($campagne)) {
                $this->Flash->set('Votre campagne a été créé avec succès.', ['element' => 'success']);
                $this->_log('Création de la campagne '.$campagne->id);
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->set('Certains champs ont été mal saisis', ['element' => 'error']);
            }
        }
    }

    public function edit(){
        if ($this->request->getQuery('campagne') == false) {
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        } else {
            $id = (int)$this->request->getQuery('campagne');
            $campagneTable = TableRegistry::get('campagnes');
            $campagne = $campagneTable->get($id);
            if (!$campagne) {
                $this->Flash->error('cette campagne n\'existe pas.');
                $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            } else {
                if ($this->request->is(array('post', 'put'))) {
                    $campagne = $campagneTable->newEntity($this->request->getData());
                    if ($campagneTable->save($campagne)) {
                        $this->Flash->set('Votre campagne a été mise à jour avec succès.', ['element' => 'success']);
                        $this->_log('Modification de la campagne '.$campagne->id);
                        $this->redirect(['action' => 'index']);
                    } else {
                        $this->Flash->set('Certains champs ont été mal saisis', ['element' => 'error']);
                    }

                }
            }
            $this->set('campagne', $campagne);
        }
    }

    public function delete(){
        if ($this->request->getQuery('campagne') == false) {
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['Controller' => 'Users','action' => 'logout']);
        }else{
            $id = (int)$this->request->getQuery('campagne');
            $campagneTable = TableRegistry::get('campagnes');
            $campagne = $campagneTable->get($id);
            if (!$campagne) {
                $this->Flash->error('Cette campagne n\'existe pas.');
                $this->redirect(['Controller' => 'Users','action' => 'logout']);
            }else{
                $campagneTable->delete($campagne);
                $this->Flash->set('Votre campagne a été supprimé avec succès.', ['element' => 'success']);
                $this->_log('Suppression de la campagne '.$campagne->id);
                $this->redirect(['action' => 'index']);
            }
        }
    }

}