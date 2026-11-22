<?php
  /* Mentions légales (art. 6-III de la loi n° 2004-575 du 21 juin 2004, LCEN).
   * Toutes les valeurs viennent de config/config.php (clés legal_* et hebergeur_*). */
  require_once "inc/legal.php";
  $site = $site ?? require("config/config.php");
  $tel = legal_texte($site, "telephone");
  $mail = legal_texte($site, "mail_contact");
  $sommaire = [
    "editeur" => "Éditeur du site",
    "publication" => "Responsable de la publication",
    "hebergeur" => "Hébergeur",
    "propriete" => "Propriété intellectuelle",
    "donnees" => "Données personnelles",
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
        <p class="legal-chapo">Le site <strong><?= htmlspecialchars(preg_replace('#^https?://|/$#', '', $site['site_url'])) ?></strong> est édité par l'entreprise présentée ci-dessous.</p>

        <h2 id="editeur">Éditeur du site</h2>
        <dl class="legal-fiche">
          <div><dt>Raison sociale ou nom</dt><dd><?= legal_valeur($site, "legal_nom") ?></dd></div>
          <?php if(legal_texte($site, "legal_nom_commercial") !== "") : ?>
            <div><dt>Nom commercial</dt><dd><?= legal_texte($site, "legal_nom_commercial") ?></dd></div>
          <?php endif; ?>
          <div><dt>Forme juridique</dt><dd><?= legal_valeur($site, "legal_forme") ?></dd></div>
          <?php if(legal_texte($site, "legal_capital") !== "") : ?>
            <div><dt>Capital social</dt><dd><?= legal_texte($site, "legal_capital") ?></dd></div>
          <?php endif; ?>
          <div><dt>SIRET</dt><dd class="chiffres"><?= legal_valeur($site, "legal_siret") ?></dd></div>
          <?php if(legal_texte($site, "legal_rcs") !== "") : ?>
            <div><dt>Immatriculation</dt><dd><?= legal_texte($site, "legal_rcs") ?></dd></div>
          <?php endif; ?>
          <?php if(legal_texte($site, "legal_tva") !== "") : ?>
            <div><dt>TVA</dt><dd><?= legal_texte($site, "legal_tva") ?></dd></div>
          <?php endif; ?>
          <div><dt>Adresse</dt><dd><?= legal_valeur($site, "legal_adresse") ?></dd></div>
          <div><dt>Téléphone</dt><dd><a href="tel:<?= str_replace(' ', '', $tel) ?>"><?= $tel ?></a></dd></div>
          <div><dt>Email</dt><dd><a href="mailto:<?= $mail ?>"><?= $mail ?></a></dd></div>
        </dl>

        <h2 id="publication">Responsable de la publication</h2>
        <p><?= legal_valeur($site, "legal_responsable") ?></p>

        <h2 id="hebergeur">Hébergeur</h2>
        <dl class="legal-fiche">
          <div><dt>Société</dt><dd><?= legal_valeur($site, "hebergeur_nom") ?></dd></div>
          <div><dt>Adresse</dt><dd><?= legal_valeur($site, "hebergeur_adresse") ?></dd></div>
          <?php if(legal_texte($site, "hebergeur_telephone") !== "") : ?>
            <div><dt>Téléphone</dt><dd><?= legal_texte($site, "hebergeur_telephone") ?></dd></div>
          <?php endif; ?>
          <?php if(legal_texte($site, "hebergeur_contact") !== "") : ?>
            <div><dt>Contact</dt><dd><a href="<?= legal_texte($site, "hebergeur_contact") ?>" rel="noopener nofollow"><?= preg_replace('#^https?://#', '', legal_texte($site, "hebergeur_contact")) ?></a></dd></div>
          <?php endif; ?>
        </dl>

        <h2 id="propriete">Propriété intellectuelle</h2>
        <p>Les textes, la mise en page, le logo et les éléments graphiques de ce site sont la propriété de l'éditeur ou de leurs auteurs respectifs. Toute reproduction ou réutilisation, totale ou partielle, sans autorisation écrite préalable est interdite, sauf exceptions prévues par le Code de la propriété intellectuelle.</p>
        <p>Les marques et logos de tiers cités sur le site appartiennent à leurs propriétaires.</p>

        <h2 id="donnees">Données personnelles</h2>
        <p>Les données collectées par le site (formulaire de contact, espace client, mesure d'audience) et vos droits sont décrits dans la <a href="<?= URL ?>confidentialite">politique de confidentialité</a>.</p>
      </div>
    </div>
  </div>
</section>
