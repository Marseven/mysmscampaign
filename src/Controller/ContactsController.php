<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\ContactsTable;
use App\Model\Table\ListecontactsTable;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

class ContactsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Cewi/Excel.Import');
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
        $title = 'Gestion des Contacts';
        $this->set('title', $title);

    }

    public function index()
    {
        $contactTable = TableRegistry::get('contacts');
        $contact = $contactTable->newEntity();
        $this->set(compact('contact'));
        $contacts = $contactTable->find()->all();
        $this->set(compact('contacts'));
    }

    public function addContact(){
        $contactTable = TableRegistry::get('contacts');
        if ($this->request->is('post')) {
            $nom_tel_existe = ContactsTable::nom_tel_existe($this->request->getData()['nom'], $this->request->getData()['telephone']);
            $nom_existe = ContactsTable::nom_existe($this->request->getData()['nom']);
            $tel_existe = ContactsTable::tel_existe($this->request->getData()['telephone']);
            if ($nom_tel_existe != false){
                $this->Flash->error('Le contact existe déjà.');
                $this->redirect(['action' => 'index']);
            }else{
                if ($tel_existe == false && $nom_existe != false){
                    $nom_existe->telephone = $this->request->getData()['telephone'];
                    if($contactTable->save($nom_existe)){
                        $this->Flash->success('Contact mis à jour avec succès.');
                        $this->_log('Mise à jour de contact '.$nom_existe->id);
                        $this->redirect(['action' => 'index']);
                    }
                }elseif($tel_existe != false && $nom_existe == false){
                    $tel_existe->nom = $this->request->getData()['nom'];
                    if($contactTable->save($tel_existe)){
                        $this->Flash->success('Contact mis à jour avec succès.');
                            $this->_log('Mise à jour de contact '.$tel_existe->id);
                        $this->redirect(['action' => 'index']);
                    }
                }elseif($tel_existe == false && $nom_existe == false){
                    $telephone = $this::format_telehone($this->request->getData()['telephone']);
                    if ($telephone == false) {
                            $this->Flash->error('Numéro de téléphone invalide.');
                            return $this->redirect(['action' => 'index']);
                        }
                    $contact = $contactTable->newEntity($this->request->getData());
                    $contact->telephone = $telephone;
                    if($contactTable->save($contact)){
                        $this->Flash->success('Contact ajouté avec succès.');
                        $this->_log('Création de contact '.$contact->id);
                        $this->redirect(['action' => 'index']);
                    }
                }
            }
        }
        $contacts = $contactTable->find()->all();
        $this->set(compact('contacts'));
        $contact = $contactTable->newEntity();
        $this->set(compact('contact'));
        $this->render('index');
    }

    public function editContact(){
        if ($this->request->getQuery('contact') == false) {
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        } else {
            $id = (int)$this->request->getQuery('contact');
            $contactTable = TableRegistry::get('contacts');
            $contact = $contactTable->get($id);
            if (!$contact) {
                $this->Flash->error('Ce contact n\'existe pas.');
                $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            } else {
                if ($this->request->is(array('post', 'put'))) {
                    $nom_tel_existe = ContactsTable::nom_tel_existe($this->request->getData()['nom'], $this->request->getData()['telephone']);
                    $nom_existe = ContactsTable::nom_existe($this->request->getData()['nom']);
                    $tel_existe = ContactsTable::tel_existe($this->request->getData()['telephone']);
                    if ($nom_tel_existe != false){
                        $this->Flash->error('Le contact existe déjà.');
                        $this->redirect(['action' => 'index']);
                    }else{
                        if ($tel_existe == false && $nom_existe != false){
                            $nom_existe->telephone = $this->request->getData()['telephone'];
                            if($contactTable->save($nom_existe)){
                                $this->Flash->success('Contact mis à jour avec succès.');
                                $this->_log('Mise à jour de contact '.$nom_existe->id);
                                $this->redirect(['action' => 'index']);
                            }
                        }elseif($tel_existe != false && $nom_existe == false){
                            $tel_existe->nom = $this->request->getData()['nom'];
                            if($contactTable->save($tel_existe)){
                                $this->Flash->success('Contact mis à jour avec succès.');
                                $this->_log('Mise à jour de contact '.$tel_existe->id);
                                $this->redirect(['action' => 'index']);
                            }
                        }elseif($tel_existe == false && $nom_existe == false){
                            $contact = $contactTable->newEntity($this->request->getData()['telephone']);
                            if($contactTable->save($contact)){
                                $this->Flash->success('Contact ajouté avec succès.');
                                $this->_log('Mise à jour de contact '.$contact->id);
                                $this->redirect(['action' => 'index']);
                            }else{
                                $this->Flash->set('Certains champs ont été mal saisis', ['element' => 'error']);
                            }
                        }
                    }
                }
            }
            $contacts = $contactTable->find()->all();
            $this->set(compact('contacts'));
            $this->set('contact', $contact);
            $this->render('index');
        }
    }

    public function deleteContact(){
        if($this->request->getQuery('contact') == false){
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['controller' => 'Users','action' => 'logout']);
        }else{
            $id = (int)$this->request->getQuery('contact');
            $contactTable = TableRegistry::get('contacts');
            $contact = $contactTable->get($id);
            if (!$contact) {
                $this->Flash->error('Ce contact n\'existe pas.');
                $this->redirect(['controller' => 'Users','action' => 'logout']);
            }else{
                $contactTable->delete($contact);
                $this->Flash->set('Votre contact a été supprimé avec succès.', ['element' => 'success']);
                $this->_log('Suppression du contact '.$contact->id);
                $this->redirect(['action' => 'index']);
            }
        }
    }

    public function viewList()
    {
        if ($this->request->getQuery('listecontact') == false) {
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        } else {
            $id = (int)$this->request->getQuery('listecontact');
            $listecontactTable = TableRegistry::get('listecontacts');
            $contactTable = TableRegistry::get('Contacts');
            $contact = $contactTable->newEntity();
            $this->set(compact('contact'));
            $contact_add = ContactsTable::contact();
            $this->set('contact_add', $contact_add);
            $listecontact = $listecontactTable->find()->where(
                [
                    'id' => $id,
                ]
            )->contain('contacts')->all();
            if (!$listecontact->first()) {
                $this->Flash->error('Ce contact n\'existe pas.');
                $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            } else {
                $listecontact = $listecontact->first();
                $this->set(compact('listecontact'));
            }
        }
    }

    public function retirerContact(){
        if($this->request->getQuery('contact') == false || $this->request->getQuery('listecontact') == false){
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['Controller' => 'Users','action' => 'logout']);
        }else{
            $id_contact = (int)$this->request->getQuery('contact');
            $id_liste = (int)$this->request->getQuery('listecontact');
            $listcontactTable = TableRegistry::get('contacts_listecontacts');
            $listcontact = $listcontactTable->find()->where(
                [
                    'contact_id' => $id_contact,
                    'listecontact_id' => $id_liste,
                ]
            )->all();
            if (!$listcontact->first()) {
                $this->Flash->error('Ce contact n\'appartient pas à cette liste de contact.');
                $this->redirect(['action' => 'viewList', 'listecontact' => $id_liste]);
            }else{
                $listcontactTable->delete($listcontact->first());
                $this->Flash->set('Le contact a été retiré avec succès.', ['element' => 'success']);
                $this->_log('Retrait de la liste de contact '.$id_liste.' du contact '.$id_contact);
                $this->redirect(['action' => 'viewList', 'listecontact' => $id_liste]);
            }
        }
    }

    public function ajouterContact(){
        if($this->request->getData()['contacts'] == false || $this->request->getQuery('listecontact') == false){
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['Controller' => 'Users','action' => 'logout']);
        }else{
            $id_liste = (int)$this->request->getQuery('listecontact');
            $listecontactTable = TableRegistry::get('contacts_listecontacts');
            $liste_contactTable = TableRegistry::get('listecontacts');
            $contactTable = TableRegistry::get('Contacts');
            $liste_contact = $liste_contactTable->get($id_liste);
            foreach ($this->request->getData()['contacts'] as $cnt){
                $id_contact = $cnt;
                $listcontact = $listecontactTable->find()->where(
                    [
                        'contact_id' => $id_contact,
                        'listecontact_id' => $id_liste,
                    ]
                )->all();
                $contact = $contactTable->get($id_contact);
                if (!$contact) {
                    $this->Flash->error('Ce contact n\'existe pas.');
                    $this->redirect(['Controller' => 'Users','action' => 'logout']);
                }else{
                    if ($listcontact->first()){
                        $this->Flash->set('Ce contact '.$contact->telephone.' fait déjà parti de cette liste de contact.', ['element' => 'success']);
                    }else{
                        $listecontact = $listecontactTable->newEntity();
                        $listecontact->contact_id = $id_contact;
                        $listecontact->listecontact_id = $id_liste;
                        if($listecontactTable->save($listecontact)){
                            $liste_contact->cotacts++;
                            $liste_contactTable->save($liste_contact);
                        }
                        $this->Flash->set('Le(s) contact(s) a été ajouté avec succès à cette liste.', ['element' => 'success']);
                        $this->_log('ajout à la liste de contact du contact '.$id_contact);
                    }
                }
            }
            $this->redirect(['action' => 'viewList', 'listecontact' => $id_liste]);
        }
    }

    public function createListContact(){
        $listecontactTable = TableRegistry::get('listecontacts');
        $liste_contactTable = TableRegistry::get('contacts_listecontacts');
        $contactTable = TableRegistry::get('Contacts');
        $user = $this->Auth->user();
        if(is_array($user)){
            $usersTable = TableRegistry::get('Users');
            $user = $usersTable->newEntity($user);
        }elseif (!is_array($user) && !is_object($user)) {
            $this->redirect(['Controller' => 'Users','action' => 'logout']);
        }
        if ($this->request->is('post')) {
            if(isset($this->request->getData()['listecontact']['name'])){
                $filename = $this->request->getData()['listecontact']['name'];
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $good_ext = in_array($extension, ['xlsx', 'csv']);
                if($good_ext){
                    $liste_nom_existe = ListecontactsTable::nom_existe($filename);
                    if ($liste_nom_existe){
                        $this->Flash->error('Cette liste de contact existe déjà. Veuillez choisir un autre nom pour cette liste');
                        return $this->redirect(['action' => 'createListContact']);
                    }
                    $data = $this->Import->prepareEntityData("files/listecontact/".$filename, ['worksheet'=> 0]);
                    if(key_exists(0, $data) && key_exists('TELEPHONE1', $data[0]) && key_exists('CLIENT', $data[0])){
                        move_uploaded_file($this->request->getData()['listecontact']['tmp_name'], "files/listecontact/".$filename);
                        $contacts = array();
                        $i=0;
                        $listecontact = $listecontactTable->newEntity();
                        $listecontact->libelle = $filename;
                        $listecontact->iduser = $user->id;
                        $listecontactTable->save($listecontact);
                        $this->_log('Création de la liste de contact '.$listecontact->id);
                        foreach($data as $d){
                            $d['TELEPHONE1'] = $this::format_telehone($d['TELEPHONE1']);
                            $nom_tel_existe = ContactsTable::nom_tel_existe($d['CLIENT'], $d['TELEPHONE1']);
                            $nom_existe = ContactsTable::nom_existe($d['CLIENT']);
                            $tel_existe = ContactsTable::tel_existe($d['TELEPHONE1']);
                            if ($nom_tel_existe == false){
                                if ($tel_existe == false && $nom_existe != false){
                                    $nom_existe->telephone = $d['TELEPHONE1'];
                                    if ($contactTable->save($nom_existe)){
                                        $contacts[$i] = $nom_existe;
                                        $this->_log('Mise à jour de contact '.$nom_existe->id);
                                        $i++;
                                    }
                                }elseif($tel_existe != false && $nom_existe == false){
                                    $tel_existe->nom = $d['CLIENT'];
                                    if ($contactTable->save($tel_existe)){
                                        $contacts[$i] = $tel_existe;
                                        $this->_log('Mise à jour de contact '.$tel_existe->id);
                                        $i++;
                                    }
                                }elseif($tel_existe == false && $nom_existe == false){
                                    $contact = $contactTable->newEntity();
                                    $contact->nom = $d['CLIENT'];
                                    $contact->telephone = $d['TELEPHONE1'];
                                    $contact->iduser = $user->id;
                                    if ($contactTable->save($contact)){
                                        $contacts[$i] = $contact;
                                        $this->_log('Création de contact '.$contact->id);
                                        $i++;
                                    }
                                }
                            }else{
                                $contacts[$i] = $nom_tel_existe;
                                $i++;
                            }
                        }
                        $listecontact->contacts = $i;

                        if($listecontactTable->save($listecontact)){
                            foreach ($contacts as $ct){
                                $liste_contact = $liste_contactTable->newEntity();
                                $liste_contact->contact_id = $ct->id;
                                $liste_contact->listecontact_id = $listecontact->id;
                                if ($liste_contactTable->save($liste_contact)){
                                    $this->_log('ajout à la liste de contact '.$liste_contact->id);
                                    $i++;
                                }
                            }
                            $this->Flash->success('Liste de contact ajouté avec succès.');
                            $this->_log('Mise à jour de la liste de contact '.$listecontact->id);
                            $this->redirect(['action' => 'viewList', 'listecontact' => $listecontact->id]);
                        }
                    }else{
                        $this->Flash->error('Champs manquants dans le fichier. Champs obligatoires : TELEPHONE1, CLIENT');
                        return $this->redirect(['action' => 'createListContact']);
                    }
                }else{
                    $this->Flash->error('Mauvais type de fichier importé. Type correct : xlsx, csv');
                    return $this->redirect(['action' => 'createListContact']);
                }
            }else{
                $liste_nom_existe = ListecontactsTable::nom_existe($this->request->getData()['libelle']);
                if ($liste_nom_existe){
                    $this->Flash->error('Cette liste de contact existe déjà. Veuillez choisir un autre nom pour cette liste');
                    $this->redirect(['action' => 'createListContact']);
                }else{
                    $listecontact = $listecontactTable->newEntity();
                    $listecontact->libelle = $this->request->getData()['libelle'];
                    $listecontact->iduser = $user->id;
                    $listecontactTable->save($listecontact);
                    $i=0;
                    foreach ($this->request->getData()['contacts'] as $ct){
                        $liste_contact = $liste_contactTable->newEntity();
                        $liste_contact->contact_id = $ct;
                        $liste_contact->listecontact_id = $listecontact->id;
                        if ($liste_contactTable->save($liste_contact)){
                            $this->_log('ajout à la liste de contact '.$liste_contact->id);
                            $i++;
                        }
                    }
                    $listecontact->contacts = $i;
                    if($listecontactTable->save($listecontact)){
                        $this->Flash->success('Liste de contact créé avec succès.');
                        $this->_log('Mise à jour de la liste de contact '.$listecontact->id);
                        $this->redirect(['action' => 'viewList', 'listecontact' => $listecontact->id]);
                    }
                }
            }
        }

        $listecontact = $listecontactTable->newEntity();
        $this->set(compact('listecontact'));
        $listecontacts = $listecontactTable->find()->contain('contacts')->all();
        //debug($listecontacts);die;
        $this->set(compact('listecontacts'));
        $contact_add = ContactsTable::contact();
        $this->set('contact_add', $contact_add);

    }

    public function deleteListContact(){
        if($this->request->getQuery('listecontact') == false){
            $this->Flash->error('Informations manquantes.');
            $this->redirect(['controller' => 'Users','action' => 'logout']);
        }else{
            $id = (int)$this->request->getQuery('listecontact');
            $listcontactTable = TableRegistry::get('listecontacts');
            $listcontact = $listcontactTable->get($id);
            if (!$listcontact) {
                $this->Flash->error('Cette liste de contact n\'existe pas.');
                $this->redirect(['controller' => 'Users','action' => 'logout']);
            }else{
                $listcontactTable->delete($listcontact);
                $this->Flash->set('La liste de contact a été supprimée avec succès.', ['element' => 'success']);
                $this->_log('Suppression de la liste de contact '.$listcontact->id);
                $this->redirect(['action' => 'createListContact']);
            }
        }
    }
}