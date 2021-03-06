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
        if(isset($user) && $user != null){
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
        $title = 'Gestion des Utilisateurs';
        $this->set('title', $title);
    }


	public function index(){
        if (!$this->isAdministrator() && !$this->isSuperAdministrator()){
            $this->Flash->error("Vous n'etes pas Administrateur, Espace reserve aux Administrateurs.");
            return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        }
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

        $contactsmsTable = TableRegistry::get('contactsmss');
        $reponse_sms = $contactsmsTable->find()->contain(['Smss'])->all();
        $nbre_envoye = 0;
        $nbre_non_envoye = 0;
        $nbre_echec = 0;
        foreach ($reponse_sms as $rs) {
            if ($rs->status == 1) {
                $nbre_envoye++;
            } elseif ($rs->status == 2 || $rs->status == 3) {
                $nbre_non_envoye++;
            } elseif ($rs->status == 4 || $rs->status == 5) {
                $nbre_echec++;
            } else {
                $nbre_non_envoye++;
            }
        }

        $data = $this->statSms();

        $this->set([
            'nbre_non_envoye' => $nbre_non_envoye,
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
                if($this->Auth->user('role') == "Administrateur" || $this->Auth->user('role') == "SuperAdministrateur"){
                    return $this->redirect($this->Auth->redirectUrl());
                }else{
                    return $this->redirect(['controller' => 'Sms', 'action' => 'sendSms']);
                }

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
        if (!$this->isAdministrator() && !$this->isSuperAdministrator()){
            $this->Flash->error("Vous n'etes pas Administrateur, Espace reserve aux Administrateurs.");
            return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        }
        $usersTable = TableRegistry::get('Users');
        $new_user = $usersTable->newEntity();
        $this->set(compact('new_user'));
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
            $now = date('Y-m-d');
            $now = new \DateTime($now);
            $now = $now->modify('-18 years');
            $dateNaiss = new \DateTime($this->request->getData()['dateNaiss']);
            if($dateNaiss < $now){
                $user = $usersTable->newEntity($this->request->getData());
                $filename = $this->request->getData()['picture']['name'];
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $good_ext = in_array($extension, ['png', 'jpg', 'jpeg']);
                if($good_ext && $filename != ''){
                     $user->picture = $this->request->getData()["picture"]["name"];
                    move_uploaded_file($this->request->getData()["picture"]["tmp_name"],"img/user/".$this->request->getData()["picture"]["name"]);
                }else{
                    $this->Flash->error('Mauvais type de fichier importé. Type correct : jpg, png, jpeg');
                    $this->redirect(['action' => 'signup']);
                }
                if ($usersTable->save($user)) {
                    $link =$user->id.'-'.md5($user->password);
                    $user->confirmed_token = md5($user->password);
                    $usersTable->save($user);
                    $mail = new Email();
                    $mail->setFrom('support@setrag.ga')
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
            }else{
                $this->Flash->error('Mauvaise Date, veuillez saisir des dates conformes et inférieur à'.$now->format('d-m-Y'));
                return $this->render('signup');
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
            $date = new \DateTime($user_edit->dateNaiss);
            $date = $date->format('Y-m-d');
            $this->set(['user_edit' => $user_edit, 'date' => $date]);
        }
        if ($this->request->is(array('post','put'))) {
            $now = date('Y-m-d');
            $now = new \DateTime($now);
            $now = $now->modify('-18 years');
            $dateNaiss = new \DateTime($this->request->getData()['dateNaiss']);
            if($dateNaiss < $now){
                $user = $usersTable->newEntity($this->request->getData());
                if($id != null){
                    $user->id = $id;
                }else{
                    $user->id = $user_edit->id;
                }
                $filename = $this->request->getData()['picture']['name'];
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $good_ext = in_array($extension, ['png', 'jpg', 'jpeg']);
                if($good_ext && $filename != ''){
                     $user->picture = $this->request->getData()["picture"]["name"];
                    move_uploaded_file($this->request->getData()["picture"]["tmp_name"],"img/user/".$this->request->getData()["picture"]["name"]);
                }else{
                    $this->Flash->error('Mauvais type de fichier importé. Type correct : jpg, png, jpeg');
                    $this->redirect(['action' => 'edit', 'user' => $user->id]);
                }
                
                if ($usersTable->save($user)) {
                    $user = $usersTable->get($id);
                    $this->Auth->setUser($user);
                    $this->Flash->success('Votre profil a été mis à jour avec succès !');
                    $this->_log('Modification de utilisateur '.$user->id);
                    return $this->redirect(['action' => 'profil', 'user' => $user->id]);
                }else{
                    $this->Flash->error('Certains champs ont été mal saisis');
                }
            }else{
                $this->Flash->error('Mauvaise Date, veuillez saisir des dates conformes et inférieur à'.$now->format('d-m-Y'));
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
            $this->Auth->setUser($user);
            $this->_log('confirmation de utilisateur '.$user->id);
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
                $mail->setFrom('support@setrag.ga')
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
            if (!$user) {
                $this->Flash->error('Cette utilisateur n\'est pas valide.');
                return $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login',
                ));
            }
            $user->reset_at = date('Y-m-d H:m:s');
            $user->reset_token = NULL;
            $user->password = $this->request->getData()['password'];
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

    function password(){
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
        if($this->request->is(array('post','put'))){
            if(empty($this->request->getData()['password']) || $this->request->getData()['password'] != $this->request->getData()['password_verify']){
                $this->Flash->set('Mots de passe différents !', ['element' => 'error']);
                return $this->render('reset_password', 'login');
            }
            $user = $this->Auth->user();
            if(isset($user) && $user != null){
                if(is_array($user)){
                    $user = $usersTable->newEntity($user);
                }
            }
            if (!$user) {
                $this->Flash->error('Cette utilisateur n\'est pas valide.');
                return $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login',
                ));
            }
            
            $user->password = $this->request->getData()['password'];
            $usersTable->save($user);
            $this->Auth->setUser($user);
            $this->Flash->success('Mot de passe réinitialisé avec succès.');
            $this->_log('Mot de passe réinitialisé pour utilisateur '.$user->id);
            return $this->redirect([
                'controller' => 'users',
                'action' => 'profil',
            ]);

        }

        $this->render('password');
    }

    public function delete(){
        if (!$this->isAdministrator() && !$this->isSuperAdministrator()){
            $this->Flash->error("Vous n'etes pas Administrateur, Espace reserve aux Administrateurs.");
            return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        }
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
            $user = $this->Auth->user();
            if(isset($user) && $user != null) {
                if (is_array($user)) {
                    $user = $usersTable->newEntity($user);
                }
                if($user->role == 'Administrateur'){
                    if($user->role == 'Utilisateur'){
                        $usersTable->delete($user);
                        $this->Flash->set('L\'utilisateur a été supprimé avec succès.', ['element' => 'success']);
                        $this->_log('Suppression de utilisateur '.$user->id);
                        $this->redirect(['controller' => 'Users','action' => 'index']);
                    }else{
                        $this->Flash->set('L\'utilisateur que vous essayer de supprimer est un administrateur ', ['element' => 'error']);
                        $this->redirect(['controller' => 'Users','action' => 'index']);
                    }
                }elseif($user->role == 'SuperAdministrateur'){
                    $usersTable->delete($user);
                    $this->Flash->set('L\'utilisateur a été supprimé avec succès.', ['element' => 'success']);
                    $this->_log('Suppression de utilisateur '.$user->id);
                    $this->redirect(['controller' => 'Users','action' => 'index']);
                }
            }

        }
    }

    public function becomeAdministrator(){
        $usersTable = TableRegistry::get('Users');
        if($this->request->getQuery('user')){
            $id = (int)$this->request->getQuery('user');
            $user_edit = $usersTable->get($id);
            if (!$user_edit) {
                $this->Flash->error('Ce profil n\'exite pas');
                $this->redirect(['action' => 'logout']);
            }
            $user_edit->role = 'Administrateur';
            if ($usersTable->save($user_edit)){
                $this->Flash->success($user_edit->nom.' '.$user_edit->prenom .' est desormais un administrateur de MySMSCampaign.');
                return $this->redirect(['action' => 'liste']);
            }

        }
    }

    public function profil(){
        $usersTable = TableRegistry::get('Users');
        $user = $this->Auth->user();
        if(is_array($user)){
            $usersTable = TableRegistry::get('Users');
            $user = $usersTable->newEntity($user);
            $user->dateNaiss = $this->age($user->dateNaiss);
        }elseif (!is_array($user) && !is_object($user)) {
            $this->redirect(['Controller' => 'Users','action' => 'logout']);
        }
        if($this->request->getQuery('user') != false){
            $id = (int)$this->request->getQuery('user');
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
        if (!$this->isAdministrator() && !$this->isSuperAdministrator()){
            $this->Flash->error("Vous n'etes pas Administrateur, Espace reserve aux Administrateurs.");
            return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        }
        $usersTable = TableRegistry::get('Users');
        $user = $this->Auth->user();
        if(isset($user) && $user != null){
            if(is_array($user)){
                $user = $usersTable->newEntity($user);
            }

            if ($user->role == "Administrateur" || $user->role == "SuperAdministrateur"){
                $users = $usersTable->find()
                    ->where(
                        [
                            'OR' => [['role' => 'Administrateur'], ['role' => 'Utilisateur']],
                        ]
                    )
                    ->all();
            }

            $this->set('users', $users);
        }

    }

    public function propos(){

    }

    public function aide(){
        $title = 'Aide ?';
        $this->set('title', $title);
    }
}
