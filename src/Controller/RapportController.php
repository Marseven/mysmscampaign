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
        if (!$this->isAdministrator() && !$this->isSuperAdministrator()){
            $this->Flash->error("Vous n'etes pas Administrateur, Espace reserve aux Administrateurs.");
            return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        }
        $this->Auth->allow(['index']);
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
    }

    public function index()
    {
        $title = 'Statistiques des Campagnes';
        $this->set('title', $title);

        $campagneTable = TableRegistry::get('campagnes');
        $contactsmsTable = TableRegistry::get('contactsmss');

        $campagnes = $campagneTable->find()->contain(['Users', 'Smss'])->all();
        $contactsms = $contactsmsTable->find()->contain('Smss')->all();
        $contacts = array();
        $i=0; $telephone = ""; $j=0;
        foreach($campagnes as $cpg){
            foreach($contactsms as $contact){
                if ($contact->sms->idcampagne == $cpg->id){
                    if($telephone == "" && $i == 0){
                        
                        $contacts[$j]['telephone'] = $contact->contact_id;
                        $contacts[$j]['contenu'] = $contact->sms->contenu;
                        $contacts[$j]['etat'] = $contact->sms->etat;
                        $contacts[$j]['dateEnvoi'] = $contact->sms->dateEnvoi;
                        $contacts[$j]['idcampagne'] = $cpg->id;
                        $j++;
                    }elseif ($telephone != $contact->contact_id && $i != 0){
                        
                        $contacts[$j]['telephone'] = $contact->contact_id;
                        $contacts[$j]['contenu'] = $contact->sms->contenu;
                        $contacts[$j]['etat'] = $contact->sms->etat;
                        $contacts[$j]['dateEnvoi'] = $contact->sms->dateEnvoi;
                        $contacts[$j]['idcampagne'] = $cpg->id;
                        $j++;
                    }
                }  
            }
        }
                                                            
        $pourcentage = array();
        foreach ($campagnes as $camp){
            $reponse_sms = $contactsmsTable->find()->contain(['Smss'])
                ->where(
                    [
                        'campaignId' => $camp->campaignId ,
                    ]
                )
                ->all();

            $nbre_envoye = 0;
            $nbre_non_envoye = 0;
            $nbre_echec = 0;
            $i=0;
			
			$pourcentage[$camp->id]['envoye'] = 0;
	        $pourcentage[$camp->id]['non_envoye'] = 0;
	        $pourcentage[$camp->id]['echec'] = 0;
	        $pourcentage[$camp->id]['message_emis'] = 0;
            
            foreach ($camp->smss as $ms){

                foreach ($reponse_sms as $rs){

                    if ($ms->id == $rs->sms_id){

                        $smsId = $rs->smsId;

                        if ($rs->status == 1){
                            $nbre_envoye++;
                        }elseif ($rs->status == 2 || $rs->status == 3){
                            $nbre_non_envoye++;
                        }elseif ($rs->status == 4 || $rs->status == 5){
                            $nbre_echec++;
                        }else{
                            $nbre_non_envoye++;
                        }
                        $i++;
                    }
                }

                if ($i != 0) {
                    $p_nbre_envoye = ($nbre_envoye/$i)*100;
                    $p_nbre_non_envoye = ($nbre_non_envoye/$i)*100;
                    $p_nbre_echec = ($nbre_echec/$i)*100;
                    $nbre_message_emis = $i;
                }else{
                    $p_nbre_envoye = 0;
                    $p_nbre_non_envoye = 0;
                    $p_nbre_echec = 0;
                    $nbre_message_emis = $i;
                }

                $pourcentage[$camp->id]['envoye'] += $p_nbre_envoye;
                $pourcentage[$camp->id]['non_envoye'] += $p_nbre_non_envoye;
                $pourcentage[$camp->id]['echec'] += $p_nbre_echec;
                $pourcentage[$camp->id]['message_emis'] += $nbre_message_emis;

            }

        }

        $this->set('camp_js', $campagnes);
        $this->set(compact('contacts'));
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
       if(!empty($campagnes_today->items)){
           $this->set(compact('campagnes_today'));
       }
        if(!empty($campagnes_week->items)){
            $this->set(compact('campagnes_week'));
        }
        if(!empty($campagnes_month->items)){
            $this->set(compact('campagnes_month'));
        }

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
                $this->redirect('https://setrag-info.com/files/logs/log'.$date.'.txt');
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
            $smscontactTable = TableRegistry::get('contactsmss');

            $campagne = $campagneTable->find()->contain(['Smss'])
                ->where(
                    [
                        'id' => $this->request->getQuery('campagne'),
                    ]
                )
                ->all();

            if (!$campagne->first()) {
                $this->Flash->error('Cette campagne n\'existe pas.');
                $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            } else {

                $campagne = $campagne->first();

                $reponse_sms = $smscontactTable->find()->contain(['Smss'])
                    ->where(
                        [
                            'campaignId' => $campagne->campaignId ,
                        ]
                    )
                    ->all();

                $nbre_envoye = 0;
                $nbre_non_envoye = 0;
                $nbre_echec = 0;
                $i=0;
                $j=0;

                $pourcentage = array();
                $statistiques_SMS = array();
                $data_SMS = array();
                $data_SMS['sms_envoye'] = $campagne->nbre_envoye;
                $data_SMS['sms_recu'] = 0;
                $data_SMS['sms_non_delivre'] = 0;
                $data_SMS['sms_sans_accuse'] = 0;
                $data_SMS['npai'] = $campagne->nbre_echec;

                foreach ($campagne->smss as $ms){
                	$smsId = NULL;
                    foreach ($reponse_sms as $rs){

                        if ($ms->id == $rs->sms_id){

                            $smsId = $rs->smsId;

                            if ($rs->status == 1){
                                $nbre_envoye++;
                            }elseif ($rs->status == 2 || $rs->status == 3){
                                $nbre_non_envoye++;
                            }elseif ($rs->status == 4 || $rs->status == 5){
                                $nbre_echec++;
                            }else{
                                $nbre_non_envoye++;
                            }

                            if ($rs->status == 1){
                                $data_SMS['sms_recu']++;
                            }elseif ($rs->status == 2){
                                $data_SMS['sms_non_delivre']++;
                            }else{
                                $data_SMS['sms_sans_accuse']++;
                            }
                            $i++;
                        }
                    }
                    $j++;

                    if ($i != 0) {
                        $p_nbre_envoye = ($nbre_envoye/$i)*100;
                        $p_nbre_non_envoye = ($nbre_non_envoye/$i)*100;
                        $p_nbre_echec = ($nbre_echec/$i)*100;
                        $nbre_message_emis = $i;
                    }else{
                        $p_nbre_envoye = 0;
                        $p_nbre_non_envoye = 0;
                        $p_nbre_echec = 0;
                        $nbre_message_emis = $i;
                    }

                    $pourcentage[$campagne->id][$j]['envoye'] = $p_nbre_envoye;
                    $pourcentage[$campagne->id][$j]['non_envoye'] = $p_nbre_non_envoye;
                    $pourcentage[$campagne->id][$j]['echec'] = $p_nbre_echec;
                    $pourcentage[$campagne->id][$j]['message_emis'] = $nbre_message_emis;


                    $statistiques_SMS[$j]['id'] = $smsId;
                    $statistiques_SMS[$j]['nbre_caratere'] = strlen($ms->contenu);
                    $statistiques_SMS[$j]['mot'] = str_word_count($ms->contenu);
                    
                    $statistiques_SMS[$j]['paragraphe'] = substr_count($ms->contenu, '\r');
                    $statistiques_SMS[$j]['ligne'] = substr_count($ms->contenu, '\n');

                    if ($statistiques_SMS[$j]['paragraphe'] == 0) {
                    	$statistiques_SMS[$j]['paragraphe'] = 1;
                    }

                    if ($statistiques_SMS[$j]['ligne'] == 0) {
                    	$statistiques_SMS[$j]['ligne'] = 1;
                    }
                }


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
                    'reponse_sms' => $reponse_sms,
                    'pourcentage' => $pourcentage,
                    'statistiques_SMS' => $statistiques_SMS,
                    'data_SMS' => $data_SMS,
                ]);

                $this->set('titre', $titre);
                $CakePdf = new \CakePdf\Pdf\CakePdf();
                $CakePdf->template('printed', 'default');
                $CakePdf->viewVars($this->viewVars);

                // Get the PDF string returned
                $pdf = $CakePdf->output();
                $pdf = $CakePdf->write(WWW_ROOT . 'files' . DS . 'Rapport_Campagne'.$campagne->id.'_'.$date.'.pdf');
                $this->redirect('https://setrag-info.com/files/Rapport_Campagne'.$campagne->id.'_'.$date.'.pdf');
            }
        }
    }
}
