<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- App Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

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
    <div class="ex-page-content text-center">
        <div class="text-error">404</div>
        <h3 class="text-uppercase font-600">Page Introuvable</h3>
        <p class="text-muted">
            <?= h($message) ?>
        </p>
        <br>
        <span class="btn btn-rounded btn-success"><?= $this->Html->link(__('Retour'), 'javascript:history.back()') ?></span>

    </div>
</div>
<!-- End wrapper page -->
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