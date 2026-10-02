<?php
  /* Navigation de l'espace client */
  $pagesEspace = [
    "tableau" => ["fa-gauge-high", "Mon espace"],
    "projets" => ["fa-diagram-project", "Mes projets"],
    "documents" => ["fa-folder-open", "Mes documents"],
    "demandes" => ["fa-comments", "Mes demandes"],
    "profil" => ["fa-id-card", "Mon profil"],
  ];
  $parents = ["projet" => "projets", "document" => "documents", "demande" => "demandes", "nouvelleDemande" => "demandes", "modificationPassword" => "profil", "" => "tableau"];
  $pageEspaceCourante = explode("/", trim((string)($_GET['page'] ?? ""), "/"))[1] ?? "";
  $pageEspaceCourante = $parents[$pageEspaceCourante] ?? $pageEspaceCourante;
?>
<nav class="espace-nav" aria-label="Espace client">
  <?php foreach($pagesEspace as $route => $lien) : ?>
    <a href="<?= URL ?>compte/<?= $route ?>" class="<?= $pageEspaceCourante === $route ? 'active' : '' ?>"><i class="fas <?= $lien[0] ?>"></i><?= $lien[1] ?></a>
  <?php endforeach; ?>
  <a href="<?= URL ?>compte/nouvelleDemande" class="ms-lg-auto"><i class="fas fa-plus"></i>Nouvelle demande</a>
</nav>
