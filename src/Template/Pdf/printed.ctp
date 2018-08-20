<img style="position:absolute;top:0.64in;left:3.05in;width:2.91in;height:0.62in" src="https://www.google.com/url?sa=i&source=images&cd=&cad=rja&uact=8&ved=2ahUKEwjupJO-q_LcAhURGewKHftdD2wQjRx6BAgBEAU&url=http%3A%2F%2Fwww.annuem.com%2F%3Fp%3D897&psig=AOvVaw2BDqjFy9_VA85Afzql-oQi&ust=1534535190691460" />


<div style="position:absolute;top:1.60in;left:1.90in;line-height:0.29in;">
    <span style="font-style:normal;font-weight:normal;font-size:14pt;font-family:QQAAAA+OpenSans-Regular;color:#000000">Rapport de la campagne <?= $campagne->libelle ?></span>
    <span style="font-style:normal;font-weight:normal;font-size:14pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>
    <br/>
</div>

<div style="position:absolute;top:10.83in;left:1.10in;line-height:0.14in;">
    <span style="font-style:normal;font-weight:normal;font-size:8pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> les statistiques peuvent varier jusqu&apos;à 72h après votre envoi.</span>
    <span style="font-style:normal;font-weight:normal;font-size:6pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>
    <br/>
</div>

<div style="position:absolute;top:3.10in;left:0.65in;line-height:0.18in;">
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000">Date de commande</span>
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>
    <br/>
</div>

<div style="position:absolute;top:3.10in;left:2.17in;line-height:0.18in;">
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"><?= \App\Controller\AppController::change_format_date($campagne->dateCreation) ?></span>
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>
    <br/>
</div>

<div style="position:absolute;top:3.38in;left:0.65in;width:0.81in;line-height:0.18in;">
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000">Date d&apos;envoi</span>
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>
    <br/>
</div>

<div style="position:absolute;top:3.38in;left:2.17in;line-height:0.18in;">
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"><?= \App\Controller\AppController::change_format_date($campagne->dateEnvoi) ?></span>
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>
    <br/>
</div>

<div style="position:absolute;top:3.95in;left:0.65in;width:0.77in;line-height:0.18in;">
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000">Nb contacts</span>
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>
    <br/>
</div>

<div style="position:absolute;top:3.95in;left:2.17in;line-height:0.18in;">
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"><?= $campagne->nbre_contact ?></span>
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>
    <br/>
</div>

<div style="position:absolute;top:4.23in;left:0.65in;width:0.52in;line-height:0.18in;">
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000">Nb SMS</span>
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>
    <br/>
</div>

<div style="position:absolute;top:4.23in;left:2.17in;line-height:0.18in;">
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"><?= $nbre_sms ?></span>
    <span style="font-style:normal;font-weight:normal;font-size:9pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>
    <br/>
</div>

<div style="position:absolute;top:2.26in;left:0.65in;width:2.02in;line-height:0.25in;">
    <span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:QQAAAA+OpenSans-Regular;color:#000000">Détails de la campagne</span>
    <span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>
    <br/>
</div>

<div style="position:absolute;top:5.75in;left:0.65in;width:2.03in;line-height:0.25in;">
    <span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:QQAAAA+OpenSans-Regular;color:#000000">Statistiques AllMySMS</span>
    <span style="font-style:normal;font-weight:normal;font-size:12pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>
    <br/>
</div>

<div style="position:absolute;top:6.27in;left:3.86in;line-height:0.27in;">
    <span style="font-style:normal;font-weight:normal;font-size:13pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"><?= $campagne->nbre_envoye ?> SMS envoyé(s)</span>
    <span style="font-style:normal;font-weight:normal;font-size:13pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>
    <br/>
</div>

<div style="position:absolute;top:6.76in;left:1.19in;width:0.76in;line-height:0.20in;">
    <span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:QQAAAA+OpenSans-Regular;color:#000000">SMS reçus</span>
    <span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>

    <br/></SPAN>
</div>

<div style="position:absolute;top:6.76in;left:4.00in;width:1.21in;line-height:0.20in;">
    <span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:QQAAAA+OpenSans-Regular;color:#000000">SMS programmé</span>
    <span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>

    <br/></SPAN>
</div>

<div style="position:absolute;top:6.76in;left:6.90in;width:1.23in;line-height:0.20in;">
    <span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:QQAAAA+OpenSans-Regular;color:#000000">SMS non délivrés</span>
    <span style="font-style:normal;font-weight:normal;font-size:10pt;font-family:QQAAAA+OpenSans-Regular;color:#000000"> </span>

    <br/></SPAN>
</div>


<div style="position:absolute;top:8.36in;left:1.26in;width:0.62in;line-height:0.27in;">
    <span style="font-style:normal;font-weight:normal;font-size:13pt;font-family:QQAAAA+OpenSans-Regular;color:#17900c"><?= $nbre_envoye ?> SMS</span>
    <span style="font-style:normal;font-weight:normal;font-size:13pt;font-family:QQAAAA+OpenSans-Regular;color:#17900c"> </span>

    <br/></SPAN>
</div>

<div style="position:absolute;top:8.36in;left:4.20in;width:0.62in;line-height:0.27in;">
    <span style="font-style:normal;font-weight:normal;font-size:13pt;font-family:QQAAAA+OpenSans-Regular;color:#ff9900"><?= $nbre_programme ?> SMS</span>
    <span style="font-style:normal;font-weight:normal;font-size:13pt;font-family:QQAAAA+OpenSans-Regular;color:#ff9900"> </span>

    <br/></SPAN>
</div>

<div style="position:absolute;top:8.36in;left:7.21in;width:0.62in;line-height:0.27in;">
    <span style="font-style:normal;font-weight:normal;font-size:13pt;font-family:QQAAAA+OpenSans-Regular;color:#d44f02"><?= $nbre_echec ?> SMS</span>
    <span style="font-style:normal;font-weight:normal;font-size:13pt;font-family:QQAAAA+OpenSans-Regular;color:#d44f02"> </span>

    <br/></SPAN>
</div>



<div style="position:absolute;top:7.50in;left:1.23in;width:0.70in;line-height:0.34in;">
    <span style="font-style:normal;font-weight:normal;font-size:16pt;font-family:QQAAAA+OpenSans-Regular;color:#17900c"><?= $pourcentage[$campagne->id]['envoye'] ?></span>
    <span style="font-style:normal;font-weight:normal;font-size:16pt;font-family:QQAAAA+OpenSans-Regular;color:#17900c"> </span>

    <br/></SPAN>
</div>

<div style="position:absolute;top:7.50in;left:4.35in;width:0.41in;line-height:0.34in;">
    <span style="font-style:normal;font-weight:normal;font-size:16pt;font-family:QQAAAA+OpenSans-Regular;color:#ff9900"><?= $pourcentage[$campagne->id]['programme'] ?></span>
    <span style="font-style:normal;font-weight:normal;font-size:16pt;font-family:QQAAAA+OpenSans-Regular;color:#ff9900"> </span>

    <br/></SPAN>
</div>

<div style="position:absolute;top:7.50in;left:7.32in;width:0.41in;line-height:0.34in;">
    <span style="font-style:normal;font-weight:normal;font-size:16pt;font-family:QQAAAA+OpenSans-Regular;color:#d44f02"><?= $pourcentage[$campagne->id]['echec'] ?></span>
    <span style="font-style:normal;font-weight:normal;font-size:16pt;font-family:QQAAAA+OpenSans-Regular;color:#d44f02"> </span>

    <br/></SPAN>
</div>
