<?= $this->Html->css('../plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css', ['block' => true]) ?>

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">

            <h4 class="header-title m-t-0 m-b-30">Envoi de SMS</h4>

            <?= $this->Form->create('Sms', ['url' => ['action' => 'sendSms'], 'type' => 'file', 'class' => 'form-horizontal']); ?>
                <div class="row">
                    <div class="col-lg-6">
                        <h5 style="color: #181d6cff">1 - Message</h5>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Expéditeur</label>
                            <div class="col-md-9">
                                <?= $this->Form->control('', array(
                                    //'options' => $expediteurs,
                                    'options' => ['4' => 'SETRAG'],
                                    'placeholder' => 'SETRAG',
                                    'disabled',
                                    'class' => 'form-control col-sm-3',
                                    'label' => '',
                                )); ?>
                                <?= $this->Form->control('idexpediteur', array(
                                    'value' => 4,
                                    'placeholder' => 'SETRAG',
                                    'type' => 'hidden',
                                    'class' => 'form-control col-sm-3',
                                    'label' => '',
                                )); ?>
                                <!--a href="<?= $this->Url->build(['controller' => 'Expediteurs', 'action' => 'index']) ?>"> + Ajouter un nouvel expéditeur</a-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Modèle de Message</label>
                            <div class="col-md-9">
                                <div class="btn-group">
                                    <button id="type" type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Sélectionner un modèle <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php foreach ($modeles as $modele){ ?>
                                            <li><a href="#" data-tag="<?= $modele->contenu ?>" class="modele" data-value="<?= $modele->id ?>" data-text="<?= $modele->libelle ?>"><?= $modele->libelle ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <?= $this->Form->control('modele', array(
                                    'id' => 'modele',
                                    'type'  => 'hidden',
                                    'value' => 0,
                                    'label' => '',
                                )); ?>
                                <a href="<?= $this->Url->build(['controller' => 'Sms', 'action' => 'modelSms']) ?>"> + Ajouter un nouveau modèle</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Message</label>
                            <div class="col-md-9">
                                <?= $this->Form->control('contenu', array(
                                    'class' => 'form-control',
                                    'id' => 'textarea',
                                    'placeholder' => 'Le message',
                                    'type' => 'textarea',
                                    'rows' => 2,
                                    'maxlength' => 480,
                                    'label' => '',
                                    'required'
                                )); ?>
                                <span class="font-13 text-muted">480 caractères maximum</span>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col-lg-6">
                        <h5 style="color: #181d6cff">2 - Destinataire</h5>
                        <div class="form-group">
                            <div class="col-md-3">
                                <div class="radio radio-info">
                                    <input type="radio" value="mobile" onchange="showDiv(this)" checked name="destinataire" />
                                    <label style="font-weight: 800;" for="destinataire">Mobile</label>
                                </div>
                            </div>
                            <div id="js_partie1" class="col-md-9">
                                <?= $this->Form->control('contact', array(
                                    'class' => 'form-control',
                                    'data-mask' => '99999999999',
                                    'data-role' => 'tagsinput',
                                    'type' => 'text',
                                    'placeholder' => 'Téléphone Mobile',
                                    'label' => '',
                                )); ?>
                                <span class="font-13 text-muted">e.g 24101020304</span>
                            </div>
                            <br>
                            <br>
                            <div class="col-md-3">
                                <div class="radio radio-info">
                                    <input type="radio" value="contact" onchange="showDiv(this)" name="destinataire" />
                                    <label style="font-weight: 800;" for="destinataire">Liste de contacts</label>
                                </div>
                            </div>
                            <div id="js_partie2" style="display: none;" class="col-md-9">
                                <div class="col-md-5">
                                    <br>
                                    <?= $this->Form->control('listecontact', array(
                                        'options' => $listes,
                                        'class' => 'form-control col-sm-3',
                                        'label' => '',
                                    )); ?>
                                </div>
                                <div class="col-md-2" style="text-align: center"><br><span style="font-weight: 800;">OU</span></div>
                                <div class="col-md-5">
                                    <?= $this->Form->control('listecontact_import', array(
                                        'class' => 'form-control',
                                        'type' => 'file',
                                        'label' => '',
                                    )); ?>
                                    <span class="font-13 text-muted">fichier .xlsx, .cvs .</span>
                                </div

                            </div>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
                <br>
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3">
                        <h5 style="color: #181d6cff">3 - Option D'envoi</h5>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Nom de la Campagne</label>
                            <div class="col-md-9">
                                <div class="col-md-6">
                                    <div class="radio radio-info">
                                        <input type="radio" value="unstore" onchange="showDiv(this)" checked  name="campagne" />
                                        <label style="font-weight: 800;" for="campagne">Nouvelle</label>
                                    </div>
                                    <div id="js_partie3" class="form-group">
                                        <?= $this->Form->control('campagne_unstore', array(
                                            'class' => 'form-control',
                                            'type' => 'text',
                                            'placeholder' => 'Nom de la campagne',
                                            'label' => '',
                                        )); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="radio radio-info">
                                        <input type="radio" value="store" onchange="showDiv(this)" name="campagne" />
                                        <label style="font-weight: 800;" for="campagne">Existante</label>
                                    </div>
                                    <div id="js_partie4" style="display: none;" class="form-group">
                                        <?= $this->Form->control('campagne_store', array(
                                            'options' => $campagnes,
                                            'class' => 'form-control',
                                            'label' => '',
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Type d'envoi</label>
                            <div class="col-md-9">
                                <div class="col-md-6">
                                    <div class="radio radio-info">
                                        <input type="radio" value="immediat" onchange="showDiv(this)" checked  name="typeenvoi" />
                                        <label style="font-weight: 800;" for="typeenvoi">Immédiatement</label>
                                    </div>
                                    <div id="js_partie5" class="form-group">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="radio radio-info">
                                        <input type="radio" value="differe" onchange="showDiv(this)" name="typeenvoi" />
                                        <label style="font-weight: 800;" for="typeenvoi">Programmé</label>
                                    </div>
                                    <br>
                                    <div id="js_partie6" style="display: none;" class="form-group">
                                        <div class="input-group">
                                            <input type="datetime-local" id="example-input1-group1" name="dateEnvoi" class="form-control" placeholder="">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= $this->Form->control('Envoyer', array(
                            'class' => 'btn',
                            'style' => 'background-color:#181d6cff; color:#fff;',
                            'type'  => 'submit',
                            'label' => '',
                        )); ?>
                    </div><!-- end col -->
                </div><!-- end row -->
            <?= $this->Form->end(); ?>
        </div>
    </div><!-- end col -->
</div>
<!-- end row -->

<?= $this->Html->script('../plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/bootstrap-maxlength/bootstrap-maxlength.min.js', ['block'=>true]) ?>
<?= $this->Html->script('../plugins/bootstrap-inputmask/bootstrap-inputmask.min.js', ['block'=>true]) ?>

<?=$this->Html->scriptStart(['block' => true]) ?>

$( '.modele' ).on('click', function() {
    var tag = $( this ).data( 'tag' ),
    $area = $( '#textarea' );
    var value = $( this ).data( 'value' ),
    $modele = $('#modele');
    var text = $( this ).data( 'text' ),
    $type = $('#type');
    $area.val(tag);
    $modele.val(value);
    text += ' <span class="caret"></span>';
    $type.html(text);
    $area.focus();
})


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
else if(elem.value == "unstore")
{
document.getElementById("js_partie4").style.display = "none";
document.getElementById("js_partie3").style.display = "block";
}
else if(elem.value == "store")
{
document.getElementById("js_partie3").style.display = "none";
document.getElementById("js_partie4").style.display = "block";
}
else if(elem.value == "immediat")
{
document.getElementById("js_partie6").style.display = "none";
document.getElementById("js_partie5").style.display = "block";
}
else if(elem.value == "differe")
{
document.getElementById("js_partie5").style.display = "none";
document.getElementById("js_partie6").style.display = "block";
}
}
<?= $this->Html->scriptEnd()?>
