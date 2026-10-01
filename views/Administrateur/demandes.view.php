<section class="section">
  <div class="container">
    <?php include "inc/partials/admin_nav.php"; ?>
    <div class="admin-nav">
      <a href="<?= URL ?>administration/demandes" class="<?= $statut_filtre === "" ? "active" : "" ?>">Toutes</a>
      <?php foreach(EspaceManager::STATUTS_DEMANDE as $cle => $libelle) : ?>
        <a href="<?= URL ?>administration/demandes?statut=<?= $cle ?>" class="<?= $statut_filtre === $cle ? "active" : "" ?>"><?= $libelle ?>s</a>
      <?php endforeach; ?>
    </div>
    <div class="table-card">
      <?php if(empty($demandes)) : ?>
        <div class="empty-state"><i class="fas fa-inbox"></i>Aucune demande<?= $statut_filtre ? " avec ce statut" : "" ?>.</div>
      <?php else : ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead><tr><th>Sujet</th><th>De</th><th>Statut</th><th>Messages</th><th>Dernière activité</th><th></th></tr></thead>
            <tbody>
              <?php foreach($demandes as $demande) : ?>
                <tr>
                  <td><a href="<?= URL ?>administration/demande/<?= $demande['id'] ?>"><?= $demande['sujet'] ?></a></td>
                  <td><?= $demande['nom'] ?><br><small class="text-muted-wc"><?= $demande['login'] ? "Client ".$demande['login'] : "Visiteur" ?> · <?= $demande['mail'] ?></small></td>
                  <td><span class="status-badge <?= $demande['statut'] ?>"><?= EspaceManager::STATUTS_DEMANDE[$demande['statut']] ?? "" ?></span></td>
                  <td><?= (int)$demande['nb_messages'] ?></td>
                  <td class="text-muted-wc"><?= Toolbox::dateFr($demande['updated_at']) ?></td>
                  <td class="text-end"><a href="<?= URL ?>administration/demande/<?= $demande['id'] ?>" class="btn btn-light btn-sm">Répondre</a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
