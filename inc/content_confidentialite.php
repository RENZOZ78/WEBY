<?php
  /* Politique de confidentialité : décrit les traitements réellement faits par le code du site.
   * À tenir à jour si le code change : formulaire de contact (Visiteur.controller, antiSpam), comptes
   * (Utilisateur.controller), journal (models/Supervision/Journal), audience (models/Supervision/Audience),
   * ressources externes (views/common/template.php). Identité : config/config.php. */
  require_once "inc/legal.php";
  require_once "models/Supervision/Audience.class.php";
  $site = $site ?? require("config/config.php");
  $mail = legal_texte($site, "mail_contact");
  $tel = legal_texte($site, "telephone");
  $joursConservation = Audience::CONSERVATION_JOURS;
  $sommaire = [
    "responsable" => "Qui traite vos données",
    "contact" => "Formulaire de contact",
    "compte" => "Espace client",
    "journal" => "Journal de sécurité",
    "audience" => "Mesure d'audience",
    "cookies" => "Cookies",
    "tiers" => "Services externes",
    "destinataires" => "Destinataires",
    "droits" => "Vos droits",
  ];
?>
<section class="section legal">
  <div class="container">
    <?= legal_alerte($site) ?>
    <div class="legal-grille">
      <nav class="legal-sommaire" aria-label="Sommaire de la page">
        <h2>Sur cette page</h2>
        <ol>
          <?php foreach($sommaire as $ancre => $titre) : ?>
            <li><a href="#<?= $ancre ?>"><?= $titre ?></a></li>
          <?php endforeach; ?>
        </ol>
      </nav>

      <div class="legal-texte">
        <p class="legal-chapo">Ce site collecte peu de données : celles que vous nous écrivez, celles de votre espace client si vous en créez un, et une mesure d'audience anonyme. Aucune publicité, aucun traceur tiers, aucune revente.</p>

        <h2 id="responsable">Qui traite vos données</h2>
        <p>Le responsable du traitement est l'éditeur du site : <?= legal_valeur($site, "legal_nom") ?>, <?= legal_valeur($site, "legal_adresse") ?>.</p>
        <p>Pour toute question sur vos données : <a href="mailto:<?= $mail ?>"><?= $mail ?></a> ou <a href="tel:<?= str_replace(' ', '', $tel) ?>"><?= $tel ?></a>. L'identité complète de l'éditeur figure dans les <a href="<?= URL ?>mentions-legales">mentions légales</a>.</p>

        <h2 id="contact">Formulaire de contact</h2>
        <dl class="legal-fiche">
          <div><dt>Données</dt><dd>Nom, adresse email, sujet et message que vous saisissez.</dd></div>
          <div><dt>Finalité</dt><dd>Répondre à votre demande et établir un devis.</dd></div>
          <div><dt>Base légale</dt><dd>Mesures précontractuelles prises à votre demande (art. 6.1.b du RGPD).</dd></div>
          <div><dt>Conservation</dt><dd>Votre demande est enregistrée dans l'outil de suivi de l'agence et transmise par email à l'agence. Elle est conservée le temps de son traitement et du suivi de la relation commerciale, et supprimée sur simple demande de votre part.</dd></div>
        </dl>
        <p>Un filtre anti-spam automatique vérifie le délai d'envoi et le contenu du message (liens, démarchage). Un message refusé n'est ni enregistré ni transmis ; seuls le nom, le sujet et le motif du refus sont notés dans le journal de sécurité.</p>

        <h2 id="compte">Espace client</h2>
        <dl class="legal-fiche">
          <div><dt>Données</dt><dd>Identifiant, adresse email, mot de passe (enregistré sous forme chiffrée, illisible pour l'agence), photo de profil si vous en ajoutez une ; puis vos projets, vos documents, vos demandes et vos messages échangés avec l'agence.</dd></div>
          <div><dt>Finalité</dt><dd>Suivre vos projets, mettre vos documents à votre disposition et échanger avec vous.</dd></div>
          <div><dt>Base légale</dt><dd>Exécution du contrat ou de mesures précontractuelles (art. 6.1.b du RGPD).</dd></div>
          <div><dt>Conservation</dt><dd>Jusqu'à la suppression de votre compte. Vous pouvez le supprimer vous-même depuis <em>Mon profil</em> : vos projets, documents, demandes, messages et votre photo sont alors effacés du site.</dd></div>
        </dl>
        <p>Un email de validation est envoyé à la création du compte. L'agence reste tenue de conserver, hors du site, les pièces comptables (devis, factures) pendant les durées imposées par la loi.</p>

        <h2 id="journal">Journal de sécurité</h2>
        <p>Pour protéger les comptes et détecter les abus, le site note les événements importants : connexions et échecs de connexion, création, validation ou suppression de compte, demandes, dépôts et téléchargements de documents. Chaque ligne contient la date, l'identifiant concerné s'il y en a un et une adresse IP tronquée (la fin de l'adresse est effacée). Ces lignes sont supprimées après <?= $joursConservation ?> jours. Base légale : intérêt légitime de l'éditeur à sécuriser le site (art. 6.1.f du RGPD).</p>

        <h2 id="audience">Mesure d'audience</h2>
        <p>La fréquentation est mesurée par un outil interne au site, sans service externe et sans cookie de mesure. Pour chaque page publique vue, le site enregistre : la page, la date, le site de provenance, le type d'appareil (ordinateur, mobile ou tablette) et une empreinte anonyme. Il note aussi les clics sur le numéro de téléphone et l'adresse email affichés.</p>
        <p>Votre adresse IP n'est pas conservée. L'empreinte est calculée à partir de l'adresse IP, du navigateur et de la date, puis rendue irréversible ; elle change chaque jour et ne permet pas de vous suivre d'un jour à l'autre ni d'un site à l'autre. Ces mesures sont supprimées après <?= $joursConservation ?> jours. Base légale : intérêt légitime de l'éditeur à connaître la fréquentation de son site (art. 6.1.f du RGPD).</p>

        <h2 id="cookies">Cookies</h2>
        <p>Le site dépose un seul cookie, le cookie de session (<code>PHPSESSID</code>). Il est strictement nécessaire : il protège les formulaires contre les envois frauduleux et vous maintient connecté à votre espace client. Il est supprimé à la fermeture du navigateur. Il n'y a aucun cookie publicitaire ni de mesure d'audience, donc pas de bandeau de consentement.</p>

        <h2 id="tiers">Services externes</h2>
        <p>Pour s'afficher, les pages chargent des fichiers techniques auprès de deux services : les polices de caractères (Google Fonts) et des bibliothèques d'affichage (jsDelivr). Votre navigateur communique alors à ces services votre adresse IP et le type de votre navigateur, comme pour toute page web. Aucune autre donnée ne leur est transmise par le site.</p>
        <p>Aucun paiement n'est réalisé sur ce site : aucune donnée bancaire n'y est saisie ni conservée.</p>

        <h2 id="destinataires">Destinataires</h2>
        <p>Vos données sont lues uniquement par l'agence. Elles sont stockées chez l'hébergeur du site, <?= legal_valeur($site, "hebergeur_nom") ?>, qui agit comme sous-traitant technique, y compris pour l'envoi des emails du site. Elles ne sont ni vendues, ni louées, ni cédées à des tiers.</p>

        <h2 id="droits">Vos droits</h2>
        <p>Vous pouvez demander l'accès à vos données, leur rectification, leur effacement, la limitation de leur traitement, leur portabilité, ou vous opposer à leur traitement. Écrivez à <a href="mailto:<?= $mail ?>"><?= $mail ?></a> : nous répondons dans un délai d'un mois.</p>
        <p>Si vous estimez que vos droits ne sont pas respectés, vous pouvez adresser une réclamation à la CNIL (<a href="https://www.cnil.fr/fr/plaintes" rel="noopener">cnil.fr/fr/plaintes</a>).</p>
      </div>
    </div>
  </div>
</section>
