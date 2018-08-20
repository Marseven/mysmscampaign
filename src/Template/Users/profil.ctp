<!-- DataTables -->
<?= $this->Html->css('../plugins/datatables/buttons.bootstrap.min.css', ['block' => true]) ?>
<?= $this->Html->css('../plugins/datatables/jquery.dataTables.min.css', ['block' => true]) ?>

<?= $this->Html->css('../plugins/multiselect/css/multi-select.css', ['block' => true]) ?>
<?= $this->Html->css('../plugins/select2/dist/css/select2.css', ['block' => true]) ?>
<?= $this->Html->css('../plugins/select2/dist/css/select2-bootstrap.css', ['block' => true]) ?>

<div class="row">
    <div class="col-sm-8">
        <div class="bg-picture card-box">
            <div class="profile-info-name">
                <?= $this->Html->image("default-avatar.png", ['class' => 'img-thumbnail', 'alt'=>'profil-image', 'title'=>'user']); ?>

                <div class="profile-info-detail">
                    <h3 class="m-t-0 m-b-0"><span class="text-uppercase"><?php echo htmlentities($user->nom);?></span> <?php echo htmlentities($user->prenom);?></h3>
                    <p class="text-muted m-b-20"><i><?php echo htmlentities($user->role);?></i></p>
                    <div class="col-sm-6">
                        <h5><i class="ti-mobile"></i> +241 <?php echo htmlentities($user->telephone);?></h5>
                    </div>
                    <div class="col-sm-6">
                        <h5><i class="ti-email"></i> <?php echo htmlentities($user->email);?></h5>
                    </div>
                    <div class="col-sm-6">
                        <h5><i class="ti-calendar"></i> <?php echo htmlentities($user->dateNaiss); ?> ans</h5>
                    </div>
                    <div class="col-sm-6">
                        <h5><i class="ti-location-pin"></i> <?php echo htmlentities($user->codeZip);?> , <?php echo htmlentities($user->adresse);?> - <?php echo htmlentities($user->ville);?></h5>
                    </div>
                    <div class="col-sm-6">
                        <h5><i class="ti-shift-right"></i> <?php echo htmlentities(\App\Controller\AppController::change_format_date($user->dateCreation));?></h5>
                    </div>
                    <div class="col-sm-6">
                        <h5><i class="ti-shift-left"></i> <?php echo htmlentities(\App\Controller\AppController::change_format_date($user->last_login));?></h5>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
        <!--/ meta -->


        <div class="bg-picture card-box">
            <?= $this->Form->create('Sms', ['url' => ['controller' => 'Sms', 'action' => 'fastSendSms'], 'class' => 'form-horizontal']); ?>
                <h4 class="header-title m-t-0 m-b-30"><i class="ti-comment m-r-5"></i> Envoi Rapide de SMS</h4>
                <div class="form-group">
                    <?= $this->Form->control('idexpediteur', array(
                        'options' => $expediteurs,
                        'class' => 'form-control',
                        'label' => 'Expéditeur',
                    )); ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('idcontact', array(
                        'options' => $contact_add,
                        'class' => 'select2 form-control',
                        'label' => 'Sélectionner un contact',
                        'required'
                    )); ?>
                </div>
                <div class="form-group">
                    <label class="control-label">Message</label>
                    <div class="">
                        <?= $this->Form->control('contenu', array(
                            'class' => 'form-control',
                            'id' => 'textarea',
                            'placeholder' => 'Le message',
                            'type' => 'textarea',
                            'rows' => 2,
                            'maxlength' => 160,
                            'label' => '',
                            'required'
                        )); ?>
                        <span class="font-13 text-muted">160 caractères maximum</span>
                    </div>
                </div>
                <div class="p-t-10 pull-right">
                    <?= $this->Form->control('Envoyer', array(
                        'class' => 'btn btn-purple',
                        'type'  => 'submit',
                        'label' => '',
                    )); ?>
                </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="card-box">

            <h4 class="header-title m-t-0 m-b-30"><i class="ti-bookmark m-r-5"></i> Mes Contacts</h4>

            <ul class="list-group m-b-0 user-list">
                <?php foreach($contacts as $contact){	?>
                    <li class="list-group-item">
                        <a href="#" class="user-list-item">
                            <div class="avatar">
                                <i class="ti-user"></i>
                            </div>
                            <div class="user-desc">
                                <span class="name"><?= $contact->nom ?></span>
                                <span class="desc"><?= $contact->telephone ?></span>
                            </div>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="card-box">

            <h4 class="header-title m-t-0 m-b-30"><i class="ti-list m-r-5"></i> Mes Campagnes</h4>

            <ul class="list-group m-b-0 user-list">
                <?php foreach($campagnes as $campagne){	?>
                    <li class="list-group-item">
                        <a href="#" class="user-list-item">
                            <div class="avatar text-center">
                                <i class="zmdi zmdi-circle <?=  new \DateTime($campagne->dateEnvoi) > new \DateTime(date('Y-m-d H:i:s')) ? 'text-success' : 'text-danger' ?>"></i>
                            </div>
                            <div class="user-desc">
                                <span class="name"><?= $campagne->libelle ?></span>
                                <span class="desc"><?= $campagne->cout ?> € - <?= \App\Controller\AppController::change_format_date($campagne->dateEnvoi) ?></span>
                            </div>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

    </div>
</div>


<!-- Datatables-->
<?= $this->Html->script('../plugins/datatables/jquery.dataTables.min.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/datatables/dataTables.bootstrap.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/datatables/dataTables.buttons.min.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/datatables/buttons.bootstrap.min.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/datatables/jszip.min.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/datatables/pdfmake.min.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/datatables/vfs_fonts.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/datatables/buttons.html5.min.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/datatables/buttons.print.min.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/datatables/responsive.bootstrap.min.js', ['block'=>true]) ?>


<!-- Datatable init js -->
<?= $this->Html->script('../pages/datatables.init.js', ['block'=>true]) ?>

<?= $this->Html->script('../plugins/bootstrap-inputmask/bootstrap-inputmask.min.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/multiselect/js/jquery.multi-select.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/jquery-quicksearch/jquery.quicksearch.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/select2/dist/js/select2.min.js', ['block'=>true]) ?>

<?=$this->Html->scriptStart(['block' => true]) ?>
jQuery(document).ready(function() {

//advance multiselect start
$('#my_multi_select3').multiSelect({
selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
afterInit: function (ms) {
var that = this,
$selectableSearch = that.$selectableUl.prev(),
$selectionSearch = that.$selectionUl.prev(),
selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
.on('keydown', function (e) {
if (e.which === 40) {
that.$selectableUl.focus();
return false;
}
});

that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
.on('keydown', function (e) {
if (e.which == 40) {
that.$selectionUl.focus();
return false;
}
});
},
afterSelect: function () {
this.qs1.cache();
this.qs2.cache();
},
afterDeselect: function () {
this.qs1.cache();
this.qs2.cache();
}
});

// Select2
$(".select2").select2();

$(".select2-limiting").select2({
maximumSelectionLength: 2
});

});
$(document).ready(function() {
$('#datatable').dataTable();
$('#datatable-keytable').DataTable( { keys: true } );
$('#datatable-responsive').DataTable();
$('#datatable-scroller').DataTable( { ajax: "assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
var table = $('#datatable-fixed-header').DataTable( { fixedHeader: true } );
} );
TableManageButtons.init();
<?= $this->Html->scriptEnd()?>