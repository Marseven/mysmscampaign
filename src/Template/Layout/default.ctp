<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Application de campagne de SMS.">
    <meta name="author" content="Jobs Conseil">
    <?= $this->fetch('meta') ?>

    <link rel="shortcut icon" href="/img/ico.png">

    <title>Application SMS</title>

    <!-- App css -->
    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('core.css') ?>
    <?= $this->Html->css('components.css') ?>
    <?= $this->Html->css('icons.css') ?>
    <?= $this->Html->css('pages.css') ?>
    <?= $this->Html->css('menu.css') ?>
    <?= $this->Html->css('responsive.css') ?>

    <?= $this->fetch('css') ?>

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <?= $this->Html->script('modernizr.min') ?>

</head>


<body class="fixed-left">

<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">

        <!-- LOGO -->
        <div class="topbar-left">
            <a href="/" class="logo">
                <img src="#" alt="logo-img" title="logo-app" class="img-responsive logo-setrag" style="max-width: 55%; margin-left: 23%;">
            </a>
        </div>

        <!-- Button mobile view to collapse sidebar menu -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">

                <!-- Page title -->
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <button class="button-menu-mobile open-left">
                            <i class="zmdi zmdi-menu"></i>
                        </button>
                    </li>
                    <li>
                        <h4 class="page-title text-uppercase"><?= $title ?></h4>
                    </li>
                </ul>

                <!-- Right(Notification and Searchbox -->
                <!--ul class="nav navbar-nav navbar-right">
                    <li class="hidden-xs">
                        <form role="search" class="app-search">
                            <input type="text" placeholder="Recherche..."
                                   class="form-control">
                            <a href=""><i class="fa fa-search"></i></a>
                        </form>
                    </li>
                </ul-->

            </div><!-- end container -->
        </div><!-- end navbar -->
    </div>
    <!-- Top Bar End -->


    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">

            <!-- User -->
            <div class="user-box">
                <div class="user-img">
                    <?= $this->Html->image($user->picture != '' ? 'user/'.$user->picture : 'default-avatar.png', ['class' => 'img-circle img-thumbnail img-responsive', 'alt'=>'user-image', 'title'=>'user', 'style' => "height:97%; width: auto;"]); ?>
                    <div class="user-status online"><i class="zmdi zmdi-dot-circle"></i></div>
                </div>
                <h5><a style="color: #fee82e;" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profil']) ?>"> <span class="text-uppercase"><?= $user->nom ?></span> <?= $user->prenom ?> </a> </h5>
                <ul class="list-inline">
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profil']) ?>" >
                            <i class="zmdi zmdi-settings"></i>
                        </a>
                    </li>

                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="text-custom">
                            <i class="zmdi zmdi-power"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- End User -->

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <ul>
                    <li class="text-white menu-title">Navigation</li>

                    <?php if ($user->role == "Administrateur" || $user->role == "SuperAdministrateur") { ?>
	                    <li>
	                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>" class="waves-effect <?= $title == 'Tableau de Bord' ? 'active' : '' ?>"><i class="ti-dashboard"></i> <span> Tableau de Bord </span> </a>
	                    </li>
					<?php } ?>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect <?= $title == 'Envoi de SMS' || $title == 'Gestion des Expéditeurs' || $title == 'Gestion de Modèles de SMS' ? 'active' : '' ?>"><i class="ti-comment"></i> <span> SMS </span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li class="<?= $title == 'Envoi de SMS' ? 'active' : '' ?>"><a href="<?= $this->Url->build(['controller' => 'Sms', 'action' => 'sendSms']) ?>">Envoyer des SMS</a></li>
                            <li class="<?= $title == 'Gestion des Expéditeurs' ? 'active' : '' ?>"><a href="<?= $this->Url->build(['controller' => 'Expediteurs', 'action' => 'index']) ?>">Expéditeurs</a></li>
                            <li class="<?= $title == 'Gestion de Modèles de SMS' ? 'active' : '' ?>"><a href="<?= $this->Url->build(['controller' => 'Sms', 'action' => 'model_sms']) ?>">Modèles</a></li>
                        </ul>
                    </li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect <?= $title == 'Gestion des Campagnes' ? 'active' : '' ?>"><i class="ti-list"></i><span class="label label-info pull-right"><?= $camp_count ?></span><span> Campagnes </span> </a>
                        <ul class="list-unstyled">
                            <li><a href="<?= $this->Url->build(['controller' => 'Campagnes', 'action' => 'index']) ?>">Gestion</a></li>
                            <li><a href="<?= $this->Url->build(['controller' => 'Campagnes', 'action' => 'programmation']) ?>">Programmation</a></li>
                        </ul>
                    </li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect <?= $title == 'Gestion des Contacts' ? 'active' : '' ?>"><i class="ti-bookmark"></i> <span> Contacts </span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?= $this->Url->build(['controller' => 'Contacts', 'action' => 'index']) ?>">Gestion de contacts</a></li>
                            <li><a href="<?= $this->Url->build(['controller' => 'Contacts', 'action' => 'createListContact']) ?>">Gestion de liste de diffusion</a></li>
                        </ul>
                    </li>
                	<?php if ($user->role == "Administrateur" || $user->role == "SuperAdministrateur") { ?>
	                    <li class="has_sub">
	                        <a href="javascript:void(0);" class="waves-effect <?= $title == 'Statistiques des Campagnes' || $title == 'Statistiques' || $title == 'Logger' ? 'active' : '' ?>"><i class="ti-book"></i><span> Rapports </span> <span class="menu-arrow"></span></a>
	                        <ul class="list-unstyled">
	                            <li class="<?= $title == 'Statistiques des Campagnes' ? 'active' : '' ?>"><a href="<?= $this->Url->build(['controller' => 'Rapport', 'action' => 'index']) ?>">Campagnes</a></li>
	                            <li class="<?= $title == 'Statistiques' ? 'active' : '' ?>"><a href="<?= $this->Url->build(['controller' => 'Rapport', 'action' => 'statistiques']) ?>">Statistiques</a></li>
	                            <li class="<?= $title == 'Logger' ? 'active' : '' ?>"><a href="<?= $this->Url->build(['controller' => 'Rapport', 'action' => 'logger']) ?>">Log</a></li>
	                        </ul>
	                    </li>
                    <?php } ?>
                    <?php if ($user->role == "Administrateur" || $user->role == "SuperAdministrateur") { ?>
	                    <li class="waves-effect <?= $title == 'Gestion des API de SMS' ? 'active' : '' ?>">
	                        <a href="<?= $this->Url->build(['controller' => 'Api', 'action' => 'index']) ?>" class="waves-effect"><i class="ti-link"></i><span> API </span></a>
	                    </li>
                    <?php } ?>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect <?= $title == 'Gestion des Utilisateurs' ? 'active' : '' ?>"><i class="ti-user"></i><span> Utilisateurs </span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                        	<?php if ($user->role == "Administrateur" || $user->role == "SuperAdministrateur") { ?>
	                            <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'signup']) ?>">Créer</a></li>
	                            <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'liste']) ?>">Modifier</a></li>
                            <?php } ?>
                            <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profil']) ?>">Mon Compte</a></li>
                            <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'propos']) ?>">À Propos</a></li>
                        </ul>
                    </li>
                    <li class="waves-effect <?= $title == 'Aide ?' ? 'active' : '' ?>">
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'aide']) ?>" class="waves-effect"><i class="ti-help-alt"></i><span> Aide ? </span></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <!-- Sidebar -->
            <div class="clearfix"></div>

        </div>

    </div>
    <!-- Left Sidebar End -->



    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>

            </div> <!-- container -->

        </div> <!-- content -->

        <footer class="footer text-right text-white">
            2018 © Application SMS - Tous Droits Reservés.
        </footer>

    </div>


    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->



<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<?= $this->Html->script('jquery.min') ?>
<?= $this->Html->script('bootstrap.min') ?>
<?= $this->Html->script('detect') ?>
<?= $this->Html->script('fastclick') ?>
<?= $this->Html->script('jquery.blockUI') ?>
<?= $this->Html->script('waves') ?>
<?= $this->Html->script('jquery.nicescroll') ?>
<?= $this->Html->script('jquery.slimscroll') ?>
<?= $this->Html->script('jquery.scrollTo.min') ?>

<?= $this->fetch('script') ?>

<!-- App js -->
<?= $this->Html->script('jquery.core') ?>
<?= $this->Html->script('jquery.app') ?>


</body>
</html>
