<!-- DataTables -->
<?= $this->Html->css('../plugins/datatables/buttons.bootstrap.min.css', ['block' => true]) ?>
<?= $this->Html->css('../plugins/datatables/jquery.dataTables.min.css', ['block' => true]) ?>

<?= $this->Html->css('../plugins/jquery-circliful/css/jquery.circliful.css', ['block' => true]) ?>

<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">

            <h4 class="header-title m-t-0 m-b-30">Listes des Campagnes</h4>

            <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Nom de la campagne</th>
                    <th>Coût de la campagne</th>
                    <th>Date d'envoi</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>

                <?php $js = array(); foreach($campagnes as $camp):	?>
                    <tr>
                        <td><?php echo htmlentities($camp->id);?></td>
                        <td><?php echo htmlentities($camp->libelle);?></td>
                        <td><?php echo htmlentities($camp->cout);?> €</td>
                        <td><?php echo htmlentities(\App\Controller\AppController::change_format_date($camp->dateEnvoi));?></td>
                        <td>
                            <button class="btn btn-primary" id="btn-<?= $camp->id ?>" value="<?=$camp->id?>" onclick="showDiv(this)" ><i class="ti-eye"></i></button>
                        </td>
                    </tr>
                <?php $js[$camp->id] = $camp->id; endforeach; ?>

                </tbody>
            </table>
        </div>
    </div><!-- end col -->
</div>

