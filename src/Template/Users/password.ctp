<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="card-box">

            <h4 class="header-title m-t-0 m-b-30">Réinitialisation du mot de passe</h4>

            <?= $this->Form->create('User', ['url' => ['Controller' => 'Users','action' => 'password']]); ?>
                <div class="row">
                    <div class="col-sm-12">
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
