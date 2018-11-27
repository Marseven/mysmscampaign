<style>
 p, li{
    color: black;
    font-size: 15px; 
 }

h1 {
	font-size: 2em;
}
 img, .span{
    margin-left:4%;
 }
</style>
<div class="row">

    <div class="col-lg-12">
        <div class="card-box" style="padding:40px;">
            <h3 class="header-title m-t-0 m-b-30">Guide D'utilisation</h3>

            <h1 style="text-align:center;">INTRODUCTION</h1>
<br>
<p>Ce guide d’utilisation de l’application Web Setrag-Info s’adresse aux agents de Setrag qui interagiront avec l’application dans le cadre de la communication avec les clients.</p> 
<p>L’application Setrag-Info vous permet d’envoyer des SMS mobiles aux destinataires choisis, elle permet également de gérer différentes campagnes d’envoi de messages. Par ailleurs il est possible de gérer des contacts et créer des modèles de SMS prêts pour l’envoi. Un module de gestions des utilisateurs adapté aux règles de Setrag a également implémenté pour que l’application réponde au mieux au besoin de Setrag. Sans oublier la possibilité d’imprimer des rapports, les statistiques de campagnes et un fichier log d’utilisation de l’application.</p>
<p>Dans ce guide d’utilisation, vous trouverez toutes les informations nécessaires pour vous familiariser avec l’application. </p>
<p>Dans ce guide nous débuterons par des prérequis nécessaires quant à l’utilisation de l’application, de l’accès à l’application. Ensuite, nous nous focaliserons sur les différentes fonctionnalités de l’application Setrag-Info. Vous y trouverez une multitude de conseils afin d’utiliser l’application correctement. </p>
 <br><br>

<h1 style="text-align:center;">I.  PREREQUIS</h1>
<br>
<p>Afin d’utiliser l’application Setrag-Info, nous vous recommandons de suivre les conseils suivants : </p>
<ul>
<li>INTERNET : une connexion à Internet est indispensable. Il est possible que la connexion soit limitée à votre Intranet si l’application est installée dans un serveur local ; néanmoins le serveur lui devra obligatoirement avoir accès à internet. Votre service informatique doit vous donner accès aux domaines nécessaires pour utiliser Setrag-Info. </li>
<li>NAVIGATEUR : Le fonctionnement optimal de Setrag-Info suppose l’utilisation des navigateurs sur ordinateur. Les navigateurs conseilles sont : Chrome, Firefox.</li>
<li>COMPTE UTILISATEUR : disposer d’un compte utilisateur ou administrateur dans la base de données de l’application afin de permettre votre identification et vous accorder l’autorisation d’utiliser l’application. Ce compte est créé par le super administrateur ou l’administrateur de l’application. </li>
</ul>

<p><strong>NB :</strong></p>
<p>Il existe 3 types de profil dans l’application :  </p>
<ul>
<li> Utilisateur standard : Seuls les collaborateurs enregistrés pour utiliser l’application Setrag-Info, ont un accès. Ils peuvent envoyer des SMS, gérer des campagnes et gérer des contacts et listes de contacts. </li>
<li> Administrateur : il bénéficie des droits d’un utilisateurs standard mais il le control total sur l’application.</li>
<li> Super Administrateur : il a les même droit qu’un administrateur mais il peut également supprimer un administrateur. Il n’y a qu’un seul Super Administrateur dans l’application. </li>
</ul>


 <br><br>

<h1 style="text-align:center;">II. PRESENTATION GENERALE DE L’APPLICATION</h1>
<br>

<p>Setrag-Info dispose de 6 principales fonctionnalités : </p>
<ul>
<li>SMS</li>
<li>Campagnes</li>
<li>Contacts</li>
<li>Rapports</li>
<li>API</li>
<li>Utilisateurs</li>
</ul>
<p>Ces fonctionnalités ont été développé en fonction des besoins de Setrag et y répondent de ce fait. Elles seront présentées tout au long de ce document. Elles ont été testées mais aucune œuvre humaine n’étant parfaite, nous vous prions de bien vouloir nous contacter en cas de difficultés ou de bug notoire lors de l’utilisation de l’application. Nous sommes disponibles par mail à l’adresse suivante : support@jobs-conseil.com et aux numéros de téléphone : +241 04 22 83 06 - +241 07 75 07 37.</p>
 <br><br>

