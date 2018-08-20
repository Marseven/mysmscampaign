<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;


class ExpediteursController extends AppController
{
    public function initialize()
    {
        parent::initialize();
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
        $campagne = $campagneTable->find()->all();
        $camp_count = $campagne->count();
        $this->set('camp_count', $camp_count);

        $title = 'Gestion des Expéditeurs';
        $this->set('title', $title);

        $expediteurTable = TableRegistry::get('expediteurs');
        $expediteurs = $expediteurTable->find()->all();
        $this->set(compact('expediteurs'));

    }

    public function index()
    {
        $expediteurTable = TableRegistry::get('expediteurs');
        $expediteur = $expediteurTable->newEntity();
        $this->set(compact('expediteur'));
        $this->render('liste_expediteur');
    }

    public function add(){
        if ($this->request->is('post')) {
            $expediteurTable = TableRegistry::get('expediteurs');
            $defaut = $expediteurTable->find()
                ->where(
                    [
                        'defaut' => "Oui",
                    ]
                )
                ->all();

            $expediteur = $expediteurTable->newEntity($this->request->getData());
            $exp_def = $defaut->first();
            if($exp_def){
                if($expediteur->defaut == "on"){
                    $expediteur->defaut = "Oui";
                    $exp_def->defaut = "Non";
                    $expediteurTable->save($exp_def);
                }else{
                    $expediteur->defaut = "Non";
                }
            }else{
                if($expediteur->defaut == "on"){
                    $expediteur->defaut = "Oui";
                }else{
                    $expediteur->defaut = "Non";
                }
            }

            if($expediteurTable->save($expediteur)){
                $this->Flash->success('Expéditeur ajouté avec succès.');
                $this->_log('Création de expéditeur '.$expediteur->id);
                $this->redirect(['action' => 'index']);
            }
        };
        $expediteurTable = TableRegistry::get('expediteurs');
        $expediteur = $expediteurTable->newEntity();
        $this->set(compact('expediteur'));
        $this->render('liste_expediteur');
    }

    public function edit(){
        if (empty($this->request->params['?']['expediteur'])) {
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        } else {
            $id = (int)$this->request->params['?']['expediteur'];
            $expediteurTable = TableRegistry::get('expediteurs');
            $expediteur = $expediteurTable->get($id);
            if (!$expediteur) {
                $this->Flash->error('cette expediteur n\'existe pas.');
                $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            } else {
                if ($this->request->is(array('post', 'put'))) {
                    $defaut = $expediteurTable->find()
                        ->where(
                            [
                                'defaut' => "Oui",
                            ]
                        )
                        ->all();

                    $expediteur = $expediteurTable->newEntity($this->request->getData());
                    $expediteur->id = $id;
                    $exp_def = $defaut->first();
                    if($exp_def){
                        if($expediteur->defaut == "on"){
                            $expediteur->defaut = "Oui";
                            $exp_def->defaut = "Non";
                            $expediteurTable->save($exp_def);
                        }else{
                            $expediteur->defaut = "Non";
                        }
                    }else{
                        if($expediteur->defaut == "on"){
                            $expediteur->defaut = "Oui";
                        }else{
                            $expediteur->defaut = "Non";
                        }
                    }
                    if ($expediteurTable->save($expediteur)) {
                        $this->Flash->success('Votre expediteur a été mise à jour avec succès.');
                        $this->_log('Modification de expéditeur '.$expediteur->id);
                        $this->redirect(['action' => 'index']);
                    } else {
                        $this->Flash->set('Certains champs ont été mal saisis', ['element' => 'error']);
                    }

                }
            }
            $this->set('expediteur', $expediteur);
            $this->render('liste_expediteur');
        }
    }

    public function delete(){
        if(empty($this->request->params['?']['expediteur'])){
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['Controller' => 'Users','action' => 'logout']);
        }else{
            $id = (int)$this->request->params['?']['expediteur'];
            $expediteurTable = TableRegistry::get('expediteurs');
            $expediteur = $expediteurTable->get($id);
            if (!$expediteur) {
                $this->Flash->error('Cette expediteur n\'existe pas.');
                $this->redirect(['Controller' => 'Users','action' => 'logout']);
            }else{
                $expediteurTable->delete($expediteur);
                $this->Flash->set('Votre expediteur a été supprimé avec succès.', ['element' => 'success']);
                $this->_log('Suppression de expéditeur '.$expediteur->id);
                $this->redirect(['action' => 'index']);
            }
        }
    }

}