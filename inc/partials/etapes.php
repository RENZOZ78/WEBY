<?php
  /* Frise des etapes d'un projet : $etapeCourante (1 a 4), $compact (bool) */
  $compact = $compact ?? false;
?>
<div class="etapes<?= $compact ? ' compact' : '' ?>" aria-label="Avancement du projet">
  <?php foreach(EspaceManager::ETAPES as $num => $libelle) : ?>
    <div class="etape <?= $num < $etapeCourante ? 'done' : ($num === (int)$etapeCourante ? 'current' : '') ?>"><?= $libelle ?></div>
  <?php endforeach; ?>
</div>
