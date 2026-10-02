<section class="section">
  <div class="container">
    <?php include "inc/partials/espace_nav.php"; ?>
    <div class="table-card">
      <?php if(empty($demandes)) : ?>
        <div class="empty-state"><i class="fas fa-comments"></i>Aucune demande pour le moment.<br><a href="<?= URL ?>compte/nouvelleDemande" class="btn btn-gold btn-sm mt-3"><i class="fas fa-plus me-1"></i>Nouvelle demande</a></div>
      <?php else : ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead><tr><th>Sujet</th><th>Statut</th><th>Messages</th><th>Dernière activité</th><th></th></tr></thead>
            <tbody>
              <?php foreach($demandes as $demande) : ?>
                <tr>
                  <td><a href="<?= URL ?>compte/demande/<?= $demande['id'] ?>"><?= $demande['sujet'] ?></a></td>
                  <td><span class="status-badge <?= $demande['statut'] ?>"><?= EspaceManager::STATUTS_DEMANDE[$demande['statut']] ?? "" ?></span></td>
                  <td><?= (int)$demande['nb_messages'] ?></td>
                  <td class="text-muted-wc"><?= Toolbox::dateFr($demande['updated_at']) ?></td>
                  <td class="text-end"><a href="<?= URL ?>compte/demande/<?= $demande['id'] ?>" class="btn btn-light btn-sm">Ouvrir</a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
