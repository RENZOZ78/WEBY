<?php
  $pagesAdmin = [
    "droits" => ["fa-user-shield", "Droits"],
    "gestionUtilisateurs" => ["fa-users", "Utilisateurs"],
    "gestionCommandes" => ["fa-receipt", "Commandes"],
    "gestionProduits" => ["fa-box", "Produits"],
  ];
  if(Securite::estSuperAdministrateur()){
    $pagesAdmin = ["gestionFullUtilisateur" => ["fa-user-gear", "Gestion complète"]] + $pagesAdmin;
  }
  $pageAdminCourante = explode("/", trim((string)($_GET['page'] ?? ""), "/"))[1] ?? "";
?>
<nav class="admin-nav" aria-label="Administration">
  <?php foreach($pagesAdmin as $route => $lien) : ?>
    <a href="<?= URL ?>administration/<?= $route ?>" class="<?= $pageAdminCourante === $route ? 'active' : '' ?>"><i class="fas <?= $lien[0] ?> me-2"></i><?= $lien[1] ?></a>
  <?php endforeach; ?>
</nav>
