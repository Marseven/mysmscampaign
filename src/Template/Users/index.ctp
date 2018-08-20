<!--Morris Chart CSS -->
<?= $this->Html->css('morris/morris.css', ['block' => true]) ?>

<div class="row">

    <div class="col-lg-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title m-t-0 m-b-30">Contacts engistrés</h4>

            <div class="widget-chart-1">
                <div class="widget-chart-box-1">
                    <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#181d6cff "
                           data-bgColor="#181d6c8f" value="<?= $pourcentage_contact; ?>"
                           data-skin="tron" data-angleOffset="180" data-readOnly=true
                           data-thickness=".15"/>
                </div>

                <div class="widget-detail-1">
                    <h2 class="p-t-10 m-b-0"> <?= $nbre_total_contact; ?> </h2>
                    <p class="text-muted"></p>
                </div>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-lg-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title m-t-0 m-b-30">Nombre de SMS envoyé cette semaine</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2">
                    <h2 class="m-b-0"> <?= $sms->count() ?> </h2>
                    <p class="text-muted m-b-25"></p>
                </div>
                <div class="progress progress-bar-success-alt progress-sm m-b-0">
                    <div class="progress-bar progress-bar-success" role="progressbar"
                         aria-valuenow="<?= $sms->count() ?>" aria-valuemin="0" aria-valuemax="10000"
                         style="width: <?= $sms->count() ?>%;">
                        <span class="sr-only"><?= $sms->count() ?> Créés</span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-lg-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title m-t-0 m-b-30">Campagnes Programmées</h4>

            <div class="widget-chart-1">
                <div class="widget-chart-box-1">
                    <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#ffbd4a"
                           data-bgColor="#FFE6BA" value="<?= $pourcentage_camp_pr ?>"
                           data-skin="tron" data-angleOffset="180" data-readOnly=true
                           data-thickness=".15"/>
                </div>
                <div class="widget-detail-1">
                    <h2 class="p-t-10 m-b-0"> <?= $campagnes_pr->count() ?> </h2>
                    <p class="text-muted"></p>
                </div>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-lg-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title m-t-0 m-b-30">Coût Moyen d'une campagne</h4>

            <div class="widget-box-2">
                <div class="widget-detail-2">
                    <h2 class="m-b-0"> <?= $moyenne_cout ?> €</h2>
                    <p class="text-muted m-b-25"></p>
                </div>
                <div class="progress progress-bar-inverse-alt progress-sm m-b-0">
                    <div class="progress-bar progress-bar-inverse" role="progressbar"
                         aria-valuenow="<?= $moyenne_cout ?>" aria-valuemin="0" aria-valuemax="1000"
                         style="width: <?= $moyenne_cout ?>%;">
                        <span class="sr-only"><?= $moyenne_cout ?> €</span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end col -->

</div>
<!-- end row -->

<div class="row">
    <div class="col-lg-6">
        <div class="card-box">
            <h4 class="header-title m-t-0">Stats SMS</h4>

            <div class="widget-chart text-center">
                <div id="morris-donut-example"style="height: 245px;"></div>
                <ul class="list-inline chart-detail-list m-b-0">
                    <li>
                        <h5 style="color: #0ec043;"><i class="fa fa-circle m-r-5"></i>Envoyé</h5>
                    </li>
                    <li>
                        <h5 style="color: #bcad0f;"><i class="fa fa-circle m-r-5"></i>Programmé</h5>
                    </li>
                    <li>
                        <h5 style="color: #c41b1a;"><i class="fa fa-circle m-r-5"></i>Echoué</h5>
                    </li>
                </ul>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-lg-6">
        <div class="card-box">
            <h4 class="header-title m-t-0">Statistiques</h4>
            <div id="morris-bar-example" style="height: 280px;"></div>
        </div>
    </div><!-- end col -->

    <div class="col-lg-4" style="display: none">
        <div class="card-box">
            <h4 class="header-title m-t-0">Valeur des campagnes</h4>
            <div id="morris-line-example" style="height: 280px;"></div>
        </div>
    </div><!-- end col -->

</div>
<!-- end row -->