<?php foreach($campagnes as $cpg):	?>
<div id="js_partie<?= $cpg->id ?>" style="display: none" class="row">
    <div class="col-lg-12">
        <div class="panel panel-color panel-tabs panel-info">
            <div class="panel-heading">
                <ul class="nav nav-pills pull-right">
                    <li class="active">
                        <a href="#navpills-<?= $cpg->id ?>-1" data-toggle="tab" aria-expanded="true">Détails de la campagne</a>
                    </li>
                    <li class="">
                        <a href="#navpills-<?= $cpg->id ?>-2" data-toggle="tab" aria-expanded="false">Statistiques</a>
                    </li>
                    <li class="">
                        <a href="#navpills-<?= $cpg->id ?>-3" data-toggle="tab" aria-expanded="false">Liste des numéros</a>
                    </li>
                    <li class="">
                        <a href="#navpills-<?= $cpg->id ?>-4" data-toggle="tab" aria-expanded="false">Rapport</a>
                    </li>
                </ul>
                <h3 class="panel-title"><?= $cpg->libelle ?></h3>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="navpills-<?= $cpg->id ?>-1" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-4" >
                                        <h5>Référence de la campagne</h5>
                                    </div>
                                    <div class="col-sm-8">
                                        <span style="font-weight: bold;"><?= $cpg->campaignId ?></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <h5>Date de création</h5>
                                    </div>
                                    <div class="col-sm-8">
                                        <span style="font-weight: bold;"><?= \App\Controller\AppController::change_format_date($cpg->dateCreation) ?></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <h5>Date d'envoi</h5>
                                    </div>
                                    <div class="col-sm-8">
                                        <span style="font-weight: bold;"><?= \App\Controller\AppController::change_format_date($cpg->dateEnvoi) ?></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <h5>Nbre contacts</h5>
                                    </div>
                                    <div class="col-sm-8">
                                        <span style="font-weight: bold;"><?= $cpg->nbre_contact ?></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <h5>Nbre SMS</h5>
                                    </div>
                                    <div class="col-sm-8">
                                        <span style="font-weight: bold;"><?= $cpg->nbre_envoye ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="navpills-<?= $cpg->id ?>-2" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12">
                                <?php foreach($pourcentage as $key => $pct):
                                    if ($key == $cpg->id):
                                    ?>
                                    <div class="row text-center">
                                        <div class="col-sm-6 col-lg-4">
                                            <div data-plugin="circliful" class="circliful-chart m-b-30" data-dimension="180"
                                                 data-text="<?= $pct['envoye']?>%" data-info="SMS Envoyé" data-width="20" data-fontsize="24"
                                                 data-percent="<?= $pct['envoye']?>" data-fgcolor="#10c469" data-bgcolor="#ebeff2"
                                                 data-fill="#f4f8fb"></div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div data-plugin="circliful" class="circliful-chart m-b-30" data-dimension="180"
                                                 data-text="<?= $pct['programme']?>%" data-info="SMS Programmé" data-width="20" data-fontsize="24"
                                                 data-percent="<?= $pct['programme']?>" data-fgcolor="#c47816" data-bgcolor="#ebeff2"
                                                 data-fill="#f4f8fb"></div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div data-plugin="circliful" class="circliful-chart m-b-30" data-dimension="180"
                                                 data-text="<?= $pct['echec']?>%" data-info="SMS Non Envoyé" data-width="20" data-fontsize="24"
                                                 data-percent="<?= $pct['echec']?>" data-fgcolor="#c41b1a" data-bgcolor="#ebeff2"
                                                 data-fill="#f4f8fb"></div>
                                        </div>
                                    </div>
                                <?php endif;
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div id="navpills-<?= $cpg->id ?>-3" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Numéro</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Date d'Envoi</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i=0; $telephone = ""; foreach($contacts as $contact): ?>
                                            <?php foreach($contact->Sms as $sms): ?>
                                                <?php if ($sms->idcampagne == $cpg->id): ?>
                                            <tr>
                                                <td><?php if($telephone == "" && $i == 0){echo htmlentities($contact->telephone); $i++; $telephone = $contact->telephone;}elseif($telephone == $contact->telephone && $i != 0){echo "";}elseif ($telephone != $contact->telephone && $i != 0){echo htmlentities($contact->telephone); $telephone = $contact->telephone;}?></td>
                                                <td><?php echo htmlentities($sms->contenu);?></td>
                                                <td><?php if($sms->etat == 100){ echo '<span class="badge badge-success">Envoyé</span>';}elseif($sms->etat == 101){echo '<span class="badge badge-warning">Programmé</span>';}else{echo '<span class="badge badge-danger">Non Envoyé</span>';} ;?></td>
                                                <td><?php echo htmlentities(\App\Controller\AppController::change_format_date($sms->dateEnvoi));?></td>
                                            </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="navpills-<?= $cpg->id ?>-4" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-6">
                                <div class="text-center card-box">
                                    <div>
                                        <i class="fa fa-file-pdf-o" style="font-size: 150px;"></i>
                                        <br><br>
                                        <p class="text-muted font-50 m-b-30" style="font-size: 20px;">
                                            Téléchargez au format PDF le récapitulatif de votre campagne ainsi que ses statistiques de réception.
                                            Attention, il est préférable d'attendre 3 jours pour récupérer l'intégralité des accusés de réception.
                                        </p>
                                        <div class="">
                                            <a href="<?= $this->Url->build(['controller' => 'Rapport', 'action' => 'imprimer', 'campagne' => $cpg->id]) ?>"><button class="btn btn-rounded btn-info">TELECHARGER</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end col -->
</div>
<?php endforeach; ?>

<!-- KNOB JS -->
<!--[if IE]>
<?= $this->Html->script('jquery-knob/excanvas', ['block' => true]) ?>
<![endif]-->
<?= $this->Html->script('jquery-knob/jquery.knob', ['block' => true]) ?>

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

<?= $this->Html->script('../plugins/jquery-circliful/js/jquery.circliful.min.js', ['block'=>true]) ?>

<?=$this->Html->scriptStart(['block' => true]) ?>
$(document).ready(function() {
$('#datatable').dataTable();
$('#datatable-keytable').DataTable( { keys: true } );
$('#datatable-responsive').DataTable();
$('#datatable-scroller').DataTable( { ajax: "assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
var table = $('#datatable-fixed-header').DataTable( { fixedHeader: true } );
} );
TableManageButtons.init();

//Select choice
function showDiv(elem) {
    <?php foreach($camp_js as $cp):	?>
        if(elem.value == <?= $cp->id?>)
        {
                <?php foreach($js as $j):	?>
                    document.getElementById("js_partie<?= $j ?>").style.display = "<?= $j == $cp->id ? 'block' : 'none' ?>";
                <?php endforeach;?>

        }
    <?php endforeach;?>
}+

<?= $this->Html->scriptEnd()?>