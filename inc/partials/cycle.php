<?php
  /* Cycle animé des prestations (hero de l'accueil) : Conception → Création → Gestion → Performance,
     puis la croissance nourrit de nouveaux projets et le cycle recommence.
     Les positions sont calculées ici (pourcentages), l'animation est dans theme.css et main.js. */
  /* [phase, couleur, icône, prestations (2 lignes), titre au centre, détail au centre, page] */
  $etapesCycle = [
    ["Conception", "or", "fa-compass-drafting", ["Étude de marché", "Business plan"], "Donner forme à votre idée", "Un projet étudié, chiffré et prêt à convaincre.", "prestations/lancement"],
    ["Création", "orange", "fa-rocket", ["Statuts & Kbis", "Site & identité"], "Donner vie à votre entreprise", "Société immatriculée, image affirmée, site en ligne.", "prestations/lancement"],
    ["Gestion", "cyan", "fa-folder-open", ["Devis & factures", "Paie & RH"], "Gérer en toute sérénité", "Administratif, paie et RH\u{00A0}: nous gérons, vous validez.", "prestations/gestion"],
    ["Performance", "violet", "fa-chart-line", ["Stratégie marketing", "Acquisition clients"], "Accélérer votre croissance", "Une stratégie mesurable pour vendre plus, et plus cher.", "prestations/marketing"],
  ];
  $couleursArc = ["or" => "#f3c868", "orange" => "#ff8a3d", "cyan" => "#3fd0ff", "violet" => "#8b5cf6"];
  $nbEtapes = count($etapesCycle);
  $depart = -45; // première étape en haut à gauche : le cycle se lit comme une page
  $rayon = 39; // rayon du cercle des étapes, en % du côté du visuel
  $position = function($angle) use ($rayon){
    $rad = deg2rad($angle);
    return sprintf("left:%.2f%%;top:%.2f%%", 50 + $rayon * sin($rad), 50 - $rayon * cos($rad));
  };
?>
<div class="wc-cycle" data-depart="<?= $depart ?>" aria-label="De l'idée à la performance : conception, création, gestion et performance de votre entreprise">
  <svg class="cycle-rings" viewBox="0 0 100 100" aria-hidden="true">
    <circle class="ring-outer" cx="50" cy="50" r="47.5"/>
    <circle class="ring-inner" cx="50" cy="50" r="30"/>
    <circle class="ring-track" cx="50" cy="50" r="<?= $rayon ?>"/>
    <!-- arc de progression : un segment par phase, chacun de sa couleur -->
    <g class="ring-progress">
      <?php foreach($etapesCycle as $etape) : ?>
        <circle class="ring-seg" cx="50" cy="50" r="<?= $rayon ?>" pathLength="<?= $nbEtapes ?>" style="stroke:<?= $couleursArc[$etape[1]] ?>;color:<?= $couleursArc[$etape[1]] ?>;transform:rotate(<?= $depart - 90 ?>deg)"/>
      <?php endforeach; ?>
    </g>
  </svg>

  <!-- point lumineux qui fait le tour -->
  <span class="cycle-orbit" style="transform:rotate(<?= $depart ?>deg)" aria-hidden="true"><i></i></span>

  <!-- flèches entre les étapes : le sens du cycle -->
  <?php for($k = 0; $k < $nbEtapes; $k++) : $angle = $depart + ($k + .5) * 360 / $nbEtapes; ?>
    <span class="cycle-arrow" style="<?= $position($angle) ?>;--a:<?= $angle ?>deg" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
  <?php endfor; ?>

  <!-- centre : logo et phase en cours -->
  <div class="cycle-center">
    <img src="<?= URL ?>public/Assets/images/accueil/logo_aigle.svg" alt="" width="70" height="57">
    <span class="cycle-num"><b>01</b><span class="cycle-total"> / <?= sprintf("%02d", $nbEtapes) ?></span> · <span class="cycle-phase"><?= $etapesCycle[0][0] ?></span></span>
    <strong class="cycle-titre"><?= htmlspecialchars($etapesCycle[0][4]) ?></strong>
    <span class="cycle-texte"><?= htmlspecialchars($etapesCycle[0][5]) ?></span>
  </div>

  <ol class="cycle-steps">
    <?php foreach($etapesCycle as $k => $etape) :
      [$phase, $couleur, $icone, $prestations, $titre, $texte, $lien] = $etape;
      $angle = $depart + $k * 360 / $nbEtapes;
      $cote = cos(deg2rad($angle)) > 0 ? "haut" : "bas"; // libellé à l'extérieur du cercle
    ?>
      <li class="cycle-step <?= $couleur ?> <?= $cote ?><?= $k === 0 ? ' on' : '' ?>" style="<?= $position($angle) ?>;--i:<?= $k ?>" data-titre="<?= htmlspecialchars($titre) ?>" data-texte="<?= htmlspecialchars($texte) ?>" data-phase="<?= htmlspecialchars($phase) ?>">
        <a href="<?= URL.$lien ?>" title="<?= htmlspecialchars($phase." — ".$titre." : ".$texte) ?>">
          <span class="icon"><i class="fas <?= $icone ?>"></i></span>
          <span class="lbl">
            <strong><?= htmlspecialchars($phase) ?></strong>
            <?php foreach($prestations as $prestation) : ?><small><?= htmlspecialchars($prestation) ?></small><?php endforeach; ?>
          </span>
        </a>
      </li>
    <?php endforeach; ?>
  </ol>
</div>