<div class="row">
    <div class="col-lg-4">
        <div class="card-box">

            <h4 class="header-title m-t-0 m-b-30">Modèles SMS</h4>

            <div class="inbox-widget nicescroll" style="height: 315px;">
                <?php foreach($modeles as $modele){	?>
                <a href="#">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><i class="ti-comments"></i></div>
                        <p class="inbox-item-author"><?= $modele->contenu ?></p>
                        <p class="inbox-item-text"><?= $modele->users['nom'] ?> <?= $modele->users['prenom'] ?></p>
                        <p class="inbox-item-date"><?= \App\Controller\AppController::change_format_date($modele->dateCreation) ?></p>
                    </div>
                </a>
                <?php } ?>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-lg-8">
        <div class="card-box">
            <h4 class="header-title m-t-0 m-b-30">Campagnes</h4>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Nom de la campagne</th>
                        <th>Nbre envoyé</th>
                        <th>Nbre contact</th>
                        <th>Nbre échoué</th>
                        <th>Coût de la campagne</th>
                        <th>Date d'envoi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($campagnes as $camp){	?>
                        <tr>
                            <td><?php echo htmlentities($camp->id);?></td>
                            <td><?php echo htmlentities($camp->libelle);?></td>
                            <td><?php echo htmlentities($camp->nbre_envoye);?></td>
                            <td><?php echo htmlentities($camp->nbre_contact);?></td>
                            <td><?php echo htmlentities($camp->nbre_echec);?></td>
                            <td><?php echo htmlentities($camp->cout);?> €</td>
                            <td><?php echo htmlentities(\App\Controller\AppController::change_format_date($camp->dateEnvoi));?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- end col -->

</div>
<!-- end row -->

<!-- KNOB JS -->
<!--[if IE]>
<?= $this->Html->script('jquery-knob/excanvas', ['block' => true]) ?>
<![endif]-->
<?= $this->Html->script('jquery-knob/jquery.knob', ['block' => true]) ?>

<!--Morris Chart-->
<?= $this->Html->script('morris/morris.min.js', ['block' => true]) ?>
<?= $this->Html->script('raphael/raphael-min.js', ['block' => true]) ?>

<!-- Dashboard init -->
<?php //$this->Html->script('jquery.dashboard', ['block' => true]) ?>
<?=$this->Html->scriptStart(['block' => true]) ?>
    !function($) {
    "use strict";

    var Dashboard1 = function() {
    this.$realData = []
    };

    //creates Bar chart
    Dashboard1.prototype.createBarChart  = function(element, data, xkey, ykeys, labels, lineColors) {
    Morris.Bar({
    element: element,
    data: data,
    xkey: xkey,
    ykeys: ykeys,
    labels: labels,
    hideHover: 'auto',
    resize: true, //defaulted to true
    gridLineColor: '#8C8E90',
    barSizeRatio: 0.2,
    barColors: lineColors
    });
    },

    //creates line chart
    Dashboard1.prototype.createLineChart = function(element, data, xkey, ykeys, labels, opacity, Pfillcolor, Pstockcolor, lineColors) {
    Morris.Line({
    element: element,
    data: data,
    xkey: xkey,
    ykeys: ykeys,
    labels: labels,
    fillOpacity: opacity,
    pointFillColors: Pfillcolor,
    pointStrokeColors: Pstockcolor,
    behaveLikeLine: true,
    gridLineColor: '#eef0f2',
    hideHover: 'auto',
    resize: true, //defaulted to true
    pointSize: 0,
    lineColors: lineColors
    });
    },

    //creates Donut chart
    Dashboard1.prototype.createDonutChart = function(element, data, colors) {
    Morris.Donut({
    element: element,
    data: data,
    resize: true, //defaulted to true
    colors: colors
    });
    },


    Dashboard1.prototype.init = function() {

    //creating bar chart
    var $barData  = [
<?php foreach ($data as $key => $dat){ ?>
    { y: '<?= $key ?>', a: <?= $dat ?> },
<?php } ?>
    ];
    this.createBarChart('morris-bar-example', $barData, 'y', ['a'], ['SMS'], ['#188ae2']);

    //create line chart
    var $data  = [
    { y: '2008', a: 50, b: 0 },
    { y: '2009', a: 75, b: 50 },
    { y: '2010', a: 30, b: 80 },
    { y: '2011', a: 50, b: 50 },
    { y: '2012', a: 75, b: 10 },
    { y: '2013', a: 50, b: 40 },
    { y: '2014', a: 75, b: 50 },
    { y: '2015', a: 100, b: 70 }
    ];
    this.createLineChart('morris-line-example', $data, 'y', ['a','b'], ['Series A','Series B'],['0.9'],['#ffffff'],['#999999'], ['#10c469','#188ae2']);

    //creating donut chart
    var $donutData = [
    {label: "SMS Envoyés", value: <?= $nbre_envoye ?>},
    {label: "SMS Programmés", value: <?= $nbre_programme ?>},
    {label: "SMS Non Envoyés", value: <?= $nbre_echec ?>}
    ];
    this.createDonutChart('morris-donut-example', $donutData, ['#0ec043', '#bcad0f', "#c41b1a"]);
    },
    //init
    $.Dashboard1 = new Dashboard1, $.Dashboard1.Constructor = Dashboard1
    }(window.jQuery),

    //initializing
    function($) {
    "use strict";
    $.Dashboard1.init();
    }(window.jQuery);
<?= $this->Html->scriptEnd()?>
