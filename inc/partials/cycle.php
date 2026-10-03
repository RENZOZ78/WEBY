<?php
  /* Cycle animé des prestations (hero de l'accueil) : de l'idée à la gestion, puis on recommence.
     Les positions des étapes sont calculées ici (pourcentages), l'animation est dans theme.css et main.js. */
  /* [icône, libellé sous la pastille, titre au centre, détail au centre, page, phase] */
  $etapesCycle = [
    ["fa-magnifying-glass-chart", "Étude de marché", "Valider votre idée", "Analyse du marché, de la concurrence et de vos clients cibles.", "prestations/lancement", "Lancement"],
    ["fa-file-invoice", "Business plan", "Convaincre votre banque", "Prévisionnel financier sur 3 ou 5 ans et dossier de prêt.", "prestations/lancement", "Lancement"],
    ["fa-stamp", "Statuts & Kbis", "Créer votre société", "Choix du statut, immatriculation et aides ACRE / ARCE.", "prestations/lancement", "Lancement"],
    ["fa-laptop-code", "Site internet", "Être visible en ligne", "Site vitrine ou e-commerce, référencement Google et maintenance.", "prestations/sites", "Croissance"],
    ["fa-bullhorn", "Marketing", "Attirer vos clients", "Plan d'action, image de marque, réseaux sociaux et publicité.", "prestations/marketing", "Croissance"],
    ["fa-folder-open", "Gestion & RH", "Déléguer votre gestion", "Devis et factures, fiches de paie, contrats de travail.", "prestations/gestion", "Croissance"],
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
    <span class="cycle-num"><b>01</b><span class="cycle-total"> / <?= sprintf("%02d", $nbEtapes) ?></span> · <span class="cycle-phase"><?= $etapesCycle[0][5] ?></span></span>
    <strong class="cycle-titre"><?= htmlspecialchars($etapesCycle[0][2]) ?></strong>
    <span class="cycle-texte"><?= htmlspecialchars($etapesCycle[0][3]) ?></span>
  </div>

  <ol class="cycle-steps">
    <?php foreach($etapesCycle as $k => $etape) : [$icone, $libelle, $titre, $texte, $lien, $phase] = $etape; ?>
      <li class="cycle-step <?= $phase === "Lancement" ? "gold" : "cyan" ?><?= $k === 0 ? ' on' : '' ?>" style="<?= $position($k * 360 / $nbEtapes) ?>;--i:<?= $k ?>" data-titre="<?= htmlspecialchars($titre) ?>" data-texte="<?= htmlspecialchars($texte) ?>" data-phase="<?= $phase ?>">
        <a href="<?= URL.$lien ?>" title="<?= htmlspecialchars($titre." : ".$texte) ?>">
          <span class="icon"><i class="fas <?= $icone ?>"></i></span>
          <span class="lbl"><?= htmlspecialchars($libelle) ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ol>
</div>
