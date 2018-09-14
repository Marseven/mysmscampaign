<!-- DataTables -->
<?= $this->Html->css('../plugins/datatables/buttons.bootstrap.min.css', ['block' => true]) ?>
<?= $this->Html->css('../plugins/datatables/jquery.dataTables.min.css', ['block' => true]) ?>

<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">


            <h4 class="header-title m-t-0 m-b-30">Listes des Utilisateurs</h4>

            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Nom & Prenom</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Adresse</th>
                    <th>Ville</th>
                    <th>Dernière Connexion</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>

                <?php foreach($users as $user){	?>
                    <tr>
                        <td><?php echo htmlentities($user->id);?></td>
                        <td><span class="text-uppercase"><?php echo htmlentities($user->nom);?></span> <?php echo htmlentities($user->prenom);?></td>
                        <td><?php echo htmlentities($user->telephone);?></td>
                        <td><?php echo htmlentities($user->email);?></td>
                        <td><?php $age = new \App\Controller\AppController(); echo htmlentities($age->age($user->dateNaiss)).' ans'; ?></td>
                        <td><?php echo htmlentities($user->adresse);?></td>
                        <td><?php echo htmlentities($user->ville);?></td>
                        <td><?php echo htmlentities($user->last_login);?></td>
                        <td>
                            <a class="btn btn-primary" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'edit', 'user' => $user->id]) ?>"><i class="ti-pencil"></i></a>
                            <a class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette utilisateur !');" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'delete', 'user' => $user->id]) ?>"><i class="ti-trash"></i></a>
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
<?=$this->Html->scriptStart(['block' => true]) ?>
$(document).ready(function() {
$('#datatable').dataTable( {
"language": {
"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
}
} );
} );
<?= $this->Html->scriptEnd()?>
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
    $('#datatable').dataTable();
    $('#datatable-keytable').DataTable( { keys: true } );
    $('#datatable-responsive').DataTable();
    $('#datatable-scroller').DataTable( { ajax: "assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
    var table = $('#datatable-fixed-header').DataTable( { fixedHeader: true } );
    } );
    TableManageButtons.init();
<?= $this->Html->scriptEnd()?>