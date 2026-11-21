<?php
  /* Bloc « Qui suis-je » : photo, prénom, parcours, contact direct.
   * Données : config/config.php (qui_prenom, qui_role, qui_texte, qui_photo).
   * Le bloc ne s'affiche PAS tant que le prénom, le texte ou la photo manquent (ou que le fichier photo n'existe pas).
   * $qui_sur_contact = true : inclus sur la page contact (pas de bouton vers le formulaire, déjà au-dessus). */
  $site = $site ?? require("config/config.php");
  $quiPrenom = trim((string)($site['qui_prenom'] ?? ""));
  $quiTexte = trim((string)($site['qui_texte'] ?? ""));
  $quiPhoto = ltrim(trim((string)($site['qui_photo'] ?? "")), "/");
  if($quiPrenom !== "" && $quiTexte !== "" && $quiPhoto !== "" && is_file($quiPhoto)) :
    $quiRole = trim((string)($site['qui_role'] ?? ""));
    $quiTaille = @getimagesize($quiPhoto);
    $quiParagraphes = preg_split('/\R\s*\R/', $quiTexte);
?>
<section class="section qui-suis-je" id="qui-suis-je" aria-labelledby="qui-suis-je-titre">
  <div class="container">
    <div class="qui-grille">
      <figure class="qui-photo">
        <img src="<?= URL.htmlspecialchars(str_replace(' ', '%20', $quiPhoto)) ?>" alt="Portrait de <?= htmlspecialchars($quiPrenom) ?>"<?= $quiTaille ? ' '.$quiTaille[3] : '' ?> loading="lazy">
      </figure>
      <div class="qui-texte">
        <h2 id="qui-suis-je-titre">Qui suis-je ?</h2>
        <p class="qui-nom"><strong><?= htmlspecialchars($quiPrenom) ?></strong><?php if($quiRole !== "") : ?><span><?= htmlspecialchars($quiRole) ?></span><?php endif; ?></p>
        <?php foreach($quiParagraphes as $paragraphe) : ?>
          <p><?= nl2br(htmlspecialchars(trim($paragraphe))) ?></p>
        <?php endforeach; ?>
        <ul class="qui-contact" aria-label="Me joindre directement">
          <li><a href="tel:<?= str_replace(' ', '', htmlspecialchars($site['telephone'])) ?>"><i class="fas fa-phone" aria-hidden="true"></i><?= htmlspecialchars($site['telephone']) ?></a></li>
          <li><a href="mailto:<?= htmlspecialchars($site['mail_contact']) ?>"><i class="fas fa-envelope" aria-hidden="true"></i><?= htmlspecialchars($site['mail_contact']) ?></a></li>
        </ul>
        <?php if(empty($qui_sur_contact)) : ?>
          <a href="<?= URL ?>contact" class="btn btn-gold">Demander un devis gratuit</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
