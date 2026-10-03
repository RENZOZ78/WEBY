<?php $nomsRoles = ["utilisateur" => "Client", "administrateur" => "Administrateur", "superAdministrateur" => "Super admin"]; ?>
<section class="section">
  <div class="container">
    <?php include "inc/partials/supervision_nav.php"; ?>
    <div class="sv-toolbar">
      <?= sv_periodes($periode) ?>
      <a href="<?= URL ?>administration/gestionFullUtilisateur" class="btn btn-ghost btn-sm"><i class="fas fa-user-gear me-1"></i>Modifier les comptes</a>
    </div>

    <div class="row g-3 mb-4">
      <div class="col-6 col-lg-3"><div class="stat-mini"><span class="icon cyan"><i class="fas fa-users"></i></span><div><div class="val"><?= sv_nombre($stats['total']) ?></div><div class="lbl">comptes</div></div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-mini"><span class="icon green"><i class="fas fa-user-plus"></i></span><div><div class="val"><?= sv_nombre($stats['inscriptions']) ?></div><div class="lbl">créés sur la période</div></div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-mini"><span class="icon"><i class="fas fa-right-to-bracket"></i></span><div><div class="val"><?= sv_nombre($stats['actifs']) ?></div><div class="lbl">connectés sur la période</div></div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-mini"><span class="icon pink"><i class="fas fa-user-clock"></i></span><div><div class="val"><?= sv_nombre($stats['non_valides']) ?></div><div class="lbl">non validés</div></div></div></div>
    </div>

    <div class="table-card">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead><tr><th>Compte</th><th>Rôle</th><th>Dernière connexion</th><th class="text-end">Connexions</th><th class="text-end">Échecs</th><th class="text-end">Projets</th><th class="text-end">Demandes</th><th class="text-end">Documents</th></tr></thead>
          <tbody>
            <?php foreach($comptes as $c) : ?>
              <tr>
                <td>
                  <a href="<?= URL ?>supervision/activite?login=<?= rawurlencode(html_entity_decode($c['login'])) ?>&periode=<?= $periode ?>"><?= sv_txt($c['login']) ?></a>
                  <small class="d-block text-muted-wc"><?= sv_txt($c['mail']) ?></small>
                </td>
                <td class="text-nowrap">
                  <span class="sv-role <?= sv_txt($c['role']) ?>"><?= $nomsRoles[$c['role']] ?? sv_txt($c['role']) ?></span>
                  <?php if((int)$c['is_valid'] === 0) : ?><span class="status-badge ko">non validé</span><?php endif; ?>
                </td>
                <td class="text-nowrap" title="<?= $c['derniere_connexion'] ? Toolbox::dateFr($c['derniere_connexion']) : "" ?>"><?= sv_depuis($c['derniere_connexion']) ?></td>
                <td class="text-end"><?= (int)$c['connexions'] ?></td>
                <td class="text-end<?= $c['echecs'] >= 5 ? " sv-alerte-txt" : "" ?>"><?= (int)$c['echecs'] ?></td>
                <td class="text-end"><?= (int)$c['projets'] ?></td>
                <td class="text-end"><?= (int)$c['demandes'] ?></td>
                <td class="text-end"><?= (int)$c['documents'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <p class="sv-note mt-3">Connexions et échecs sur <?= SupervisionController::PERIODES[$periode] ?>. Les connexions sont enregistrées depuis la mise en ligne de la supervision.</p>
  </div>
</section>
