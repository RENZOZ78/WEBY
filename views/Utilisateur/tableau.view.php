<section class="section">
  <div class="container">
    <?php include "inc/partials/espace_nav.php"; ?>

    <?php $enCours = array_filter($projets, fn($p) => (int)$p['etape'] < 4); $ouvertes = array_filter($demandes, fn($d) => $d['statut'] !== "traitee"); ?>
    <div class="row g-3 mb-4">
      <div class="col-6 col-lg-3"><div class="stat-mini"><span class="icon"><i class="fas fa-diagram-project"></i></span><div><div class="val"><?= count($enCours) ?></div><div class="lbl">projet<?= count($enCours) > 1 ? "s" : "" ?> en cours</div></div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-mini"><span class="icon green"><i class="fas fa-circle-check"></i></span><div><div class="val"><?= count($projets) - count($enCours) ?></div><div class="lbl">livré<?= count($projets) - count($enCours) > 1 ? "s" : "" ?></div></div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-mini"><span class="icon cyan"><i class="fas fa-folder-open"></i></span><div><div class="val"><?= count($documents) ?></div><div class="lbl">document<?= count($documents) > 1 ? "s" : "" ?> récents</div></div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-mini"><span class="icon pink"><i class="fas fa-comments"></i></span><div><div class="val"><?= count($ouvertes) ?></div><div class="lbl">demande<?= count($ouvertes) > 1 ? "s" : "" ?> ouverte<?= count($ouvertes) > 1 ? "s" : "" ?></div></div></div></div>
    </div>

    <div class="row g-4">
      <div class="col-lg-7">
        <div class="dash-card">
          <h2><span><i class="fas fa-diagram-project"></i>Mes projets</span><a href="<?= URL ?>compte/projets">Tout voir</a></h2>
          <?php if(empty($projets)) : ?>
            <div class="empty-state py-4"><i class="fas fa-rocket"></i>Aucun projet pour le moment.<br><a href="<?= URL ?>contact" class="btn btn-gold btn-sm mt-3">Demander un devis</a></div>
          <?php else : ?>
            <?php foreach(array_slice($projets, 0, 4) as $projet) : ?>
              <div class="list-item flex-column align-items-stretch">
                <div class="d-flex align-items-center gap-3">
                  <div class="txt">
                    <a href="<?= URL ?>compte/projet/<?= $projet['id'] ?>"><?= $projet['titre'] ?></a>
                    <small><?= EspaceManager::TYPES[$projet['type']] ?? "" ?> · mis à jour le <?= Toolbox::dateFr($projet['updated_at'], false) ?></small>
                  </div>
                  <span class="badge-etape e<?= (int)$projet['etape'] ?>"><?= EspaceManager::ETAPES[(int)$projet['etape']] ?? "" ?></span>
                </div>
                <?php $etapeCourante = (int)$projet['etape']; $compact = true; include "inc/partials/etapes.php"; ?>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="dash-card mb-4">
          <h2><span><i class="fas fa-folder-open"></i>Derniers documents</span><a href="<?= URL ?>compte/documents">Tout voir</a></h2>
          <?php if(empty($documents)) : ?>
            <p class="text-muted-wc mb-0">Vos devis, factures et documents apparaîtront ici.</p>
          <?php else : ?>
            <?php foreach($documents as $document) : ?>
              <div class="list-item">
                <span class="icon"><i class="fas fa-file-lines"></i></span>
                <div class="txt"><a href="<?= URL ?>compte/document/<?= $document['id'] ?>"><?= $document['nom'] ?></a><small><?= EspaceManager::CATEGORIES_DOCUMENT[$document['categorie']] ?? "" ?> · <?= Toolbox::dateFr($document['created_at'], false) ?></small></div>
                <a href="<?= URL ?>compte/document/<?= $document['id'] ?>" class="btn btn-light btn-sm" aria-label="Télécharger"><i class="fas fa-download"></i></a>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="dash-card">
          <h2><span><i class="fas fa-comments"></i>Mes demandes</span><a href="<?= URL ?>compte/demandes">Tout voir</a></h2>
          <?php if(empty($demandes)) : ?>
            <p class="text-muted-wc">Une question, une modification à faire ?</p>
            <a href="<?= URL ?>compte/nouvelleDemande" class="btn btn-outline-navy btn-sm"><i class="fas fa-plus me-1"></i>Nouvelle demande</a>
          <?php else : ?>
            <?php foreach($demandes as $demande) : ?>
              <div class="list-item">
                <div class="txt"><a href="<?= URL ?>compte/demande/<?= $demande['id'] ?>"><?= $demande['sujet'] ?></a><small><?= Toolbox::dateFr($demande['updated_at']) ?></small></div>
                <span class="status-badge <?= $demande['statut'] ?>"><?= EspaceManager::STATUTS_DEMANDE[$demande['statut']] ?? "" ?></span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
