<section class="section">
  <div class="container">
    <?php include "inc/partials/admin_nav.php"; ?>

    <div class="row g-3 mb-4">
      <div class="col-6 col-lg-2"><a href="<?= URL ?>administration/demandes?statut=nouvelle" class="stat-mini"><span class="icon pink"><i class="fas fa-inbox"></i></span><div><div class="val"><?= $stats['demandes_nouvelles'] ?></div><div class="lbl">nouvelles demandes</div></div></a></div>
      <div class="col-6 col-lg-2"><a href="<?= URL ?>administration/demandes?statut=en_cours" class="stat-mini"><span class="icon cyan"><i class="fas fa-comments"></i></span><div><div class="val"><?= $stats['demandes_en_cours'] ?></div><div class="lbl">en cours</div></div></a></div>
      <div class="col-6 col-lg-2"><a href="<?= URL ?>administration/projets" class="stat-mini"><span class="icon"><i class="fas fa-diagram-project"></i></span><div><div class="val"><?= $stats['projets_actifs'] ?></div><div class="lbl">projets actifs</div></div></a></div>
      <div class="col-6 col-lg-2"><div class="stat-mini"><span class="icon green"><i class="fas fa-circle-check"></i></span><div><div class="val"><?= $stats['projets_livres'] ?></div><div class="lbl">projets livrés</div></div></div></div>
      <div class="col-6 col-lg-2"><a href="<?= URL ?>administration/gestionUtilisateurs" class="stat-mini"><span class="icon cyan"><i class="fas fa-users"></i></span><div><div class="val"><?= $stats['clients'] ?></div><div class="lbl">clients</div></div></a></div>
      <div class="col-6 col-lg-2"><div class="stat-mini"><span class="icon"><i class="fas fa-folder-open"></i></span><div><div class="val"><?= $stats['documents'] ?></div><div class="lbl">documents</div></div></div></div>
    </div>

    <div class="row g-4">
      <div class="col-lg-6">
        <div class="dash-card">
          <h2><span><i class="fas fa-inbox"></i>Dernières demandes</span><a href="<?= URL ?>administration/demandes">Tout voir</a></h2>
          <?php if(empty($demandes)) : ?>
            <p class="text-muted-wc mb-0">Aucune demande pour le moment.</p>
          <?php else : ?>
            <?php foreach($demandes as $demande) : ?>
              <div class="list-item">
                <div class="txt">
                  <a href="<?= URL ?>administration/demande/<?= $demande['id'] ?>"><?= $demande['sujet'] ?></a>
                  <small><?= $demande['nom'] ?><?= $demande['login'] ? " (client ".$demande['login'].")" : " (visiteur)" ?> · <?= Toolbox::dateFr($demande['updated_at']) ?></small>
                </div>
                <span class="status-badge <?= $demande['statut'] ?>"><?= EspaceManager::STATUTS_DEMANDE[$demande['statut']] ?? "" ?></span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="dash-card">
          <h2><span><i class="fas fa-diagram-project"></i>Projets récents</span><a href="<?= URL ?>administration/projets">Tout voir</a></h2>
          <?php if(empty($projets)) : ?>
            <p class="text-muted-wc">Aucun projet. Créez-en un pour un client.</p>
            <a href="<?= URL ?>administration/nouveauProjet" class="btn btn-gold btn-sm"><i class="fas fa-plus me-1"></i>Nouveau projet</a>
          <?php else : ?>
            <?php foreach($projets as $projet) : ?>
              <div class="list-item">
                <div class="txt">
                  <a href="<?= URL ?>administration/projet/<?= $projet['id'] ?>"><?= $projet['titre'] ?></a>
                  <small><?= $projet['login'] ?> · <?= EspaceManager::TYPES[$projet['type']] ?? "" ?> · <?= Toolbox::dateFr($projet['updated_at'], false) ?></small>
                </div>
                <span class="badge-etape e<?= (int)$projet['etape'] ?>"><?= EspaceManager::ETAPES[(int)$projet['etape']] ?? "" ?></span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
