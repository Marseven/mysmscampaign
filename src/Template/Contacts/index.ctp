<!-- DataTables -->
<?= $this->Html->css('../plugins/datatables/buttons.bootstrap.min.css', ['block' => true]) ?>
<?= $this->Html->css('../plugins/datatables/jquery.dataTables.min.css', ['block' => true]) ?>

<div class="row">
    <div class="col-md-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b><?= isset($contact->id) ? 'Modifier' : 'Ajouter' ?> un contact</b></h4>
            <br>
            <div class="row m-b-30">
                <div class="col-sm-8">
                    <?= isset($contact->id) ? $this->form->create($contact, ['url' => ['action' => 'editContact', 'contact' => $contact->id], 'class' => 'form-horizontale']) : $this->form->create($contact, ['url' => ['action' => 'addContact'], 'class' => 'form-horizontale']) ?>
                    <div class="form-group">
                        <?= $this->form->input('nom', array(
                            'class' => 'form-control',
                            'type'  => 'text',
                            'label' => 'Nom',
                            'required'
                        )); ?>
                    </div>
                    <div class="form-group">
                        <?= $this->form->input('telephone', array(
                            'class' => 'form-control',
                            'data-mask' => '99999999999',
                            'type' => 'text',
                            'label' => 'Téléphone',
                            'required'
                        )); ?>
                        <span class="font-13 text-muted">e.g 24101020304</span>
                    </div>
                    <?= $this->form->input('iduser', array(
                        'class' => 'form-control',
                        'type'  => 'hidden',
                        'value' => $user->id,
                        'label' => '',
                    )); ?>
                    <br>
                    <?= $this->form->input('Terminer', array(
                        'class' => 'btn btn-success',
                        'type'  => 'submit',
                        'label' => '',
                    )); ?>
                    <?= $this->form->end(); ?>
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
                            <span style="font-weight: bold;"><?= $allmysms['lastName'] ?> <?= $allmysms['firstName'] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Socité</h5>
                        </div>
                        <div class="col-sm-8">
                            <span style="font-weight: bold;"><?= $allmysms['society'] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Status</h5>
                        </div>
                        <div class="col-sm-8">
                            <span style="font-weight: bold;"><?= $allmysms['status'] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Nbre SMS</h5>
                        </div>
                        <div class="col-sm-8">
                            <span style="font-weight: bold;"><?= $allmysms['nbSms'] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Crédit</h5>
                        </div>
                        <div class="col-sm-8">
                            <span style="font-weight: bold;"><?= $allmysms['credits'] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Solde</h5>
                        </div>
                        <div class="col-sm-8">
                            <span style="font-weight: bold;"><?= $allmysms['balance'] ?> €</span>
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
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>

                <?php foreach($contacts as $ct){	?>
                    <tr>
                        <td><?php echo htmlentities($ct->id);?></td>
                        <td><?php echo htmlentities($ct->nom);?></td>
                        <td><?php echo htmlentities($ct->telephone);?></td>
                        <td>
                            <a class="btn btn-primary" href="<?= $this->Url->build(['controller' => 'Contacts', 'action' => 'editContact', 'contact' => $ct->id]) ?>"><i class="ti-pencil"></i></a>
                            <a class="btn btn-danger" href="<?= $this->Url->build(['controller' => 'Contacts', 'action' => 'deleteContact', 'contact' => $ct->id]) ?>"><i class="ti-trash"></i></a>
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


<!-- Datatable init js -->
<?= $this->Html->script('../pages/datatables.init.js', ['block'=>true]) ?>

<?= $this->Html->script('../plugins/bootstrap-inputmask/bootstrap-inputmask.min.js', ['block'=>true]) ?>

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