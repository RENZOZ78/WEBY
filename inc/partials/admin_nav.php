<?php
  /* Navigation de l'administration */
  $pagesAdmin = [
    "tableau" => ["fa-gauge-high", "Tableau de bord"],
    "demandes" => ["fa-inbox", "Demandes"],
    "projets" => ["fa-diagram-project", "Projets"],
    "gestionUtilisateurs" => ["fa-users", "Clients"],
    "droits" => ["fa-user-shield", "Droits"],
  ];
  if(Securite::estSuperAdministrateur()){
    $pagesAdmin["gestionFullUtilisateur"] = ["fa-user-gear", "Gestion complète"];
  }
  $parentsAdmin = ["demande" => "demandes", "projet" => "projets", "nouveauProjet" => "projets", "" => "tableau"];
  $pageAdminCourante = explode("/", trim((string)($_GET['page'] ?? ""), "/"))[1] ?? "";
  $pageAdminCourante = $parentsAdmin[$pageAdminCourante] ?? $pageAdminCourante;
  $nbNouvelles = $nbNouvelles ?? null;
?>
<nav class="espace-nav" aria-label="Administration">
  <?php foreach($pagesAdmin as $route => $lien) : ?>
    <a href="<?= URL ?>administration/<?= $route ?>" class="<?= $pageAdminCourante === $route ? 'active' : '' ?>"><i class="fas <?= $lien[0] ?>"></i><?= $lien[1] ?></a>
  <?php endforeach; ?>
  <a href="<?= URL ?>administration/nouveauProjet" class="ms-lg-auto"><i class="fas fa-plus"></i>Nouveau projet</a>
  <?php if(Securite::estSuperAdministrateur()) : ?>
    <a href="<?= URL ?>supervision/tableau"><i class="fas fa-satellite-dish"></i>Supervision</a>
  <?php endif; ?>
</nav>
