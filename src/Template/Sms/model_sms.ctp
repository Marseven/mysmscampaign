<!-- DataTables -->
<?= $this->Html->css('../plugins/datatables/buttons.bootstrap.min.css', ['block' => true]) ?>
<?= $this->Html->css('../plugins/datatables/jquery.dataTables.min.css', ['block' => true]) ?>

<div class="row">
    <div class="col-md-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b><?= isset($modelsms->id) ? 'Modifier' : 'Ajouter' ?> un modèle de SMS</b></h4>
            <br>
            <div class="row m-b-30">
                <div class="col-sm-8">
                    <?= isset($modelsms->id) ? $this->form->create($modelsms, ['url' => ['action' => 'editModelSms', 'modelsms' => $modelsms->id], 'class' => 'form-horizontale']) : $this->form->create($modelsms, ['url' => ['action' => 'addModelSms'], 'class' => 'form-horizontale']) ?>
                        <div class="form-group">
                            <?= $this->form->input('libelle', array(
                                'class' => 'form-control',
                                'type'  => 'text',
                                'label' => 'Nom du modèle ',
                                'required'
                            )); ?>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <?= $this->form->input('contenu', array(
                                    'class' => 'form-control',
                                    'id' => 'textarea',
                                    'placeholder' => 'Le message',
                                    'type' => 'textarea',
                                    'rows' => 2,
                                    'maxlength' => 160,
                                    'label' => 'Message',
                                    'required'
                                )); ?>
                                <span class="font-13 text-muted">160 caractères maximum</span>
                                <br><br>
                            </div>
                            <div class="col-sm-2">
                                <br><br>
                                <button type="button" class="param btn btn-xs btn-facebook" data-tag="param_1">Nom</button>
                            </div>
                        </div>
                        <?= $this->form->input('iduser', array(
                            'class' => 'form-control',
                            'type'  => 'hidden',
                            'value' => $user->id,
                            'label' => '',
                        )); ?>
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

            <h4 class="header-title m-t-0 m-b-30">Listes des Modèles de SMS</h4>

            <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Nom</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>

                <?php foreach($modelSms as $ms){	?>
                    <tr>
                        <td><?php echo htmlentities($ms->id);?></td>
                        <td><?php echo htmlentities($ms->libelle);?></td>
                        <td><?php echo htmlentities($ms->contenu);?></td>
                        <td>
                            <a class="btn btn-primary" href="<?= $this->Url->build(['controller' => 'Sms', 'action' => 'editModelSms', 'modelsms' => $ms->id]) ?>"><i class="ti-pencil"></i></a>
                            <a class="btn btn-danger" href="<?= $this->Url->build(['controller' => 'Sms', 'action' => 'deleteModelSms', 'modelsms' => $ms->id]) ?>"><i class="ti-trash"></i></a>
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


<?= $this->Html->script('../plugins/bootstrap-maxlength/bootstrap-maxlength.min.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/bootstrap-inputmask/bootstrap-inputmask.min.js', ['block'=>true]) ?>

<?=$this->Html->scriptStart(['block' => true]) ?>

$( '.param' ).on( 'click', function() {
var tag = $( this ).data( 'tag' ),
$area = $( '#textarea' );
var start = $area[0].selectionStart,
end = $area[0].selectionEnd,
content = $area.val();
$area.val( content.substring( 0, start )
+ '#' + tag + '#'
+ content.substring( end ) );
$area.focus();
$area[0].selectionStart = $area[0].selectionEnd = end + 2 * tag.length + 5;
})

$(document).ready(function() {
$('#datatable').dataTable();
$('#datatable-keytable').DataTable( { keys: true } );
$('#datatable-responsive').DataTable();
$('#datatable-scroller').DataTable( { ajax: "assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
var table = $('#datatable-fixed-header').DataTable( { fixedHeader: true } );
} );
TableManageButtons.init();
<?= $this->Html->scriptEnd()?>

<?=$this->Html->scriptStart(['block' => true]) ?>
//Bootstrap-MaxLength
$('input#defaultconfig').maxlength()

$('input#thresholdconfig').maxlength({
threshold: 20
});

$('input#moreoptions').maxlength({
alwaysShow: true,
warningClass: "label label-success",
limitReachedClass: "label label-danger"
});

$('input#alloptions').maxlength({
alwaysShow: true,
warningClass: "label label-success",
limitReachedClass: "label label-danger",
separator: ' out of ',
preText: 'You typed ',
postText: ' chars available.',
validate: true
});

$('textarea#textarea').maxlength({
alwaysShow: true
});

$('input#placement').maxlength({
alwaysShow: true,
placement: 'top-left'
});

//Select choice
function showDiv(elem) {
if(elem.value == "mobile")
{
document.getElementById("js_partie1").style.display = "block";
document.getElementById("js_partie2").style.display = "none";
}
else if(elem.value == "contact")
{
document.getElementById("js_partie1").style.display = "none";
document.getElementById("js_partie2").style.display = "block";
}
}
<?= $this->Html->scriptEnd()?>

