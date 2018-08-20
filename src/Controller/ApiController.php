<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

class ApiController extends AppController
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

            $apiTable = TableRegistry::get('api');
            $apis = $apiTable->find()->all();

            $campagneTable = TableRegistry::get('campagnes');
            $campagne = $campagneTable->find()->all();
            $camp_count = $campagne->count();
            $this->set('camp_count', $camp_count);

            $this->set(compact('apis'));
            $this->set('user', $user);

            $title = 'Gestion des API de SMS';
            $this->set('title', $title);
        }

    }

    public function index()
    {
        $apiTable = TableRegistry::get('api');
        $api = $apiTable->newEntity();
        $this->set(compact('api'));
    }

    public function setApi(){
        if (empty($this->request->params['?']['api'])) {
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        } else {
            $id = (int)$this->request->params['?']['api'];
            $apiTable = TableRegistry::get('api');
            $api = $apiTable->get($id);
            if (!$api) {
                $this->Flash->error('cette api n\'existe pas.');
                $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            } else {
                if ($this->request->is(array('post', 'put'))) {
                    $actif = $apiTable->find()
                        ->where(
                            [
                                'etat' => "Actif",
                            ]
                        )
                        ->all();

                    $api = $apiTable->newEntity($this->request->getData());
                    $api->id = $id;
                    $ap_def = $actif->first();
                    if($ap_def){
                        if($api->etat == "on"){
                            $api->etat = "Actif";
                            $ap_def->etat = "Inactif";
                            $apiTable->save($ap_def);
                        }else{
                            $api->etat = "Inactif";
                        }
                    }else{
                        if($api->etat == "on"){
                            $api->etat = "Actif";
                        }else{
                            $api->etat = "Inactif";
                        }
                    }
                    if ($apiTable->save($api)) {
                        $this->Flash->set('Votre api activée.', ['element' => 'success']);
                        $this->_log('Définition des paramètre de l\'api '.$api->id);
                        $this->redirect(['action' => 'index']);
                    } else {
                        $this->Flash->set('Certains champs ont été mal saisis', ['element' => 'error']);
                    }

                }
            }
            $this->set('api', $api);
            $this->render('index');
        }
    }

    public function add(){

        if ($this->request->is('post')) {
            $apiTable = TableRegistry::get('api');
            $actif = $apiTable->find()
                ->where(
                    [
                        'etat' => "Actif",
                    ]
                )
                ->all();

            $api = $apiTable->newEntity($this->request->getData());
            $ap_def = $actif->first();
            if($ap_def){
                if($api->etat == "on"){
                    $api->etat = "Actif";
                    $ap_def->etat = "Inactif";
                    $apiTable->save($ap_def);
                }else{
                    $api->etat = "Inactif";
                }
            }else{
                if($api->etat == "on"){
                    $api->etat = "Actif";
                }else{
                    $api->etat = "Inactif";
                }
            }
            if($apiTable->save($api)){
                $this->Flash->success('API ajouté avec succès.');
                $this->_log('Ajout de l\'api '.$api->id);
                $this->redirect(['action' => 'index']);
            }
        };

        $this->render('index');
    }

    public function edit()
    {
        if ($this->request->getQuery('api') == false) {
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        } else {
            $id = (int)$this->request->getQuery('api');
            $apiTable = TableRegistry::get('api');
            $api = $apiTable->get($id);
            if (!$api) {
                $this->Flash->error('cette api n\'existe pas.');
                $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            } else {
                if ($this->request->is(array('post', 'put'))) {
                    $actif = $apiTable->find()
                        ->where(
                            [
                                'etat' => "Actif",
                            ]
                        )
                        ->all();

                    $api = $apiTable->newEntity($this->request->getData());
                    $api->id = $id;
                    $ap_def = $actif->first();
                    if($ap_def){
                        if($api->etat == "on"){
                            $api->etat = "Actif";
                            $ap_def->etat = "Inactif";
                            $apiTable->save($ap_def);
                        }else{
                            $api->etat = "Inactif";
                        }
                    }else{
                        if($api->etat == "on"){
                            $api->etat = "Actif";
                        }else{
                            $api->etat = "Inactif";
                        }
                    }
                    if ($apiTable->save($api)) {
                        $this->Flash->set('Votre api a été mise à jour avec succès.', ['element' => 'success']);
                        $this->_log('Modification de l\'api '.$api->id);
                        $this->redirect(['action' => 'index']);
                    } else {
                        $this->Flash->set('Certains champs ont été mal saisis', ['element' => 'error']);
                    }

                }
            }
            $this->set('api', $api);
            $this->render('index');
        }
    }

    public function delete(){
        if ($this->request->getQuery('api') == false) {
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['Controller' => 'Users','action' => 'logout']);
        }else{
            $id = (int)$this->request->getQuery('api');
            $apiTable = TableRegistry::get('api');
            $api = $apiTable->get($id);
            if (!$api) {
                $this->Flash->error('Cette api n\'existe pas.');
                $this->redirect(['Controller' => 'Users','action' => 'logout']);
            }else{
                $apiTable->delete($api);
                $this->Flash->set('Votre api a été supprimé avec succès.', ['element' => 'success']);
                $this->_log('Suppression de l\'api '.$api->id);
                $this->redirect(['action' => 'index']);
            }
        }
    }
}