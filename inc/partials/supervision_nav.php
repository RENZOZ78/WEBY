<?php
  /* Navigation de la supervision (super administrateur) */
  require_once("views/SuperAdministrateur/supervision/_outils.php");
  $pagesSupervision = [
    "tableau" => ["fa-satellite-dish", "Tableau de bord"],
    "audience" => ["fa-chart-column", "Audience"],
    "activite" => ["fa-clock-rotate-left", "Journal d'activité"],
    "comptes" => ["fa-users", "Comptes"],
    "systeme" => ["fa-server", "État du site"],
    "personnaliser" => ["fa-sliders", "Personnaliser"],
  ];
  $pageSupervisionCourante = explode("/", trim((string)($_GET['page'] ?? ""), "/"))[1] ?? "";
  if($pageSupervisionCourante === "") $pageSupervisionCourante = "tableau";
?>
<nav class="espace-nav" aria-label="Supervision">
  <?php foreach($pagesSupervision as $route => $lien) : ?>
    <a href="<?= URL ?>supervision/<?= $route ?>" class="<?= $pageSupervisionCourante === $route ? 'active' : '' ?>"<?= $pageSupervisionCourante === $route ? ' aria-current="page"' : '' ?>><i class="fas <?= $lien[0] ?>"></i><?= $lien[1] ?></a>
  <?php endforeach; ?>
  <a href="<?= URL ?>administration/tableau" class="ms-lg-auto"><i class="fas fa-screwdriver-wrench"></i>Administration</a>
</nav>
