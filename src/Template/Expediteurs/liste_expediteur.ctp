<!-- DataTables -->
<?= $this->Html->css('../plugins/datatables/buttons.bootstrap.min.css', ['block' => true]) ?>
<?= $this->Html->css('../plugins/datatables/jquery.dataTables.min.css', ['block' => true]) ?>

<div class="row">
    <div class="col-md-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b><?= isset($expediteur->id) ? 'Modifier' : 'Ajouter' ?> un expéditeur</b></h4>
            <br>
            <div class="row m-b-30">
                <div class="col-sm-8">
                    <?= isset($expediteur->id) ? $this->Form->create($expediteur, ['url' => ['action' => 'edit', 'expediteur' => $expediteur->id], 'class' => 'form-horizontale']) : $this->Form->create($expediteur, ['url' => ['action' => 'add'], 'class' => 'form-horizontale']) ?>
                        <div class="form-group">
                            <?= $this->Form->control('titre', array(
                                'class' => 'form-control',
                                'type'  => 'text',
                                'label' => 'Nom de l\'expéditeur ',
                                'maxlength' => 11,
                                'minlength' => 3,
                                'data-parsley-type' => 'alphanum',
                                'required'
                            )); ?>
                        </div>
                        <div class="form-group m-l-10">
                            <div class="checkbox checkbox-primary">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox3" type="checkbox" name="defaut">
                                    <label for="checkbox3">
                                        Expéditeur par défaut
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?= $this->Form->control('iduser', array(
                            'class' => 'form-control',
                            'type'  => 'hidden',
                            'value' => $user->id,
                            'label' => '',
                        )); ?>
                    <br>
                        <?= $this->Form->control(isset($expediteur->id) ? 'Modifier' : 'Ajouter', array(
                            'class' => 'btn btn-success',
                            'type'  => 'submit',
                            'label' => '',
                        )); ?>
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

            <h4 class="header-title m-t-0 m-b-30">Listes des Utilisateurs</h4>

            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Nom</th>
                    <th>Par Défaut</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>

                <?php foreach($expediteurs as $expe){	?>
                    <tr>
                        <td><?php echo htmlentities($expe->id);?></td>
                        <td><?php echo htmlentities($expe->titre);?></td>
                        <td><?php echo htmlentities($expe->defaut);?></td>
                        <td>
                            <a class="btn btn-primary" href="<?= $this->Url->build(['controller' => 'Expediteurs', 'action' => 'edit', 'expediteur' => $expe->id]) ?>"><i class="ti-pencil"></i></a>
                            <a class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cet expéditeur !');" href="<?= $this->Url->build(['controller' => 'Expediteurs', 'action' => 'delete', 'expediteur' => $expe->id]) ?>"><i class="ti-trash"></i></a>
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
<?= $this->Html->script('../plugins/parsleyjs/dist/parsley.min.js', ['block'=>true]) ?>

<?=$this->Html->scriptStart(['block' => true]) ?>
$(document).ready(function() {
$('#datatable').dataTable();
$('#datatable-keytable').DataTable( { keys: true } );
$('#datatable-responsive').DataTable();
$('#datatable-scroller').DataTable( { ajax: "assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
var table = $('#datatable-fixed-header').DataTable( { fixedHeader: true } );
} );
TableManageButtons.init();
<?= $this->Html->scriptEnd()?>