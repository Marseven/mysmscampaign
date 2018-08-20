<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="card-box">

            <h4 class="header-title m-t-0 m-b-30">Créer un utilisateur</h4>

            <?= $this->Form->create($user); ?>
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

                <div class="form-group text-right m-b-0">
                    <?= $this->Form->control('Creer', array(
                        'class' => 'btn btn-success',
                        'type'  => 'submit',
                        'label' => ''
                    )); ?>
                    <br>
                    <button type="reset" class="btn btn-danger">
                        Annuler
                    </button>
                </div>

            <?= $this->Form->end(); ?>
        </div>
    </div><!-- end col -->
</div>
<!-- end row -->
