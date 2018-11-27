<div class="row">
    <div class="col-md-6">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Télécharger un fichier Log</b></h4>
            <br>
            <div class="row m-b-30">
                <div class="col-sm-8">
                    <form method="get" action="<?= $this->Url->build(['controller' => 'Rapport', 'action' => 'download_log']) ?>" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label" for="dateEnvoi">Date du Log</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="date" id="example-input1-group1" name="date" required class="form-control" placeholder="">
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-success" type="submit">Télécharger</button>
                    </form>
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
                            <h5 style="font-weight: bold;"><?= $allmysms['lastName'] ?> <?= $allmysms['firstName'] ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Socité</h5>
                        </div>
                        <div class="col-sm-8">
                            <h5 style="font-weight: bold;"><?= $allmysms['society'] ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Status</h5>
                        </div>
                        <div class="col-sm-8">
                            <h5 style="font-weight: bold;"><?= $allmysms['status'] ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Nbre SMS</h5>
                        </div>
                        <div class="col-sm-8">
                            <h5 style="font-weight: bold;"><?= $allmysms['nbSms'] ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Crédit</h5>
                        </div>
                        <div class="col-sm-8">
                            <h5 style="font-weight: bold;"><?= $allmysms['credits'] ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Solde</h5>
                        </div>
                        <div class="col-sm-8">
                            <h5 style="font-weight: bold;"><?= $allmysms['balance']*650 ?> XAF</h5>
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
        <div class="timeline">
            <article class="timeline-item alt">
                <div class="text-right">
                    <div class="time-show first">
                        <a href="#" class="btn btn-custom w-lg">Aujoud'hui</a>
                    </div>
                </div>
            </article>
            <?php if(isset($campagnes_today)):  ?>
                <?php  $i=0; foreach($campagnes_today as $cpt):	?>
                    <article class="timeline-item <?= fmod($i, 2) == 0 ? 'alt' : '' ?>">
                        <div class="timeline-desk">
                            <div class="panel">
                                <div class="panel-body">
                                    <span class="arrow<?= fmod($i, 2) == 0 ? '-alt' : '' ?>"></span>
                                    <span class="timeline-icon bg-success"><i class="zmdi zmdi-circle"></i></span>
                                    <h4 class="text-success"><?= $cpt->libelle ?></h4>
                                    <p class="timeline-date text-muted"><small><?= \App\Controller\AppController::change_format_date($cpt->dateCreation) ?></small></p>
                                    <p><?= $cpt->users['nom'] ?> <?= $cpt->users['prenom'] ?></p>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php $i++; endforeach; ?>
            <?php endif; ?>
            <?php if(!isset($campagnes_today)):  ?>
                <article class="timeline-item">
                    <div class="timeline-desk">
                        <div class="panel">
                            <div class="panel-body">
                                <span class="arrow"></span>
                                <span class="timeline-icon bg-success"><i class="zmdi zmdi-circle"></i></span>
                                <h4 class="text-success">Aucune Campagne lancée</h4>
                                <p class="timeline-date text-muted"></p>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endif; ?>
            <article class="timeline-item alt">
                <div class="text-right">
                    <div class="time-show">
                        <a href="#" class="btn btn-custom w-lg">Semaine Passée</a>
                    </div>
                </div>
            </article>
            <?php if(isset($campagnes_week)):  ?>
                <?php $i=0; foreach($campagnes_week as $cpt):	?>
                    <article class="timeline-item <?= fmod($i, 2) == 0 ? 'alt' : '' ?>">
                        <div class="timeline-desk">
                            <div class="panel">
                                <div class="panel-body">
                                    <span class="arrow<?= fmod($i, 2) == 0 ? '-alt' : '' ?>"></span>
                                    <span class="timeline-icon bg-warning"><i class="zmdi zmdi-circle"></i></span>
                                    <h4 class="text-warning"><?= $cpt->libelle ?></h4>
                                        <p class="timeline-date text-muted"><small><?= \App\Controller\AppController::change_format_date($cpt->dateCreation) ?></small></p>
                                        <p><?= $cpt->users['nom'] ?> <?= $cpt->users['prenom'] ?></p>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php $i++; endforeach; ?>
            <?php endif; ?>
            <?php if(!isset($campagnes_week)):  ?>
                <article class="timeline-item alt">
                    <div class="timeline-desk">
                        <div class="panel">
                            <div class="panel-body">
                                <span class="arrow-alt"></span>
                                <span class="timeline-icon bg-warning"><i class="zmdi zmdi-circle"></i></span>
                                <h4 class="text-warning">Aucune Campagne lancée</h4>
                                <p class="timeline-date text-muted"></p>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endif; ?>
            <article class="timeline-item alt">
                <div class="text-right">
                    <div class="time-show">
                        <a href="#" class="btn btn-custom w-lg">Mois Passé</a>
                    </div>
                </div>
            </article>
            <?php if(isset($campagnes_month)):  ?>
                <?= $i=0; foreach($campagnes_month as $cpt):	?>
                    <article class="timeline-item <?= fmod($i, 2) == 0 ? 'alt' : '' ?>">
                        <div class="timeline-desk">
                            <div class="panel">
                                <div class="panel-body">
                                    <span class="arrow<?= fmod($i, 2) == 0 ? '-alt' : '' ?>"></span>
                                    <span class="timeline-icon bg-danger"><i class="zmdi zmdi-circle"></i></span>
                                    <h4 class="text-danger"><?= $cpt->libelle ?></h4>
                                        <p class="timeline-date text-muted"><small><?= \App\Controller\AppController::change_format_date($cpt->dateCreation) ?></small></p>
                                        <p><?= $cpt->users['nom'] ?> <?= $cpt->users['prenom'] ?></p>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php $i++; endforeach; ?>
            <?php endif; ?>
            <?php if(!isset($campagnes_month)):  ?>
                <article class="timeline-item">
                    <div class="timeline-desk">
                        <div class="panel">
                            <div class="panel-body">
                                <span class="arrow"></span>
                                <span class="timeline-icon bg-danger"><i class="zmdi zmdi-circle"></i></span>
                                <h4 class="text-danger">Aucune Campagne lancée</h4>
                                <p class="timeline-date text-muted"></p>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- end row -->

