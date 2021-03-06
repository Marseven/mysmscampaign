<!-- DataTables -->
<?= $this->Html->css('../plugins/datatables/buttons.bootstrap.min.css', ['block' => true]) ?>
<?= $this->Html->css('../plugins/datatables/jquery.dataTables.min.css', ['block' => true]) ?>

<?= $this->Html->css('../plugins/multiselect/css/multi-select.css', ['block' => true]) ?>
<?= $this->Html->css('../plugins/select2/dist/css/select2.css', ['block' => true]) ?>
<?= $this->Html->css('../plugins/select2/dist/css/select2-bootstrap.css', ['block' => true]) ?>

<div class="row">
    <div class="col-md-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b><?= isset($listecontact->id) ? 'Modifier' : 'Créer' ?> une liste de contacts</b></h4>
            <br>
            <div class="row m-b-30">
                <div class="col-sm-6">
                    <?= isset($listecontact->id) ? $this->Form->create($listecontact, ['url' => ['action' => 'editListContact', 'contact' => $listecontact->id], 'class' => 'form-horizontale']) : $this->Form->create($listecontact, ['url' => ['action' => 'createListContact'], 'class' => 'form-horizontale']) ?>
                    <div class="form-group">
                        <?= $this->Form->control('libelle', array(
                            'class' => 'form-control',
                            'type'  => 'text',
                            'label' => 'Nom de la liste',
                            'required'
                        )); ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->control('contacts', array(
                            'options' => $contact_add,
                            'class' => 'select2 select2-multiple',
                            'multiple' => "multiple",
                            'multiple',
                            'data-placeholder' => "Ajouter ...",
                            'label' => 'Sélectionner les contacts',
                            'required'
                        )); ?>
                    </div>
                    <?= $this->Form->control('iduser', array(
                        'class' => 'form-control',
                        'type'  => 'hidden',
                        'value' => $user->id,
                        'label' => '',
                    )); ?>
                    <br>
                    <?= $this->Form->control(isset($listecontact->id) ? 'Modifier' : 'Créer', array(
                        'class' => 'btn btn-success',
                        'type'  => 'submit',
                        'label' => '',
                    )); ?>
                    <?= $this->Form->end(); ?>
                </div>
                <div class="col-sm-6">
                    <h4>Ou importer une liste</h4>
                    <?= $this->Form->create('listecontacts', ['url' => ['action' => 'createListContact'], 'type' => 'file', 'class' => 'form-ineline']) ?>
                    <div class="input-group m-t-10">
                        <input type="file" name="listecontact" id="example-input2-group2" class="form-control" required placeholder="fichier xlsx, csv.">
                        <span class="input-group-btn">
                        <button type="submit" class="btn btn-success">Importer</button>
                    </span>
                    </div>
                    <?= $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Carte Utilisateur AllMySMS</b></h4>
            <br>
            <div class="row m-b-30">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-4" >
                            <h5>Nom & Prénom</h5>
                        </div>
                        <div class="col-sm-8">
                            <h5 style="font-weight: bold;"><?= $allmysms['lastName'] ?> <?= $allmysms['firstName'] ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Socité</h5>
                        </div>
                        <div class="col-sm-8">
                            <h5 style="font-weight: bold;"><?= $allmysms['society'] ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Status</h5>
                        </div>
                        <div class="col-sm-8">
                            <h5 style="font-weight: bold;"><?= $allmysms['status'] ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Nbre SMS</h5>
                        </div>
                        <div class="col-sm-8">
                            <h5 style="font-weight: bold;"><?= $allmysms['nbSms'] ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Crédit</h5>
                        </div>
                        <div class="col-sm-8">
                            <h5 style="font-weight: bold;"><?= $allmysms['credits'] ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Solde</h5>
                        </div>
                        <div class="col-sm-8">
                            <h5 style="font-weight: bold;"><?= $allmysms['balance']*650 ?> XAF</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <br><br>
                    <img src="https://manager.allmysms.com/img/allmysmsFR.png" alt="Logo AllMySMS">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">

            <h4 class="header-title m-t-0 m-b-30">Listes des contacts</h4>

            <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Libelle</th>
                    <th>Contacts</th>
                    <th>Date de création</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>

                <?php foreach($listecontacts as $ct){	?>
                    <tr>
                        <td><?php echo htmlentities($ct->id);?></td>
                        <td><?php echo htmlentities($ct->libelle);?></td>
                        <td><?php echo htmlentities($ct->contacts);?></td>
                        <td><?php echo htmlentities(\App\Controller\AppController::change_format_date($ct->dateCreation));?></td>
                        <td>
                            <a class="btn btn-success" href="<?= $this->Url->build(['controller' => 'Contacts', 'action' => 'viewList', 'listecontact' => $ct->id]) ?>"><i class="ti-eye"></i></a>
                        <?php if($user->id == $ct->iduser || $user->role == "Administrateur" || $user->role == "SuperAdministrateur"){ ?>
                            <a class="btn btn-danger" href="<?= $this->Url->build(['controller' => 'Contacts', 'action' => 'deleteListContact', 'listecontact' => $ct->id]) ?>" onclick="return confirm('Voulez-vous vraiment supprimer cette Liste de contact !');"><i class="ti-trash"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
        </div>
    </div><!-- end col -->
</div>
<!-- end row -->

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


<?=$this->Html->scriptStart(['block' => true]) ?>
$(document).ready(function() {
$('#datatable').dataTable( {
"language": {
"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
}
} );
} );
<?= $this->Html->scriptEnd()?>

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