<h1 style="text-align:center;">III.    TABLEAU DE BORD</h1>
<br>
<p>Pour commencer il faut tout d’abord s’identifier pour pouvoir accéder à l’application ; le lien d’accès est : http://setrag-info.com </p>

<?= $this->Html->image('login.png', ['alt' => 'Page de connexion', 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 1: Page de connexion</em></span><br><br>

<p>Pour s’identifier il faut saisir l’adresse mail de votre compte et le mot de passe. Ensuite vous serrez diriger vers le tableau de bord, si vous êtes administrateur ou super administrateur ou vers la page d’envoi de SMS si vous êtes utilisateur standard.</p>


<?= $this->Html->image('SendSms.png', ['alt' => "Page d'envoi de SMS", 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 2: Page d'envoi de SMS</em></span><br><br>

<?= $this->Html->image('dashboard.png', ['alt' => 'Tableau de Bord', 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 3: Tableau de Bord</em></span><br><br>


<p>Le tableau de bord permet d’avoir un coup d’œil coup d’œil des chiffres important de l’application. Parmi les éléments affichés : </p> 
<ul>
<li>Le nombre de contact enregistrés</li>
<li>Les campagnes programmées</li>
<li>Le nombre de SMS envoyés au cours de la semaine actuelle</li>
<li>Le cout moyen d’une campagne   </li>
</ul>
<p>Il affiche également des graphes représentatifs sur les statistiques des SMS de l’application. Il y a aussi les 5 derniers modèles de SMS enregistrés et 5 dernières campagnes effectuées.  </p>
<br><br>
<h1 style="text-align:center;">IV. SMS</h1>
<br>
<p>La fonctionnalité SMS est la fonctionnalité de base de l’application. Elle permet d’envoyer un message texte a un ou plusieurs contacts enregistrés ou pas. C’est également à ce niveau qu’est gérer les modèles de SMS prédéfinis.</p>
<br>
<h2>1-  Envoi de SMS</h2>
<br>

<?= $this->Html->image('SendSms.png', ['alt' => "Page d'envoi de SMS", 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 4: Page d'envoi de SMS</em></span><br><br>

<p>La page d’envoi de SMS présente un formulaire, repartie en 3 parties :</p>
<ol>
<li>Message : dans cette partie qu’on a la possibilité de choisir un modèle prédéfini ou de rédiger un message contenant 480 caractères maximum. L’expéditeur par défaut de l’application est bien sur Setrag et ne peut être modifié.</li>
<li>Destinataire : on a la possibilité ici de définir le ou les destinataires du message. On peut saisir les numéros de téléphone mobile sous la forme : 24101020304 ; et les sépare en appuyant la touche Entrer. On peut aussi choisir une liste de contact déjà créé où choisir une liste de contact en xlsx ou csv. Au cas où la liste est choisie un seul cas sera pris en compte soit la liste créée, soit le fichier de contact. Le fichier est prioritaire si les deux sont remplis.</li>
<li>Option d’envoi : ici on choisit sous quel campagne le message doit être envoyé, on a la possibilité de créer une nouvelle campagne ou de choisir une campagne déjà existante. Et on choisit à quel moment le message doit être envoyé, soit immédiatement ou ultérieurement.</li>
</ol>
<br><br>
<h2>2-  Modèles SMS</h2>

<br>

<?= $this->Html->image('ModeleSms.png', ['alt' => 'Page de Modele de SMS', 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 5: Page de Modele de SMS</em></span><br><br>

<p>C’est dans cet espace que les messages prédéfinis sont créés. Pour la création il suffit de remplir le formulaire d’ajout de modèle de SMS. Lors de la création il y a la possibilité de mettre un paramètre nom, qui sera remplacé dynamiquement par le nom du contact s’il en a un. Il y a également la liste des modèles déjà créés, il y a la possibilité de modifier ou de supprimer un modèle.</p>
 
<br><br>
<h1 style="text-align:center;">V.  CAMPAGNES</h1>
<br>
<p>C’est dans cet espace que les campagnes sont gérés. Il est possible de créer une campagne, de la modifier, la supprimer au cas où c’est l’auteur ou le Super Administrateur qui est connecté. Pour créer une campagne, il suffit de remplir le titre de la campagne et de donner la date d’envoi de la campagne, bien sur la date doit être une date future. Il n’est pas judicieux de modifier la date d’envoi d’une campagne déjà réalisée. Il y a également la possibilité de voir la liste de campagne programmée.</p>


<?= $this->Html->image('campagne.png', ['alt' => 'Page des campagnes', 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 6: Page des campagnes</em></span><br><br>

<?= $this->Html->image('programmation.png', ['alt' => 'Page des campagnes programmees', 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 7: Page des campagnes programmees</em></span><br><br>
 

 <br><br>
<h1 style="text-align:center;">VI. CONTACTS</h1>
<br>
<p>Cette fonctionnalité permet de gérer tous les aspects relatifs aux contacts dans l’application. Cette fonctionnalité compte 2 parties la gestion des contacts et la gestion des listes de contacts.</p>
<br>
<h2>1-  Gestion des contacts</h2>
<br>

<?= $this->Html->image('contacts.png', ['alt' => 'Page des contacts', 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 8: Page des contacts</em></span><br><br>

<p>La gestion des contacts est très simple, pour créer un contact il suffit de remplir son nom et son numéro de téléphone au niveau du formulaire d’ajout de contact. Le numéro de téléphone doit être au format 24101020304, sinon il ne sera tout simplement pas admis. La modification et la suppression ne peuvent être effectue que par l’auteur et le super administrateur. Setrag-Info n’accepte pas de doublon de numéro de téléphone.</p>
<br><br>
<h2>2-  Gestion des listes de contacts</h2>
<br>
<p>Une liste de contacts est un ensemble de contacts. Une liste de contacts est unique au niveau du nom de la liste. Pour créer une liste de contacts il faut remplir le titre de la liste et choisir les contacts qui feront parties de la liste qui est créée. Lorsqu’une liste est créée, il est possible de la visualiser, d’y ajouter des contacts, d’en retirer, de la modifier et de la supprimer. Les actions d’ajout de contacts, de retrait de contacts, de modification et de suppression ne peuvent être réalisé que par l’auteur ou le super administrateur.</p>

<?= $this->Html->image('listeContacts.png', ['alt' => 'Page des listes de contacts', 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 9: Page des listes de contacts</em></span><br><br>

<p>Il est également possible d’importer une liste de contact par fichier xlsx ou csv. Pour les précisions concernant comment le fichier doit être, veuillez regarder le lien au niveau de l’annexe. </p>
<br><br>
<h1 style="text-align:center;">VII-    RAPPORTS</h1>
<br>
<p>C’est à ce niveau que l’on peut visualiser les rapports de campagnes, les statistiques globales de l’application et le log d’action dans l’application. Cette fonctionnalité n’est réserve qu’aux administrateur et au super administrateur.</p>
<br>
<h2>1-  Campagnes</h2>
<br>
<p>C’est dans cet espace que tous rapports de campagnes sont disponibles. Nous avons tout d’abord la liste des campagnes. Pour visualiser le rapport d’une campagne, il suffit de cliquer sur le bouton visualiser dans la colonne action. Dans la table de rapport il y a 4 onglets : </p>
<ul>
<li>Détails de campagne : qui présente les informations de base la campagne à savoir la référence de la campagne, la date de création, la date d’envoi des SMS, le nombre de contacts de la campagne et le nombre de SMS.  </li>
<li>Statistiques : c’est ici que nous avons le pourcentage de SMS envoyé, de SMS programme et de SMS non envoyé.</li>
<li>Liste des numéros : la liste des contacts ou numéros à qui le ou les SMS ont été envoyés.</li>
<li>Rapport : pour télécharger le rapport en xlsx ou PDF.</p>
</ul>




<?= $this->Html->image('StatCamp1.png', ['alt' => 'Page de connexion', 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 10: Page de Rapport de campagne</em></span><br><br>




<?= $this->Html->image('StatCamp2.png', ['alt' => 'Page de connexion', 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 11: Page de Rapport de Campagne</em></span><br><br>


<br><br>
<h2>2-  Statistiques</h2>
<br>
<p>C’est l’ensemble des statistiques globale de l’application. Il s’agit du nombre total des différentes entités de l’application. Il y a également un graphe représentant le nombre de SMS envoyé par mois sur les 12 derniers mois.</p>

<?= $this->Html->image('Statistiques.png', ['alt' => 'Page de Statistiques', 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 12: Page de Statistiques</em></span><br><br>


<br><br>
<h2>3-  Log</h2>
<br>
<p>C’est dans cette page que l’on peut télécharger les logs d’utilisation de l’application. Pour télécharger un log, il suffit de choisir une date ultérieure ou la date du jour et de cliquer sur <strong>Télécharger</strong>. Il y a également un time line des campagnes jusqu’au mois derniers. </p>

 <br><br>
<?= $this->Html->image('Log.png', ['alt' => 'Page de Log', 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 13: Page de Log</em></span><br><br>

<h1 style="text-align:center;">VIII-   API</h1>
<br>
<p>Cette fonctionnalité permet de connecter des services web d’envoi de messages. Pour l’ajout d’un compte API, il faut remplir le formulaire de d’ajout. Les informations nécessaires vous seront remis par le service utilisé. La modification et la suppression sont effectué par l’auteur et le super administrateur. Cette espace n’est accessible qu’aux administrateurs et aux super administrateurs.</p>

<br><br>
 
<?= $this->Html->image('Api.png', ['alt' => 'Page de API ', 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 14: Page de API</em></span><br><br>

<h1 style="text-align:center;">IX- UTILISATEURS</h1> 
<br>
<p>C’est au niveau de cette fonctionnalité que les utilisateurs et profils sont gérés. Il est possible ici de créer un utilisateur, le modifier et le supprimer. Les actions et fonctionnalités d’un utilisateur dépendent de son profil. </p>
<ul>
<li>-   Créer un utilisateur : Pour créer un utilisateur il faut remplir le formulaire de création avec les informations de l’utilisateur. Un mail sera envoyé à l’utilisateur crée pour qu’il puisse activer son compte. Apres l’activation, il sera redirigé sur sa page de profil.<br><br>


<?= $this->Html->image('signup.png', ['alt' => "Page de creation d'utilisateur", 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 15: Page de creation d'utilisateur</em></span><br><br>


<?= $this->Html->image('profil.png', ['alt' => 'Page de profil utilisateur', 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 16: Page de profil utilisateur</em></span><br><br>




<p>Sur la page de profil, on a les informations de l’utilisateur connecte, les contacts créés par ce dernier, ses campagnes, il y a également la possibilité de faire un message rapide sans qu’il soit lié à une campagne particulière. </p></li>
<li>Modifier un utilisateur :   il existe deux types de modification d’utilisateur dans l’application. La modification effectuée par l’utilisateur lui-même sur ses informations et les modifications effectuées par l’administrateur ou le super administrateur pour l’utilisateur standard et par le super administrateur pour l’administrateur.</li>
<li>Supprimer un utilisateur : il n’y a que l’administrateur et le super administrateur qui peuvent faire cela. L’administrateur peut supprimer uniquement un utilisateur standard. Le super administrateur peut supprimer tous les types d’utilisateurs.</li>

<?= $this->Html->image('liste.png', ['alt' => "Page de liste d'utilisateur", 'class' => 'img-responsive']); ?>
<br><span class=".span"><em>Figure 17: Page de liste d'utilisateur</em></span><br><br>


</ul>

<p>Il y a possibilité de rendre un utilisateur standard administrateur, il suffit de cliquer sur le bouton vert dans la colonne action du tableau d’utilisateurs.</p>
<p>En cas de perte ou oublie de son mot de passe, il suffit de cliquer sur <Mot de passe oublié ?> vous serrez rediriger sur une page ou vous devrez saisir votre adresse mail pour que le lien de réinitialisation du mot de passe vous soit envoyé. Il faudra cliquer sur le lien dans le mail pour accéder au formulaire de réinitialisation, ensuite saisissez votre nouveau mot de passe et valider. Votre mot de passe serra mis à jour et vous serrez rediriger vers la page d’accueil en fonction de votre profil.</p>



            
        </div>
    </div>
</div>