<section class="section">
  <div class="container">
    <?php include "inc/partials/espace_nav.php"; ?>
    <?php if(empty($projets)) : ?>
      <div class="dash-card"><div class="empty-state"><i class="fas fa-rocket"></i>Vous n'avez pas encore de projet avec nous.<br><a href="<?= URL ?>contact" class="btn btn-gold btn-sm mt-3">Demander un devis gratuit</a></div></div>
    <?php else : ?>
      <div class="row g-4">
        <?php foreach($projets as $projet) : ?>
          <div class="col-md-6">
            <div class="dash-card">
              <div class="d-flex align-items-start justify-content-between gap-3 mb-2">
                <div>
                  <span class="kicker mb-1"><?= EspaceManager::TYPES[$projet['type']] ?? "Projet" ?></span>
                  <h2 class="h5 mb-0 d-block"><a href="<?= URL ?>compte/projet/<?= $projet['id'] ?>" class="text-white"><?= $projet['titre'] ?></a></h2>
                </div>
                <span class="badge-etape e<?= (int)$projet['etape'] ?>"><?= EspaceManager::ETAPES[(int)$projet['etape']] ?? "" ?></span>
              </div>
              <?php $etapeCourante = (int)$projet['etape']; $compact = false; include "inc/partials/etapes.php"; ?>
              <?php if(!empty($projet['note'])) : ?><p class="text-muted-wc small mb-3"><?= nl2br($projet['note']) ?></p><?php endif; ?>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted-wc">Mis à jour le <?= Toolbox::dateFr($projet['updated_at'], false) ?></small>
                <a href="<?= URL ?>compte/projet/<?= $projet['id'] ?>" class="link-arrow">Voir le projet <i class="fas fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
