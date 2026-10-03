<?php
  /* Cycle animé des prestations (hero de l'accueil) : de l'idée à la gestion, puis on recommence.
     Les positions des étapes sont calculées ici (pourcentages), l'animation est dans theme.css et main.js. */
  $etapesCycle = [
    ["fa-lightbulb", "Imaginer", "Votre idée, l'étude de marché, le positionnement", "prestations/lancement", "gold"],
    ["fa-file-invoice", "Financer", "Business plan, prévisionnel, prêt bancaire", "prestations/lancement", "gold"],
    ["fa-stamp", "Créer", "Statuts, immatriculation, Kbis, ACRE", "prestations/lancement", "gold"],
    ["fa-laptop-code", "Construire", "Site internet, image de marque, SEO", "prestations/sites", "cyan"],
    ["fa-bullhorn", "Promouvoir", "Réseaux sociaux, publicité, prospects", "prestations/marketing", "cyan"],
    ["fa-folder-open", "Gérer", "Paie, RH, devis et factures", "prestations/gestion", "cyan"],
  ];
  $nbEtapes = count($etapesCycle);
  $rayon = 39; // rayon du cercle des étapes, en % du côté du visuel
  $position = function($angle) use ($rayon){
    $rad = deg2rad($angle);
    return sprintf("left:%.2f%%;top:%.2f%%", 50 + $rayon * sin($rad), 50 - $rayon * cos($rad));
  };
?>
<div class="wc-cycle" aria-label="Notre accompagnement, de l'idée à la gestion de votre entreprise">
  <svg class="cycle-rings" viewBox="0 0 100 100" aria-hidden="true">
    <defs>
      <!-- l'arc est tourné de -90° : ce dégradé va de la gauche (croissance, cyan) à la droite (lancement, or) -->
      <linearGradient id="cycle-grad" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0" stop-color="#8b5cf6"/>
        <stop offset=".35" stop-color="#3fd0ff"/>
        <stop offset=".65" stop-color="#ff8a3d"/>
        <stop offset="1" stop-color="#f3c868"/>
      </linearGradient>
    </defs>
    <circle class="ring-outer" cx="50" cy="50" r="47.5"/>
    <circle class="ring-inner" cx="50" cy="50" r="30"/>
    <circle class="ring-track" cx="50" cy="50" r="<?= $rayon ?>"/>
    <circle class="ring-progress" cx="50" cy="50" r="<?= $rayon ?>" pathLength="<?= $nbEtapes ?>"/>
  </svg>

  <!-- point lumineux qui fait le tour -->
  <span class="cycle-orbit" aria-hidden="true"><i></i></span>

  <!-- flèches entre les étapes : le sens du cycle -->
  <?php for($k = 0; $k < $nbEtapes; $k++) : $angle = ($k + .5) * 360 / $nbEtapes; ?>
    <span class="cycle-arrow" style="<?= $position($angle) ?>;--a:<?= $angle ?>deg" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
  <?php endfor; ?>

  <!-- centre : logo et étape en cours -->
  <div class="cycle-center">
    <img src="<?= URL ?>public/Assets/images/accueil/logo_aigle.svg" alt="" width="70" height="57">
    <span class="cycle-num"><b>01</b> / <?= sprintf("%02d", $nbEtapes) ?></span>
    <strong class="cycle-titre"><?= $etapesCycle[0][1] ?></strong>
    <span class="cycle-texte"><?= $etapesCycle[0][2] ?></span>
  </div>

  <ol class="cycle-steps">
    <?php foreach($etapesCycle as $k => $etape) : [$icone, $titre, $texte, $lien, $couleur] = $etape; ?>
      <li class="cycle-step <?= $couleur ?><?= $k === 0 ? ' on' : '' ?>" style="<?= $position($k * 360 / $nbEtapes) ?>;--i:<?= $k ?>" data-texte="<?= htmlspecialchars($texte) ?>">
        <a href="<?= URL.$lien ?>" title="<?= htmlspecialchars($titre." : ".$texte) ?>">
          <span class="icon"><i class="fas <?= $icone ?>"></i></span>
          <span class="lbl"><?= $titre ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ol>
</div>
