<div style="height: 5px; width:100%;"></div>
<div class="container">
    <div style="width: 40%; display: block; margin-left: 40%;">
        <div style="margin-left: 10px;">
            <p><img style="width: 60%; height: auto;"  src="http://mysmscampaign.jobs-conseil.com/img/Logo-Setrag.png" alt="imglogo"/></p>
        </div>
    </div>
    <div>
        <br>
        <h1 style="text-align: center; color: #025eb5;">RAPPORT DE DIFFUSION</h1>
        <br>
        <h3 style="text-decoration: underline; color: #025eb5;"><?= $campagne->libelle ?></h3>
        <h3><span style="text-decoration: underline; color: #025eb5;">Client</span> : SETRAG</h3>
        <h3 style="color: #025eb5;">Message(s) :</h3>
        <div style="margin-left: 10px;">
            <?php $i=1; foreach ($campagne->smss as $sm){ ?>
                <p><?= $i ?> - <?= htmlentities($sm->contenu) ?></p>
            <?php $i++; } ?>
        </div>
        <div style="border: 2px solid #1c1c1c; padding: 10px;">
            <h3 style="color: #025eb5;">Statistiques :</h3>
            <?php $i=1; foreach ($statistiques_SMS as $sms){ ?>
                <h4><?= $i ?> : <?= $sms['id'] ?></h4>
                <p>Mots  :  <?= $sms['mot'] ?></p>
                <p>Nombre de caracteres  :  <?= $sms['nbre_caratere'] ?></p>
                <p>Paragraphes : <?= $sms['paragraphe'] ?></p>
                <p>Lignes :  <?= $sms['ligne'] ?></p>
                <br>
            <?php $i++; } ?>
        </div>
        <div style="height: 10px; width:100%;"></div>
        <table class="items" cellpadding="8" width="100%"  style="autosize: 2.4; border-collapse: collapse; border: 1px dashed black;" >
            <thead>
                <tr>
                    <th style="border-right: 0; text-align: center; background: #fee502e8; color: #025eb5;" width="40%"><strong>Details de la campagne</strong></th>
                    <th style="border-left: 0; background: #fee502e8;" width="60%"><strong></strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Campagne</td>
                    <td><?=$campagne->libelle?></td>
                </tr>
                <tr>
                    <td>Reference de la campagne</td>
                    <td><?=$campagne->campaignId?></td>
                </tr>
                <tr>
                    <td>Date de la commande</td>
                    <td><?= \App\Controller\AppController::change_format_date($campagne->dateCreation) ?></td>
                </tr>
                <tr>
                    <td>Date d'envoi</td>
                    <td><?= \App\Controller\AppController::change_format_date($campagne->dateEnvoi) ?></td>
                </tr>
                <tr>
                    <td>Nb contacts</td>
                    <td><?=$campagne->nbre_contact?></td>
                </tr>
                <tr>
                    <td>Nb SMS</td>
                    <td><?=$campagne->nbre_envoye?></td>
                </tr>
                <tr>
                    <td>Expediteur</td>
                    <td>SETRAG</td>
                </tr>
                <tr>
                    <td>Message</td>
                    <td>
                        <?php $i=1; foreach ($campagne->smss as $sm){ ?>
                            <p><?= $i ?> - <?= htmlentities($sm->contenu) ?></p>
                        <?php $i++; } ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <div style="height: 10px; width:100%;"></div>
        <table class="items" cellpadding="8" width="100%"  style="autosize: 2.4; border-collapse: collapse; border: 0;" >
            <thead>
            <tr>
                <th style="border-right: 0; text-align: right; background: #fee502e8; color: #025eb5;" width="40%"><strong>Statistiques de la campagne</strong></th>
                <th style="border-left: 0; background: #fee502e8;" width="60%"><strong></strong></th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>SMS envoyes</td>
                    <td><?=$data_SMS['sms_envoye']?></td>
                </tr>
                <tr>
                    <td>SMS recus</td>
                    <td><?=$data_SMS['sms_recu']?></td>
                </tr>
                <tr>
                    <td>Sans accuse</td>
                    <td><?=$data_SMS['sms_sans_accuse']?></td>
                </tr>
                <tr>
                    <td>SMS non delivres</td>
                    <td><?=$data_SMS['sms_non_delivre']?></td>
                </tr>
                <tr>
                    <td>NPAI</td>
                    <td><?=$data_SMS['npai']?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="height: 30px; width:100%;">

    </div>
    <div style="width: 100%; display: block; margin-right: 10px;">
        <div style="text-align: center;">
            <table class="items" cellpadding="8" width="100%"  style="autosize: 2.4; border-collapse: collapse;" >
                <thead>
                    <tr>
                        <th style="text-align: center; border-right: 0; background: #fee502e8; color: #025eb5;" width="20%"><strong>Mobile</strong></th>
                        <th style="text-align: center; border-right: 0; border-left: 0; background: #fee502e8; color: #025eb5;" width="30%"><strong>Statut</strong></th>
                        <th style="text-align: center; border-left: 0; background: #fee502e8; color: #025eb5;" width="50%"><strong>Date d'accuse</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reponse_sms as $contact){ ?>
                        <tr>
                            <td><?=htmlentities($contact->contact_id)?></td>
                            <td><?php if ($contact->status == 1){ echo "Délivré";}elseif ($contact->status == 2){ echo "Non-délivré (envoyé par l’opérateur)";}elseif ($contact->status == 3){ echo "Transmis à l’opérateur";}elseif ($contact->status == 4){ echo "Message rejeté";}elseif ($contact->status == 5){ echo "SMS rejeté (probablement numéro inconnu/abonné absent)";}else{ echo "Pas d'accuse de reception";} ?></td>
                            <td><?=\App\Controller\AppController::change_format_date($contact->receptionDate)?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div style="height: 50px; width:100%;">

    </div>
    <div>
        <div style="margin-left: 10px;">
            <p><span style="color: red;">*</span><em>Attention, il est préférable d'attendre 3 jours pour récupérer l'intégralité des accusés de réception.</em></p>
            <p>Pour plus d'information contacter le support <a href="mailto:support@setrag.ga">support@setrag.ga</a></p>
        </div>
    </div>
</div>
