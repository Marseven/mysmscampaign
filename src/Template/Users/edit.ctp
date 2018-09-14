<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="card-box">

            <h4 class="header-title m-t-0 m-b-30">Modifier un utilisateur</h4>

            <?= $this->Form->create($user_edit, ['type' => 'file']); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?= $this->Form->control('nom', array(
                                'class' => 'form-control',
                                'type' => 'text',
                                'placeholder' => 'Nom*',
                                'label' => 'Nom',
                                'required',
                            )); ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->control('prenom', array(
                                'class' => 'form-control',
                                'type' => 'text',
                                'placeholder' => 'Prenom*',
                                'label' => 'Prenom',
                                'required',
                            )); ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->control('email', array(
                                'class' => 'form-control',
                                'type' => 'email',
                                'placeholder' => 'Email',
                                'label' => 'Email',
                                'required',
                            )); ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->control('telephone', array(
                                'class' => 'form-control',
                                'type' => 'text',
                                'placeholder' => 'Téléphone',
                                'label' => 'Téléphone',
                                'required',
                            )); ?>
                        </div>
                        <div class="form-group">
                            <label for="dateNziss">Date de Naissance</label>
                            <input type="date" name="dateNaiss"  required placeholder="Date de Naissance" class="form-control" id="dateNaiss">
                        </div>
                        <div class="form-group">
                            <?= $this->Form->control('adresse', array(
                                'class' => 'form-control',
                                'type' => 'text',
                                'placeholder' => 'Adresse',
                                'label' => 'Adresse',
                                'required',
                            )); ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->control('codeZip', array(
                                'class' => 'form-control',
                                'type' => 'text',
                                'placeholder' => 'Code Postal',
                                'label' => 'Code Postal',
                                'required',
                            )); ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->control('ville', array(
                                'class' => 'form-control',
                                'type' => 'text',
                                'placeholder' => 'Ville',
                                'label' => 'Ville',
                                'required',
                            )); ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->control('province', array(
                                'class' => 'form-control',
                                'type' => 'text',
                                'placeholder' => 'Province',
                                'label' => 'Province',
                                'required',
                            )); ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->control('pays', array(
                                'class' => 'form-control',
                                'type' => 'text',
                                'placeholder' => 'Pays',
                                'label' => 'Pays',
                                'required',
                            )); ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->control('password', array(
                                'class' => 'form-control',
                                'placeholder' => 'Mot de Passe*',
                                'type' => 'password',
                                'label' => 'Mot de Passe',
                                'required',
                            )); ?>

                        </div>
                        <div class="form-group">
                            <?= $this->Form->control('password_verify', array(
                                'class' => 'form-control',
                                'type' => 'password',
                                'placeholder' => 'Confirmer Mot de Passe*',
                                'label' => 'Confirmer Mot de Passe',
                                'required',
                            )); ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="image_preview">
                            <?= $this->Html->image('default-avatar.png', ['alt' => 'img-thumbnail', 'width' => '200', 'height' => '200']); ?>
                            <h5></h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= $this->Form->control('picture', array(
                                        'type' => 'file',
                                        'class' => '',
                                        'label' => '',
                                        'id' => 'picture',
                                        'accept' => 'image/*'
                                    )); ?>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input file">
                                        <button style="margin-top: 15px" class="btn btn-danger" type="button">Annuler</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group text-right m-b-0">
                            <?= $this->Form->control('Modifier', array(
                                'class' => 'btn btn-success',
                                'type'  => 'submit',
                                'label' => ''
                            )); ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group text-left m-b-0">
                            <button type="reset" class="btn btn-danger">
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>
            <?= $this->Form->end(); ?>
        </div>
    </div><!-- end col -->
</div>
<!-- end row -->

<?=$this->Html->scriptStart(['block' => true]) ?>
jQuery(function($) {

//preview picture
$('#picture').on('change', function (e) {
var files = $(this)[0].files;
if (files.length > 0) {
// On part du principe qu'il n'y qu'un seul fichier
// Ã©tant donnÃ© que l'on a pas renseignÃ© l'attribut "multiple"
var file = files[0], $image_preview = $('#image_preview');

// Ici on injecte les informations recoltÃ©es sur le fichier pour l'utilisateur
$image_preview.find('.img-thumbnail').removeClass('hidden');
$image_preview.find('img').attr('src', window.URL.createObjectURL(file));
$image_preview.find('h4').html(file.name);
$image_preview.find('h5').html(file.size +' bytes');
}

// Bouton "Annuler" pour vider le champ d'upload
$image_preview.find('button[type="button"]').on('click', function (e) {
e.preventDefault();
$('#picture').val('');
$image_preview.find('img').attr('src', '/img/default-avatar.png');
$image_preview.find('h4').html(' ');
$image_preview.find('h5').html(' ');
});
});
});
<?= $this->Html->scriptEnd()?>