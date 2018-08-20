<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\ContactsTable;
use App\Model\Table\ExpediteursTable;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\I18n\FrozenTime;

class UsersController extends AppController {
    /*
     * JE SUIS BLOQUE A TOUS LES NIVEAUX LORS DE LA RECUPERATIONS DES INFORMATIONS
     * VENANT DE LA BD SURTOUT AVEC LE "COUNT" CONDITIONE DANS UN "DISTINCT"
     * VERIFIE CELA AVEC LA TABLE "CONTACT", TU VERRAS QUE C'EST UN PEU BIZZARRE PUISQU'IL Y A DES CONTACTS EN DOUBLONS.
     *
     * JE TE REVIENS POUR D'AUTRES TACHES.
     *
     * CORDIALEMENT,
     */

    /*
     * DECLARATION DES BORNES SUPERIEURES DES DONNEES STATISTIQUES
     * CES VALEURS SONT FIXEES EN FONCTIONS DES PREVISIONS ET DES DONNEES ACTUELLES DU TERRAIN
     */

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['login', 'remember', 'confirm', 'resetPassword', 'logout']);
        $user = $this->Auth->user();
        if($user){
            $user['confirmed_at'] = new FrozenTime($user['confirmed_at']);
            $user['reset_at'] = new FrozenTime($user['reset_at']);
            $usersTable = TableRegistry::get('Users');
            if(is_array($user)){
                $user = $usersTable->newEntity($user);
                $user->dateNaiss = $this->age($user->dateNaiss);
            }
            $this->set('user', $user);
        }
        $campagneTable = TableRegistry::get('campagnes');
        $campagne = $campagneTable->find()->all();
        $camp_count = $campagne->count();
        $this->set('camp_count', $camp_count);
        $title = 'Gestion des Utilisateurs';
        $this->set('title', $title);
    }


	public function index(){
        $title = 'Tableau de Bord';
        $this->set('title', $title);

        /*
         * DEBUT - DES TACHES STATISTIQUES
         */
         $NBRE_MAX_CONTACT = 1000000;

        /*
         * Contacts
         */
        $contactsTable = TableRegistry::get('Contacts');
        $nbre_total_contact = $contactsTable->find('all')->count();

        $pourcentage_contact = ceil(($nbre_total_contact * 100) / $NBRE_MAX_CONTACT);
        $pourcentage_contact = ($pourcentage_contact > 100) ? 100 : $nbre_total_contact;

        $this->set('nbre_total_contact', $nbre_total_contact);
        $this->set('pourcentage_contact', $pourcentage_contact);

        /*
         * Campagnes
         */
        $campagnesTable = TableRegistry::get('Campagnes');

        $nbre_total_campagne = $campagnesTable->find()->count();

        $campagnes_pr = $campagnesTable->find()
            ->where(
                [
                    'dateEnvoi >' => date('Y-m-d H:i:s'),
                ]
            )->all();
        $pourcentage_camp_pr = ($campagnes_pr->count()/$nbre_total_campagne)*100;
        $this->set(compact('pourcentage_camp_pr'));
        $this->set(compact('campagnes_pr'));

        $campagnes = $campagnesTable->find()->orderDesc('dateCreation')->limit(5)->all();
        $this->set(compact('campagnes'));

        $nbre_campagne = $campagnesTable->find()->contain('Smss')->all();
        $moyenne_cout = 0;

        foreach ($nbre_campagne as $nbc){
            $moyenne_cout+=$nbc->cout;
        }
        $moyenne_cout = $moyenne_cout/$nbre_total_campagne;
        $this->set(compact('moyenne_cout'));

        //Modele SMS
        $modelesTable = TableRegistry::get('Modelesmss');
        $modeles = $modelesTable->find()->contain('Users')->orderDesc('Modelesmss.dateCreation')->limit(5)->all();
        $this->set(compact('modeles'));

        //SMS
        $smsTable = TableRegistry::get('Smss');
        $date = new \DateTime();
        $date->modify("-7 days");
        $date = $date->format('Y-m-d H:i:s');
        $sms = $smsTable->find()
            ->where(
            [
                'dateEnvoi >' => $date,
                'dateEnvoi <' => date('Y-m-d H:i:s'),
            ]
        )->all();
        $this->set(compact('sms'));

        //debug($nbre_campagne);die;
        $nbre_envoye = 0;
        $nbre_programme = 0;
        $nbre_echec = 0;
        foreach ($nbre_campagne as $camp){
            foreach ($camp->smss as $ms){
                if ($ms->etat == 100){
                    $nbre_envoye++;
                }elseif ($ms->etat == 101){
                    $nbre_programme++;
                }else{
                    $nbre_echec++;
                }
            }
        }

        $data = $this->statSms();

        $this->set([
            'nbre_programme' => $nbre_programme,
            'nbre_echec' => $nbre_echec,
            'nbre_envoye' => $nbre_envoye,
            'data' => $data,
        ]);


    }

	function login(){

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->Flash->success('Content de vous revoir '.$this->Auth->user('nom').' '.$this->Auth->user('prenom'));
                $this->_log('Authentification de utilisateur '.$this->Auth->user('id'));
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Votre email ou mot de passe est incorrect.');
        }
        $this->render('login', 'login');
    }

    function logout(){
        $date = date('Y-m-d H:m:s');
        $usersTable = TableRegistry::get('Users');
        $user = $this->Auth->user();
        if(is_array($user)){
            $user = $usersTable->get($user['id']);
        }
        if($user != null || !empty($user)){
            $user->last_login = $date;
            $usersTable->save($user);
        }else{
            return $this->redirect($this->Auth->logout());
        }
        $this->Flash->set('À Bientôt '.$user->nom.' '.$user->prenom, ['element' => 'default']);
        $this->_log('Déconnexion de utilisateur '.$user->id);
        return $this->redirect($this->Auth->logout());
    }

    function signup(){
        $usersTable = TableRegistry::get('Users');
        $user = $usersTable->newEntity();
        $this->set(compact('user'));
        if($this->request->is('post')){
            if(empty($this->request->getData()['password']) || $this->request->getData()['password'] != $this->request->getData()['password_verify']){
                $this->Flash->set('Mots de passe différents !', ['element' => 'error']);
                return $this->render('signup');
            }
            $exist_email = $usersTable->find()
                ->where(
                    [
                        'email' => $this->request->getData()['email'],
                    ]
                )
                ->limit(1)
                ->all();
            if(!$exist_email->isEmpty()){
                $this->Flash->error('Cette email existe déjà.');
                return $this->render('signup');
            }
            $user = $usersTable->newEntity($this->request->getData());
            $user->role = "Utilisateur";

           if ($usersTable->save($user)) {
                $link =$user->id.'-'.md5($user->password);
                $user->confirmed_token = md5($user->password);
                $usersTable->save($user);
                $mail = new Email();
                $mail->setFrom('contact@jobs-conseil.com')
                     ->setTo($user->email)
                     ->setSubject('Confirmation d\'enregistrement')
                     ->setEmailFormat('html')
                     ->setTemplate('confirmation')
                     ->setViewVars([
                        'last_name' => $user->nom.' '.$user->prenom,
                        'link' => $link
                     ]);
                $mail->send();
                $this->Flash->success('Utilisateur enregistré avec succès, un email de confirmation a été envoyé à l\'utilisateur.');
               $this->_log('création de utilisateur '.$user->id);
                return $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'signup',
                ));
           }else{
                $this->Flash->error('Certains champs ont été mal saisis');
           }
        }

    }

    function edit($id = null){
        $usersTable = TableRegistry::get('Users');
        if($this->request->getQuery('user')){
            $id = (int)$this->request->getQuery('user');
            $user_edit = $usersTable->get($id);
            if (!$user_edit) {
                $this->Flash->error('Ce profil n\'exite pas');
                $this->redirect(['action' => 'logout']);
            }
            $this->set('user_edit', $user_edit);
        }
        if ($this->request->is(array('post','put'))) {
            if(empty($this->request->getData()['password']) || $this->request->getData()['password'] != $this->request->getData()['password_verify']){
                $this->Flash->error('Mots de passe différents !');
            }else{
                $user = $usersTable->newEntity($this->request->getData());
                if($id != null){
                    $user->id = $id;
                }else{
                    $user->id = $user_edit->id;
                }
                if ($usersTable->save($user)) {
                    $user = $usersTable->get($id);
                    $this->Auth->setUser($user);
                    $this->Flash->success('Votre profil a été mis à jour avec succès !');
                    $this->_log('Modification de utilisateur '.$user->id);
                    return $this->redirect($this->Auth->redirectUrl());
                }else{
                    $this->Flash->error('Certains champs ont été mal saisis');
                }
            }
        }
    }

    function confirm(){
        $token = $_GET['token'];
        $token = explode('-', $token);
        $usersTable = TableRegistry::get('Users');
        $user = $usersTable->find()
                            ->where(
                                [
                                    'id' => $token[0],
                                    'confirmed_token' => $token[1],
                                ]
                            )
                            ->limit(1)
                            ->all();
        if(!empty($user->first())){
            $user = $user->first();
            $user->confirmed_at = date('Y-m-d H:m:s');
            $user->confirmed_token = NULL;
            $usersTable->save($user);
            $this->Flash->success('Bienvenue Sur MySMSCampaign By Setrag,  '.$user->nom.' '.$user->prenom);
            $this->_log('confirmation de utilisateur '.$user->id);
            $this->Auth->setUser($user);
            return $this->redirect($this->Auth->redirectUrl());
        }else{
            $this->Flash->error('Ce lien n\'est plus valide.');
            return $this->redirect(array(
                'controller' => 'users',
                'action' => 'login',
            ));
        }
    }

    function remember(){
        if($this->request->is('post')){
            $usersTable = TableRegistry::get('Users');
            $data = $this->request->getData();
            $user = $usersTable->find()
                ->where([
                    'email' => $data['email'],
                ])
                ->limit(1)
                ->all();
            if(empty($user->first())){
                $this->Flash->error('Aucun Profil ne correspond à cette email.');
                return $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'reset_password',
                ));
            }else{
                $user = $user->first();
				/*$link = array(
                    'controller' => 'users',
                    'action' => 'reset_password',
                    'token' => $user->id.'-'.md5($user->password)
                );*/
				$link = "http://mysmscampaign.jobs-conseil.com/users/reset_password/?token=".$user->id.'-'.md5($user->password);
				$user->reset_token = md5($user->password);
                $usersTable->save($user);
                $mail = new Email();
                $mail->setFrom('contact@jobs-conseil.com')
                    ->setTo($user->email)
                    ->setSubject('Mot de Passe Oublié')
                    ->setEmailFormat('html')
                    ->setTemplate('forget_password')
                    ->setViewVars(array(
                        'last_name' => $user->nom.' '.$user->prenom,
                        'link' => $link
                    ))
                    ->send();
                $this->Flash->success('Un email a été envoyer à votre boîte mail pour réinitialiser votre mot de passe.');
                $this->_log('Envoi de mail de réinitialisation à utilisateur '.$user->id);
            }
        }
        $this->render('remember', 'login');
    }

    function resetPassword(){
        $usersTable = TableRegistry::get('Users');

        if(!empty($_GET['token'])){
            $token = $_GET['token'];
            $token = explode('-', $token);
            $user = $usersTable->find()
                ->where([
                    'id' => $token[0],
                    'reset_token' =>$token[1],
                ])
                ->limit(1)
                ->all();
            if(empty($user->first())){
                $this->Flash->error('Ce lien n\'est pas valide.');
                return $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login',
                ));
            }else{
                $email = $user->first()->email;
                $this->set('email', $email);
            }
        }

        if($this->request->is('post')){
            if(empty($this->request->getData()['password']) || $this->request->getData()['password'] != $this->request->getData()['password_verify']){
                $this->Flash->set('Mots de passe différents !', ['element' => 'error']);
                return $this->render('reset_password', 'login');
            }
            $user = $usersTable->find()
                ->where([
                    'email' => $this->request->getData()['email'],
                ])
                ->limit(1)
                ->all();
            $user = $user->first();
            $user->reset_at = date('Y-m-d H:m:s');
            $user->reset_token = NULL;
            $usersTable->save($user);
            $this->Auth->setUser($user);
            $this->Flash->success('Mot de passe réinitialisé avec succès.');
            $this->_log('Mot de passe réinitialisé pour utilisateur '.$user->id);
            return $this->redirect([
                'controller' => 'users',
                'action' => 'index',
            ]);

        }

        $this->render('reset_password', 'login');
    }

    public function delete(){
        if($this->request->getQuery('user') == false){
            $this->Flash->error('Information manquante.');
            return $this->redirect(['action' => 'logout']);
        }else{
            $id = (int)$this->request->getQuery('user');
        }
        $usersTable = TableRegistry::get('Users');
        $user = $usersTable->get($id);
        if (!$user) {
            $this->Flash->error('Ce profil n\'exite pas');
            return $this->redirect(['action' => 'logout']);
        }else{
            if($user->role == 'Utilisateur'){
                $usersTable->delete($user);
                $this->Flash->set('L\'utilisateur a été supprimé avec succès.', ['element' => 'success']);
                $this->_log('Suppression de utilisateur '.$user->id);
                $this->redirect(['controller' => 'Users','action' => 'index']);
            }else{
                $this->Flash->set('L\'utilisateur que vous essayer de supprimer est un administrateur ', ['element' => 'error']);
                $this->redirect(['controller' => 'Users','action' => 'index']);
            }
        }
    }

    public function profil(){
        $usersTable = TableRegistry::get('Users');
        $user = $this->Auth->user();
        if($user){
            $usersTable = TableRegistry::get('Users');
            $user = $usersTable->newEntity($user);
            $user->dateNaiss = $this->age($user->dateNaiss);
        }
        if(!empty($this->request->params['?']['user'])){
            $id = (int)$this->request->params['?']['user'];
            $user = $usersTable->get($id);
            if (!$user) {
                $this->Flash->error('Ce profil n\'exite pas');
                $this->redirect(['action' => 'logout']);
            }

            $this->set('user', $user);
        }

        $contactTable = TableRegistry::get('contacts');
        $contacts = $contactTable->find()
            ->where(
                [
                    'iduser' => $user->id,
                ]
            )->all();
        $this->set('contacts', $contacts);

        $campagneTable = TableRegistry::get('campagnes');
        $campagnes = $campagneTable->find()
            ->where(
                [
                    'iduser' => $user->id,
                ]
            )->all();
        $this->set('campagnes', $campagnes);

        $expediteurs = ExpediteursTable::expediteur();
        $this->set(compact('expediteurs'));

        $contact_add = ContactsTable::contact();
        $this->set('contact_add', $contact_add);

    }

    public function liste(){
        $usersTable = TableRegistry::get('Users');
        $users = $usersTable->find()
            ->where(
                [
                    'role' => 'Utilisateur',
                ]
            )
            ->all();
        $this->set('users', $users);
    }

    public function propos(){

    }
}
