<?php $nomsRoles = ["utilisateur" => "Clients", "administrateur" => "Administrateurs", "superAdministrateur" => "Super administrateurs"]; ?>
<div class="dash-card">
  <h2><span><i class="fas <?= $iconeWidget ?>"></i><?= $titreWidget ?></span><a href="<?= URL ?>supervision/comptes">Tout voir</a></h2>
  <div class="sv-kv">
    <div><span><?= sv_nombre($comptes['total']) ?></span>comptes</div>
    <div><span><?= sv_nombre($comptes['actifs']) ?></span>connectés sur la période</div>
    <div><span><?= sv_nombre($comptes['connexions']) ?></span>connexions</div>
    <div><span><?= sv_nombre($comptes['non_valides']) ?></span>non validés</div>
  </div>
  <h3 class="sv-subtitle">Par rôle</h3>
  <?= sv_classement(array_map(function($role, $nom) use ($comptes){ return [$nom, (int)($comptes['roles'][$role] ?? 0)]; }, array_keys($nomsRoles), $nomsRoles)) ?>
</div>
