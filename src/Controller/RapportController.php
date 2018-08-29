<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Psr\Log\LogLevel;

Configure::write('CakePdf', [
    'engine' => 'CakePdf.Mpdf',
    'margin' => [
        'bottom' => 15,
        'left' => 50,
        'right' => 30,
        'top' => 45
    ],
    'orientation' => 'portrait',
    'download' => true
]);


class RapportController extends AppController
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
        $campagne = $campagneTable->find()->all();
        $camp_count = $campagne->count();
        $this->set('camp_count', $camp_count);
    }

    public function index()
    {
        $title = 'Statistiques des Campagnes';
        $this->set('title', $title);

        $campagneTable = TableRegistry::get('campagnes');
        //$contactTable = TableRegistry::get('Contacts');
        $smsTable = TableRegistry::get('smss');
        $contactsmsTable = TableRegistry::get('contactsmss');

        $campagnes = $campagneTable->find()->contain(['Users', 'Smss'])->all();
        //$contacts = $contactTable->find()->contain(['Users', 'Smss'])->all();
        $contactsms = $contactsmsTable->find()->contain('Smss')->all();
        $this->set('contactsms', $contactsms);
        //debug($contactsms);
        $pourcentage = array();
        foreach ($campagnes as $camp){
            $nbre_envoye = 0;
            $nbre_programme = 0;
            $nbre_echec = 0;
            $i=0;
            foreach ($camp->smss as $ms){
                if ($ms->etat == 100){
                    $nbre_envoye++;
                }elseif ($ms->etat == 101){
                    $nbre_programme++;
                }else{
                    $nbre_echec++;
                }
                $i++;
            }
            $nbre_envoye = ($nbre_envoye/$i)*100;
            $nbre_programme = ($nbre_programme/$i)*100;
            $nbre_echec = ($nbre_echec/$i)*100;

            $pourcentage[$camp->id]['envoye'] = $nbre_envoye;
            $pourcentage[$camp->id]['programme'] = $nbre_programme;
            $pourcentage[$camp->id]['echec'] = $nbre_echec;
        }

        $this->set('camp_js', $campagnes);
        $this->set(compact('pourcentage'));
        $this->set(compact('campagnes'));
    }

    public function statistiques(){

        $title = 'Statistiques';
        $this->set('title', $title);

        $userTable = TableRegistry::get('Users');
        $contactTable = TableRegistry::get('Contacts');
        $listecontactTable = TableRegistry::get('Listecontacts');
        $apiTable = TableRegistry::get('api');
        $expediteurTable = TableRegistry::get('expediteurs');
        $campagneTable = TableRegistry::get('campagnes');
        $smsTable = TableRegistry::get('smss');
        $smscontactTable = TableRegistry::get('contactsmss');
        $smsmodeleTable = TableRegistry::get('modelesmss_smss');
        $modeleTable = TableRegistry::get('modelesmss');
        $contact_listeTable = TableRegistry::get('contacts_listecontacts');

        $users = $userTable->find()->where(
            [
                'role' => 'Utilisateur'
            ])->all();
        $this->set(compact('users'));

        $campagnes = $campagneTable->find()->contain(['Users', 'Smss'])->all();
        $this->set(compact('campagnes'));

        $contacts = $contactTable->find()->contain(['Users', 'Listecontacts'])->all();
        $this->set(compact('contacts'));

        $listecontacts = $listecontactTable->find()->contain(['Users', 'Contacts'])->all();
        $this->set(compact('listecontacts'));

        $apis = $apiTable->find()->contain('Users')->all();
        $this->set(compact('apis'));

        $expediteurs = $expediteurTable->find()->contain(['Users', 'Smss'])->all();
        $this->set(compact('expediteurs'));

        $sms = $smsTable->find()->contain(['Users', 'Modelesmss', 'Expediteurs', 'Campagnes'])->all();
        $this->set(compact('sms'));

        $sms_contacts = $smscontactTable->find()->all();
        $this->set(compact('sms_contacts'));

        $sms_modeles = $smsmodeleTable->find()->all();
        $this->set(compact('sms_modeles'));

        $modeles = $modeleTable->find()->contain(['Users', 'Smss'])->all();
        $this->set(compact('modeles'));

        $liste_contacts = $contact_listeTable->find()->all();
        $this->set(compact('liste_contacts'));

        $data = $this->statSms();
        $this->set(compact('data'));
    }

    public function logger(){
        $title = 'Log';
        $this->set('title', $title);
        $campagneTable = TableRegistry::get('campagnes');
        $campagnes_today = $campagneTable->find()->contain(['Users', 'Smss'])
            ->where([
                'campagnes.dateCreation >=' => date('Y-m-d')
            ])
            ->all();

        $weekDay = new \DateTime(date('Y-m-d'));
        $monthDay = clone $weekDay;

        $weekDay->modify("-7 days");
        $monthDay->modify("-30 days");

        $weekDay = $weekDay->format('Y-m-d');
        $monthDay = $monthDay->format('Y-m-d');

        $campagnes_week = $campagneTable->find()->contain(['Users', 'Smss'])
            ->where([
                'campagnes.dateCreation <' => date('Y-m-d'),
                'campagnes.dateCreation >' => $weekDay,
            ])
            ->all();
        $campagnes_month = $campagneTable->find()->contain(['Users', 'Smss'])
            ->where([
                'campagnes.dateCreation >' => $monthDay,
                'campagnes.dateCreation <' => $weekDay,
            ])
            ->all();
        $this->set(compact('campagnes_today'));
        $this->set(compact('campagnes_week'));
        $this->set(compact('campagnes_month'));

    }

    public function downloadLog()
    {
        if ($this->request->getQuery('date') == false) {
            $this->Flash->error('Information manquante.');
            $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        } else {
            $date=new \DateTime($this->request->getQuery('date'));
            $date = $date->format('Ymd');
            $log_exist = file_exists(WWW_ROOT . 'files' . DS . 'logs/log'.$date.'.txt');
            if($log_exist){
                $this->redirect('http://mysmscampaign.jobs-conseil.com/files/logs/log'.$date.'.txt');
            }else{
                $this->Flash->error('Le log demandé n\'existe pas.');
                $this->redirect(['action' => 'logger']);
            }

        }
    }

    public function imprimer(){
        if($this->request->getQuery('campagne') == false){
            $this->Flash->error('Information manquante.');
            $this->redirect(['controller' => 'Users','action' => 'logout']);
        }else{
            $campagneTable = TableRegistry::get('campagnes');
            $campagne = $campagneTable->find()->contain(['Smss'])
                ->where(
                    [
                        'id' => $this->request->getQuery('campagne'),
                    ]
                )
                ->all();

            if (!$campagne->first()) {
                $this->Flash->error('Cette reservation n\'existe pas.');
                $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            } else {
                $campagne = $campagne->first();
                $nbre_envoye = 0;
                $nbre_programme = 0;
                $nbre_echec = 0;
                $i=0;
                $pourcentage = array();
                //debug($campagne);die;
                foreach ($campagne->smss as $ms){
                    if ($ms->etat == 100){
                        $nbre_envoye++;
                    }elseif ($ms->etat == 101){
                        $nbre_programme++;
                    }else{
                        $nbre_echec++;
                    }
                    $i++;
                }
                $p_nbre_envoye = ($nbre_envoye/$i)*100;
                $p_nbre_programme = ($nbre_programme/$i)*100;
                $p_nbre_echec = ($nbre_echec/$i)*100;
                $nbre_sms = $i;

                $pourcentage[$campagne->id]['envoye'] = $p_nbre_envoye;
                $pourcentage[$campagne->id]['programme'] = $p_nbre_programme;
                $pourcentage[$campagne->id]['echec'] = $p_nbre_echec;

                $titre = "Rapport de la campagne N° ".$campagne->id;
                $date = date('YmdHis');
                $this->viewBuilder()->setOptions([
                    'pdfConfig' => [
                        'orientation' => 'portrait',
                        'filename' => 'Rapport_Campagne'.$campagne->id.'_'.$date
                    ]
                ]);
                $this->set([
                    'campagne' => $campagne,
                    'pourcentage' => $pourcentage,
                    'nbre_sms' => $nbre_sms,
                    'nbre_programme' => $nbre_programme,
                    'nbre_echec' => $nbre_echec,
                    'nbre_envoye' => $nbre_envoye,
                ]);
                $this->set('titre', $titre);
                $CakePdf = new \CakePdf\Pdf\CakePdf();
                $CakePdf->template('printed', 'default');
                $CakePdf->viewVars($this->viewVars);
                // Get the PDF string returned
                $pdf = $CakePdf->output();
                $pdf = $CakePdf->write(WWW_ROOT . 'files' . DS . 'Rapport_Campagne'.$campagne->id.'_'.$date.'.pdf');
                $this->redirect('http://mysmscampaign.jobs-conseil.com/files/Rapport_Campagne'.$campagne->id.'_'.$date.'.pdf');
            }
        }
    }
}