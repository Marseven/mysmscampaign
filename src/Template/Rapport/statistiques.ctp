<!--Morris Chart CSS -->
<?= $this->Html->css('morris/morris.css', ['block' => true]) ?>

<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card-box widget-user">
            <div class="text-center">
                <h2 class="text-custom" data-plugin="counterup"><?= $apis->count() ?></h2>
                <h4>API</h4>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-box widget-user">
            <div class="text-center">
                <h2 class="text-pink" data-plugin="counterup"><?= $campagnes->count() ?></h2>
                <h4>Campagnes</h4>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-box widget-user">
            <div class="text-center">
                <h2 class="text-warning" data-plugin="counterup"><?= $contacts->count() ?></h2>
                <h4>Contacts</h4>
            </div>
        </div>
    </div>

    <!--div class="col-lg-3 col-md-6">
        <div class="card-box widget-user">
            <div class="text-center">
                <h2 class="text-info" data-plugin="counterup"><?= $expediteurs->count() ?></h2>
                <h4>Expéditeurs</h4>
            </div>
        </div>
    </div-->

    <div class="col-lg-3 col-md-6">
        <div class="card-box widget-user">
            <div class="text-center">
                <h2 class="text-custom" data-plugin="counterup"><?= $listecontacts->count() ?></h2>
                <h4>Listes de Contacts</h4>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-box widget-user">
            <div class="text-center">
                <h2 class="text-pink" data-plugin="counterup"><?= $modeles->count() ?></h2>
                <h4>Modèles de SMS</h4>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-box widget-user">
            <div class="text-center">
                <h2 class="text-warning" data-plugin="counterup"><?= $sms->count() ?></h2>
                <h4>SMS</h4>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-box widget-user">
            <div class="text-center">
                <h2 class="text-info" data-plugin="counterup"><?= $users->count() ?></h2>
                <h4>Utilisateurs</h4>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <h4 class="header-title m-t-0">Statistics</h4>
            <div id="morris-bar-example" style="height: 400px;"></div>
        </div>
    </div><!-- end col-->
</div>

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
{label: "SMS Envoyés", value: 4},
{label: "SMS Programmés", value: 2},
{label: "SMS Non Envoyés", value: 1}
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
