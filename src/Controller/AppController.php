<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Psr\Log\LogLevel;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */

    public function initialize()
    {
        parent::initialize();
        
        date_default_timezone_set('Africa/Libreville');

        $this->loadComponent('RequestHandler', ['viewClassMap' => ['xlsx' => 'Cewi/Excel.Excel'], 'enableBeforeRedirect' => false]);
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index',
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'authError' => 'Enregistrez-vous ou Connectez-vous',
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password']
                ]
            ]
        ]);


        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');

        $allmysms = $this->getInfoApi();
        $this->set(compact('allmysms'));
    }

    static function change_format_date($date){
        $date = new \DateTime($date);
        $dayFormatter = new \IntlDateFormatter(
            'fr_FR',
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::MEDIUM,
            'Africa/Libreville',
            \IntlDateFormatter::GREGORIAN
        );
        $date = $dayFormatter->format($date);
        return $date;
    }

    static function format_telehone($telephone){
        /*
         * ZONE DE TEST - DEBUT
         *
         * IL SE POURRAI QUE L'ENCODAGE DE LA PAGE DE TRAITEMENT
         * N'EST PAS LE MEME QUE CELUI DU FICHIER EXCEL OU BIEN DE LA VUE
         * QUI RECOIT CES DONNEES.
         *
         * LE SCRIPT SUIVANT EST UNE SOLUTION AU PROBLEME EXCEPTIONNEL
         * QUAND IL S'AGIT DES NOMBRES A TRAITER.
         */

        $chaine_brute = str_split($telephone);
        $chaine_finale = '';
        $ensemble_entier = array("0","1","2","3","4","5","6","7","8","9");

        $j = 0;

        for($i = 0, $n = count($chaine_brute); $i < $n; ++$i)
        {
            if(in_array($chaine_brute[$i], $ensemble_entier))
            {
                $chaine_finale .= $chaine_brute[$i];
                $j++;
            }
        }

        //debug($chaine_finale);die;
        if ($j == 7) {
            $chaine_finale = '2410'.$chaine_finale;
            return $chaine_finale;
        }elseif ($j == 8) {
            $chaine_finale = '241'.$chaine_finale;
            return $chaine_finale;
        }elseif($j == 11) {
            return $chaine_finale;
        }else{
            return false;
        }
        /*
         * ZONE DE TEST - FIN
         */
    }

    public function _log($action = null)
    {
        $user = $this->Auth->user();
        if($user){
            $usersTable = TableRegistry::get('Users');
            if(is_array($user)){
                $user = $usersTable->newEntity($user);
            }
            $dir = WWW_ROOT . 'files' . DS ."logs".DS;
            $rotate = date("Ymd");
            $filename = $dir."log".$rotate.".txt";

            $log = date("d/m/Y h:i:s") . " -- ";
            $log .= $user->nom.' '.$user->prenom . " -- " . $action;

            $stream = @fopen($filename, "a");
            fputs($stream, $log . "\n");
            fclose($stream);
        }
    }

    public function getInfoApi(){
        $apiTable = TableRegistry::get('api');

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

        $url = 'http://api.allmysms.com/http/9.0/getInfo'; //'https://api.allmysms.com/http/9.0/sendSms/';
        $login = $api->login;   //votre identifant allmysms
        $apiKey  = $api->apikey;    //votre mot de passe allmysms

        $format = 'JSON';

        $fields = array(
            'login'    => urlencode($login),
            'apiKey'      => urlencode($apiKey),
            'returnformat' => urlencode($format),
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
            echo 'API injoignable ou trop longue a repondre ' . $e->getMessage();
        }

        $response = json_decode($result, true);

        return $response;
    }

    public function statSms(){

        $campagnesTable = TableRegistry::get('Campagnes');

        $date = date('Y-m-d H:i:s');
        $date = new \DateTime($date);

        $formatter_semaine = new \IntlDateFormatter("fr_FR", \IntlDateFormatter::FULL, \IntlDateFormatter::FULL, 'Africa/Libreville', \IntlDateFormatter::GREGORIAN, "EEEE");
        $formatter_semaine->setPattern("EEEE");
        $formatter_mois = new \IntlDateFormatter("fr_FR", \IntlDateFormatter::FULL, \IntlDateFormatter::NONE, 'Africa/Libreville', \IntlDateFormatter::GREGORIAN, "MMMM");
        $formatter_mois->setPattern("MMMM");

        $firstDay = new \DateTime("first day of this month");
        $data = array();
        $i = 1;

        $offset_depart = $date->format('Y-m-d H:i:s');
        $offset_fin = $firstDay->format('Y-m-d H:i:s');
        
        while ($i <= 12){
            $campagnes = $campagnesTable->find()
                ->where(
                    [
                        'dateEnvoi <=' => $offset_depart,
                        'dateEnvoi >=' => $offset_fin,
                    ]
                )->all();
            $nbre_sms = 0;
            foreach ($campagnes as $campagne){
                $nbre_sms += $campagne->nbre_envoye;
            }
            $key = $formatter_mois->format($firstDay);
            $data[$key] = $nbre_sms;
            $i++;
            $offset_depart = $offset_fin;
            $fin = $firstDay->modify('-1 month');
            $offset_fin = $fin->format('Y-m-d H:i:s');
        }
        $data = array_reverse($data, true);
        return $data;
    }

    public function age($datenaissance){
        $date = date('Y-m-d');
        $debut = new \DateTime($datenaissance);
        $fin = new \DateTime($date);
        $intervalle = $fin->diff($debut);
        $age = (int)$intervalle->y;
        return $age;
    }

    public function telephone($telephone){
        return $telephone;
    }

    public function convertCurrency($amount,$from_currency,$to_currency){
        $apikey = '6536845af5e03e808997d425d599ab30';

        $from_Currency = urlencode($from_currency);
        $to_Currency = urlencode($to_currency);
        $query =  "{$from_Currency}_{$to_Currency}";

        $json = file_get_contents("https://api.currencyconverterapi.com/api/v6/convert?q={$query}&compact=ultra&apiKey={$apikey}");
        $obj = json_decode($json, true);

        $val = floatval($obj["$query"]);


        $total = $val * $amount;
        return number_format($total, 2, '.', '');
    }

    public function isAdministrator(){
        $isAdministrator = true;
        $user = $this->Auth->user();
        if(isset($user) && $user != null){
            $usersTable = TableRegistry::get('Users');
            if(is_array($user)){
                $user = $usersTable->newEntity($user);
            }
            if($user->role != "Administrateur"){
                $isAdministrator = false;
                return $isAdministrator;
            }else{
                return $isAdministrator;
            }
        }else{
            $isAdministrator = false;
            return $isAdministrator;
        }
    }

    public function isSuperAdministrator(){
        $isSuperAdministrator = true;
        $user = $this->Auth->user();
        if(isset($user) && $user != null){
            $usersTable = TableRegistry::get('Users');
            if(is_array($user)){
                $user = $usersTable->newEntity($user);
            }
            if($user->role != "SuperAdministrateur"){
                $isSuperAdministrator = false;
                return $isSuperAdministrator;
            }else{
                return $isSuperAdministrator;
            }
        }else{
            $isSuperAdministrator = false;
            return $isSuperAdministrator;
        }
    }

    public function isAuthor($id){
        $isAuthor = true;
        $user = $this->Auth->user();
        if(isset($user) && $user != null){
            $usersTable = TableRegistry::get('Users');
            if(is_array($user)){
                $user = $usersTable->newEntity($user);
            }
            if($user->id != $id){
                $isAuthor = false;
                return $isAuthor;
            }else{
                return $isAuthor;
            }
        }else{
            $isAuthor = false;
            return $isAuthor;
        }
    }

    public function isAuthorized($user)
    {
        // Par défaut n'autorise pas
        if($user == null){
            
        }else{
            return true;
        }
    }
}
