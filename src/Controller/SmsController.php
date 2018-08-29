<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Modelesms;
use App\Model\Table\CampagnesTable;
use App\Model\Table\ContactsTable;
use App\Model\Table\ExpediteursTable;
use App\Model\Table\ListecontactsTable;
use App\Model\Table\ModelesmssTable;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

class SmsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Cewi/Excel.Import');
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

        $title = 'Gestion de Modèles de SMS';
        $this->set('title', $title);
    }

    public function index()
    {

    }

    public function sendSms(){
        $title = 'Envoi de SMS';
        $this->set('title', $title);
        $expediteurs = ExpediteursTable::expediteur();
        $this->set(compact('expediteurs'));
        $modeles = ModelesmssTable::modele();
        $this->set(compact('modeles'));
        $campagnes = CampagnesTable::campagne();
        $this->set(compact('campagnes'));
        $listes = ListecontactsTable::liste();
        $this->set(compact('listes'));

        $contactTable = TableRegistry::get('Contacts');
        $listecontactTable = TableRegistry::get('Listecontacts');
        $apiTable = TableRegistry::get('api');
        $expediteurTable = TableRegistry::get('expediteurs');
        $campagneTable = TableRegistry::get('campagnes');
        $smsTable = TableRegistry::get('smss');
        $smscontactTable = TableRegistry::get('contactsmss');
        $smsmodeleTable = TableRegistry::get('modelesmss_smss');

        $user = $this->Auth->user();
        if($user){
            $usersTable = TableRegistry::get('Users');
            $user = $usersTable->newEntity($user);
        }

        if($this->request->is('post')){
            //debug($this->request->getData());
            if ($this->request->getData()['destinataire'] == 'mobile'){
                $contacts = explode(',', $this->request->getData()['contact']);
                //debug($contacts);die;
                //Code Recyclé - pour sauvegarde de contact automatique
                /*$nom_tel_existe = ContactsTable::nom_tel_existe('', $this->request->getData()['contact']);
                $nom_existe = ContactsTable::nom_existe('');
                $tel_existe = ContactsTable::tel_existe($this->request->getData()['contact']);
                if ($nom_tel_existe == false){
                    if ($nom_existe != false && $tel_existe == false){
                        $nom_existe->telephone = $this->request->getData()['contact'];
                        if ($contactTable->save($nom_existe)){
                            $contacts[0] = $nom_existe;

                        }
                    }elseif($tel_existe != false){
                        $contacts[0] = $tel_existe;
                    }elseif($tel_existe == false && $nom_existe == false){
                        $contact = $contactTable->newEntity();
                        $contact->nom = '';
                        $contact->telephone = $this->request->getData()['contact'];
                        $contact->iduser = $user->id;
                        if ($contactTable->save($contact)){
                            $contacts[0] = $contact;
                        }
                    }
                }else{
                    $contacts[0] = $nom_tel_existe;
                }*/
            }elseif($this->request->getData()['listecontact_import']['name'] != ''){
                $filename = $this->request->getData()['listecontact_import']['name'];
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $good_ext = in_array($extension, ['xlsx', 'csv']);
                if($good_ext){
                    $liste_nom_existe = ListecontactsTable::nom_existe($filename);
                    if ($liste_nom_existe == false){
                        move_uploaded_file($this->request->getData()['listecontact_import']['tmp_name'], "files/listecontact/".$filename);
                        $listecontact = $listecontactTable->newEntity();
                        $listecontact->libelle = $filename;
                        $listecontact->iduser = $user->id;
                        $listecontactTable->save($listecontact);
                    }else {
                        $listecontact = $liste_nom_existe;
                    }

                    $data = $this->Import->prepareEntityData("files/listecontact/".$filename, ['worksheet'=> 0]);
                    //debug($data);
                    $contacts = array();
                    $i=0;

                    foreach($data as $d){
                        $d['TELEPHONE1'] = $this::format_telehone($d['TELEPHONE1']);
                        if ($d['TELEPHONE1'] == false) {
                            $this->Flash->error('Numéro de téléphone invalide.');
                            return $this->redirect(['controller' => 'Sms','action' => 'sendSms']);
                        }
                        $contacts[$i] = $d['TELEPHONE1'];
                        $i++;
                        ////Code Recyclé - pour sauvegarde de contact automatique
                        /*$nom_tel_existe = ContactsTable::nom_tel_existe($d['CLIENT'], $d['TELEPHONE1']);
                        $nom_existe = ContactsTable::nom_existe($d['CLIENT']);
                        $tel_existe = ContactsTable::tel_existe($d['TELEPHONE1']);
                        if ($nom_tel_existe == false){
                            if ($nom_existe != false && $tel_existe == false){
                                $nom_existe->telephone = $d['TELEPHONE1'];
                                if ($contactTable->save($nom_existe)){
                                    $contacts[$i] = $nom_existe;
                                    $i++;
                                }
                            }elseif($tel_existe != false && $nom_existe == false){
                                $tel_existe->nom = $d['CLIENT'];
                                if ($contactTable->save($tel_existe)){
                                    $contacts[$i] = $tel_existe;
                                    $i++;
                                }
                            }elseif($tel_existe == false && $nom_existe == false){
                                $contact = $contactTable->newEntity();
                                $contact->nom = $d['CLIENT'];
                                $contact->telephone = $d['TELEPHONE1'];
                                $contact->iduser = $user->id;
                                if ($contactTable->save($contact)){
                                    $contacts[$i] = $contact;
                                    $i++;
                                }
                            }
                        }else{
                            $contacts[$i] = $nom_tel_existe;
                            $i++;
                        }*/
                    }

                    $listecontact->contacts = $i;
                    $listecontactTable->save($listecontact);

                }else{
                    $this->Flash->error('Mauvais type de fichier importé. Type correct : xlsx, csv');
                    $this->redirect(['action' => 'createListContact']);
                }
            }else{
                $listecontact = $listecontactTable->find()->where(
                    [
                        'id' => $this->request->getData()['listecontact'],
                    ]
                )->contain('contacts')->all();

                $contacts = array();
                $i=0;
                $listecontact = $listecontact->first();
                foreach($listecontact->Contacts as $d){
                    $contacts[$i] = $d;
                    $i++;
                }
            }

            if ($this->request->getData()['typeenvoi'] == 'differe'){
                $dateEnvoi = $this->request->getData()['dateEnvoi'];
                $date = new \DateTime($dateEnvoi);
                $date = $date->format('Y-m-d H:i:s');
            }

            $api = $apiTable->find()
                ->where(
                    [
                        'etat' => "Actif",
                    ]
                )
                ->all();
            $api = $api->first();

            if ($api == null){
                $this->Flash->error('Aucune API n\'est active.');
                return $this->redirect(['controller' => 'Users','action' => 'profil']);
            }

            $expediteur = $expediteurTable->get($this->request->getData()['idexpediteur']);

            $camp_store = false;
            if ($this->request->getData()['campagne'] == 'unstore'){
                $campagne = $campagneTable->find()
                    ->where(
                        [
                            'libelle' => $this->request->getData()['campagne_unstore'],
                        ]
                    )
                    ->all();

                $campagne = $campagne->first();
                if (!$campagne && $this->request->getData()['campagne_unstore'] != ""){
                    $campagne = $campagneTable->newEntity();
                    if(isset($date)) $campagne->dateEnvoi = $date;
                    $campagne->libelle = $this->request->getData()['campagne_unstore'];
                    $campagne->iduser = $user->id;
                    $campagneTable->save($campagne);
                    $camp_store = false;
                }elseif ($campagne) {
                    $campagne = $campagneTable->get($this->request->getData()['campagne_store']);
                    if(isset($date)) $campagne->dateEnvoi = $date;
                    $campagneTable->save($campagne);
                    $camp_store = true;
                }else{
                   $this->Flash->error('Campagne invalide. Veuillez choisir une campagne existante ou entrer un nom valide de campagne.');
                    return $this->redirect(['controller' => 'Sms','action' => 'sendSms']); 
                }
            }else{
                $campagne = $campagneTable->get($this->request->getData()['campagne_store']);
                if(isset($date)) $campagne->dateEnvoi = $date;
                $campagneTable->save($campagne);
                $camp_store = true;
            }


            $texte = htmlspecialchars($this->request->getData()['contenu']);
            $verif = preg_match("#param_1#i", "'.$texte.'");


            $sms = $smsTable->newEntity();

            $sms->contenu = $this->request->getData()['contenu'];
            $sms->iduser = $user->id;
            $sms->idexpediteur = $expediteur->id;
            $sms->idcampagne = $campagne->id;
            $sms->dateEnvoi = date('Y-m-d H:m:s');

            //config
            $url = $api->url; //'https://api.allmysms.com/http/9.0/sendSms/';
            $login = $api->login;   //votre identifant allmysms
            $apiKey  = $api->apikey;    //votre mot de passe allmysms
            $message = $sms->contenu;   //le message SMS, attention pas plus de 160 caractères
            $sender  = $expediteur->titre;  //l'expediteur, attention pas plus de 11 caractères alphanumériques
            //$msisdn  = $contact->telephone;   //numéro de téléphone du destinataire
            $smsData  = "<DATA>
                               <MESSAGE><![CDATA[".$message."]]></MESSAGE>
                               <TPOA>$sender</TPOA>";
            if ($this->request->getData()['typeenvoi'] == 'differe'){
                $smsData.= "<DATE>$date</DATE>";
            }
            if ($verif == 1){
                $smsData .= "<DYNAMIC>$verif</DYNAMIC>";
            }
            foreach ($contacts as $contact){
                $smsData.=     "<SMS>";
                                     if ($verif == 1 && is_object($contact)){
                                        $smsData .= "<MOBILEPHONE>$contact->telephone</MOBILEPHONE>
                                                     <PARAM_1>$contact->nom</PARAM_1>";
                                     }elseif(is_object($contact)){
                                        $smsData .= "<MOBILEPHONE>$contact->telephone</MOBILEPHONE>";
                                     }else{
                                        $smsData .= "<MOBILEPHONE>$contact</MOBILEPHONE>";
                                     }
                                $smsData.= "</SMS>";
            }
            $smsData   .= "</DATA>";
            $format = 'JSON';

            $fields = array(
                'login'    => urlencode($login),
                'apiKey'      => urlencode($apiKey),
                'returnformat' => urlencode($format),
                'smsData'       => urlencode($smsData),
            );

            $fieldsString = "";
            foreach($fields as $key=>$value) {
                $fieldsString .= $key.'='.$value.'&';
            }
            rtrim($fieldsString, '&');

            try {

                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_POST, count($fields));
                curl_setopt($ch,CURLOPT_POSTFIELDS, $fieldsString);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $result = curl_exec($ch);

                //echo $result;

                curl_close($ch);

            } catch (Exception $e) {
                $this->Flash->error('API injoignable ou trop longue a repondre ' . $e->getMessage());
                return $this->redirect(['controller' => 'Sms','action' => 'sendSms']);
            }

            $response = json_decode($result, true);

            $campagne->campaignId = $response['campaignId'];
            if ($camp_store){
                $campagne->nbre_contact += $response['nbContacts'];
                $campagne->nbre_envoye += $response['nbSms'];
                $campagne->cout += $response['cost'];
                if ($response['invalidNumbers'] == ''){
                    $campagne->nbre_echec += 0;
                }else{
                    $campagne->nbre_echec += 1;
                }
            }else{
                $campagne->nbre_contact = $response['nbContacts'];
                $campagne->nbre_envoye = $response['nbSms'];
                $campagne->cout = $response['cost'];
                if ($response['invalidNumbers'] == ''){
                    $campagne->nbre_echec = 0;
                }else{
                    $campagne->nbre_echec = 1;
                }
            }

            if(!isset($date)) $campagne->dateEnvoi = date('Y-m-d H:m:s');
            $campagneTable->save($campagne);

            $sms->etat = $response['status'];
            if($smsTable->save($sms)){
                foreach ($contacts as $ct){
                    $sms_contact = $smscontactTable->newEntity();
                    $sms_contact->sms_id = $sms->id;
                    $sms_contact->contact_id = $ct;
                    foreach ($response['smsIds'] as $re){
                        if ($re['phoneNumber'] == $ct){
                            $sms_contact->smsId = $re['smsId'];
                        }
                    }
                    $smscontactTable->save($sms_contact);
                }
                if ($verif == 1){
                    $smsmodele = $smsmodeleTable->newEntity();
                    $smsmodele->modelesms_id = $this->request->getData()['modele'];
                    $smsmodele->sms_id = $sms->id;
                    $smsmodeleTable->save($smsmodele);
                }
                if ( $response['status'] == 100){
                    $this->Flash->success('Votre Messagé été envoyé avec succès.');
                }elseif($response['status'] == 101){
                    $this->Flash->success('Votre Messagé été programmé avec succès.');
                }else{
                    $this->Flash->error($response['statusText']);
                }
                $this->_log('Envoi de sms pour la campagne '.$campagne->id);
                $this->redirect(['action' => 'sendSms']);
            }
        }
    }

    public function fastSendSms(){
        $contactTable = TableRegistry::get('Contacts');
        $apiTable = TableRegistry::get('api');
        $expediteurTable = TableRegistry::get('expediteurs');
        $smsTable = TableRegistry::get('smss');
        $smscontactTable = TableRegistry::get('contactsmss');

        $smsmodeleTable = TableRegistry::get('modelesmss_smss');

        $user = $this->Auth->user();
        if($user){
            $usersTable = TableRegistry::get('Users');
            $user = $usersTable->newEntity($user);
        }

        if($this->request->is('post')) {
            $api = $apiTable->find()
                ->where(
                    [
                        'etat' => "Actif",
                    ]
                )
                ->all();
            $api = $api->first();

            if ($api == null){
                $this->Flash->error('Aucune API n\'est active.');
                return $this->redirect(['controller' => 'Users','action' => 'profil']);
            }

            $texte = htmlspecialchars($this->request->getData()['contenu']);
            $verif = preg_match("#param_1#i", "'.$texte.'");

            $expediteur = $expediteurTable->get($this->request->getData()['idexpediteur']);
            $contact = $contactTable->get($this->request->getData()['idcontact']);

            $sms = $smsTable->newEntity();

            $sms->contenu = $this->request->getData()['contenu'];
            $sms->iduser = $user->id;
            $sms->idexpediteur = $expediteur->id;
            $sms->dateEnvoi = date('Y-m-d H:m:s');

            //config
            $url = $api->url; //'https://api.allmysms.com/http/9.0/sendSms/';
            $login = $api->login;   //votre identifant allmysms
            $apiKey = $api->apikey;    //votre mot de passe allmysms
            $message = $sms->contenu;   //le message SMS, attention pas plus de 160 caractères
            $sender = $expediteur->titre;  //l'expediteur, attention pas plus de 11 caractères alphanumériques
            //$msisdn  = $contact->telephone;   //numéro de téléphone du destinataire
            $smsData = "<DATA>
                               <MESSAGE><![CDATA[" . $message . "]]></MESSAGE>
                               <TPOA>$sender</TPOA>";
            if ($verif == 1){
                $smsData .= "<DYNAMIC>$verif</DYNAMIC>";
            }
                               $smsData .= "<SMS>
                                    <MOBILEPHONE>$contact->telephone</MOBILEPHONE>";
            if ($verif == 1){
                $smsData .= "<PARAM_1>$contact->nom</PARAM_1>";
            }
                               $smsData .= "</SMS>
                        </DATA>";
            $format = 'JSON';

            $fields = array(
                'login' => urlencode($login),
                'apiKey' => urlencode($apiKey),
                'returnformat' => urlencode($format),
                'smsData' => urlencode($smsData),
            );

            $fieldsString = "";
            foreach ($fields as $key => $value) {
                $fieldsString .= $key . '=' . $value . '&';
            }
            rtrim($fieldsString, '&');

            try {

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, count($fields));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $result = curl_exec($ch);

                //echo $result;

                curl_close($ch);

            } catch (Exception $e) {
                echo 'API injoignable ou trop longue a repondre ' . $e->getMessage();
            }

            $response = json_decode($result, true);

            $sms->etat = $response['status'];
            if ($smsTable->save($sms)) {
                $sms_contact = $smscontactTable->newEntity();
                $sms_contact->sms_id = $sms->id;
                $sms_contact->contact_id = $contact->id;
                foreach ($response['smsIds'] as $re) {
                    if ($re['phoneNumber'] == $contact->telephone) {
                        $sms_contact->smsId = $re['smsId'];
                    }
                }
                $smscontactTable->save($sms_contact);

                if ($verif == 1){
                    $smsmodele = $smsmodeleTable->newEntity();
                    $smsmodele->modelesms_id = $this->request->getData()['modele'];
                    $smsmodele->sms_id = $sms->id;
                    $smsmodeleTable->save($smsmodele);
                }
            }
            if ($response['status'] == 100) {
                $this->Flash->success('Votre Messagé été envoyé avec succès.');
            } elseif ($response['status'] == 101) {
                $this->Flash->success('Votre Messagé été programmé avec succès.');
            } else {
                $this->Flash->error($response['statusText']);
            }
        }
        $this->_log('Envoi rapide de sms '.$sms->id);
        return $this->redirect(['controller' => 'Users','action' => 'profil']);
    }

    public function receivedSms(){
        $smscontactTable = TableRegistry::get('contacts_smss');
        if ($this->request->is('get')) {
            $data = $this->request->params['?'];
            $sms_contact = $smscontactTable->find()
                ->where(
                    [
                        'smsId' => $data['smsId']
                    ]
                )
                ->all();
            $sms_contact = $sms_contact->first();
            $sms_contact->receptionDate = $data['receptionDate'];
            $sms_contact->status = $data['status'];
            $sms_contact->campaignId = $data['campaignId'];
            $smscontactTable->save($sms_contact);
            $this->_log('Réception de l\'accusé de réception '.$sms_contact->id);
        }
    }

    public function modelSms(){
        $modelesmsTable = TableRegistry::get('modelesmss');
        $user = $this->Auth->user();
        if($user){
            $usersTable = TableRegistry::get('Users');
            $user = $usersTable->newEntity($user);
        }

        $modelSms = $modelesmsTable->find()->all();
        $modelsms = $modelesmsTable->newEntity();
        $this->set(compact('modelsms'));
        $this->set(compact('modelSms'));
    }

    public function addModelSms(){
        if ($this->request->is('post')) {
            $modelesmsTable = TableRegistry::get('modelesmss');
            $modelesms = $modelesmsTable->newEntity($this->request->getData());
            if($modelesmsTable->save($modelesms)){
                $this->Flash->success('Modèle de message ajouté avec succès.');
                $this->_log('Ajout de modèle sms '.$modelesms->id);
                $this->redirect(['action' => 'modelSms']);
            }
        }
        $modelSms = $modelesmsTable->find()->all();
        $modelsms = $modelesmsTable->newEntity();
        $this->set(compact('modelsms'));
        $this->set(compact('modelSms'));

    }

    public function editModelSms(){
        if ($this->request->getQuery('modelsms') == false) {
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        } else {
            $id = (int)$this->request->getQuery('modelsms');
            $modelesmsTable = TableRegistry::get('modelesmss');
            $modelsms = $modelesmsTable->get($id);
            $this->set(compact('modelsms'));
            if (!$modelsms) {
                $this->Flash->error('ce modèle sms n\'existe pas.');
                $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            } else {
                if ($this->request->is(array('post', 'put'))) {
                    $modelsms = $modelesmsTable->newEntity($this->request->getData());
                    $modelsms->id = $id;
                    if ($modelesmsTable->save($modelsms)) {
                        $this->Flash->set('Votre modèle sms a été mise à jour avec succès.', ['element' => 'success']);
                        $this->_log('Modification d\'un modèle sms '.$modelsms->id);
                        $this->redirect(['action' => 'modelSms']);
                    } else {
                        $this->Flash->set('Certains champs ont été mal saisis', ['element' => 'error']);
                    }

                }
            }
            $modelSms = $modelesmsTable->find()->all();
            $this->set(compact('modelSms'));
            $this->render('model_sms');
        }
    }

    public function deleteModelSms(){
        if ($this->request->getQuery('modelsms') == false) {
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['Controller' => 'Users','action' => 'logout']);
        }else{
            $id = (int)$this->request->getQuery('modelsms');
            $modelesmsTable = TableRegistry::get('modelesmss');
            $modelesms = $modelesmsTable->get($id);
            if (!$modelesms) {
                $this->Flash->error('Ce modèle sms n\'existe pas.');
                $this->redirect(['Controller' => 'Users','action' => 'logout']);
            }else{
                $modelesmsTable->delete($modelesms);
                $this->Flash->set('Votre modèle sms a été supprimé avec succès.', ['element' => 'success']);
                    $this->_log('Suppression du modèle sms '.$modelesms->id);
                $this->redirect(['action' => 'modelSms']);
            }
        }
    }
}