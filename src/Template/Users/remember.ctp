<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- App Favicon -->
    <link rel="shortcut icon" href="/img/ico.png">

    <!-- App title -->
    <title>MySMSCampaign By Setrag</title>

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
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class="text-center">
        <a href="/" class="logo"><img src="http://mysmscampaign.test/img/logo-mysmscampaign-origin.png" alt="logo-img" title="logo-app" class="img-responsive" style="max-width: 92%; margin: 12% 5% 5% 5%;"></a>
        <h5 class="text-muted m-t-0 font-600">Application de Campagne de SMS</h5>
    </div>
    <div class="m-t-40 card-box">
        <div class="text-center">
            <h4 class="text-uppercase font-bold m-b-0">Mot de Passe Oublié ?</h4>
            <?= $this->Flash->render() ?>
        </div>
        <div class="panel-body">
            <?= $this->form->create('User', ['class' => 'form-horizontal m-t-20', 'url' => ['Controller' => 'Users','action' => 'remember']]); ?>

            <div class="form-group ">
                <div class="col-xs-12">
                    <?= $this->form->input('email', array(
                        'class' => 'form-control',
                        'placeholder' => 'Email',
                        'type' => 'text',
                        'label' => '',
                        'required'
                    )); ?>
                </div>
            </div>

            <div class="form-group text-center m-t-30">
                <div class="col-xs-12">
                    <?= $this->form->input('Envoyer', array(
                        'class' => 'btn btn-success',
                        'id'    => 'connexion',
                        'type'  => 'submit',
                        'label' => ''
                    )); ?>
                </div>
            </div>

            <div class="form-group m-t-30 m-b-0">
                <div class="col-sm-12">
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>" class="text-muted"><i class="fa fa-lock m-r-5"></i> Connexion</a>
                </div>
            </div>
            <?= $this->form->end(); ?>

        </div>
    </div>
    <!-- end card-box-->

    <div class="row">
        <div class="col-sm-12 text-center">
            <p class="text-muted">Vous n'avez pas de compte? <a href="#" class="text-primary m-l-5"><b>contactez le support</b></a></p>
        </div>
    </div>

</div>
<!-- end wrapper page -->



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


<!-- App js -->
<?= $this->Html->script('jquery.core') ?>
<?= $this->Html->script('jquery.app') ?>

<?= $this->fetch('script') ?>

</body>
</html>