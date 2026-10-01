<section class="section">
  <div class="container">
    <?php include "inc/partials/espace_nav.php"; ?>
    <div class="row g-4">
      <div class="col-lg-7">
        <div class="dash-card mb-4">
          <h2><span><i class="fas fa-list-check"></i>Avancement</span><span class="badge-etape e<?= (int)$projet['etape'] ?>"><?= EspaceManager::ETAPES[(int)$projet['etape']] ?? "" ?></span></h2>
          <?php $etapeCourante = (int)$projet['etape']; $compact = false; include "inc/partials/etapes.php"; ?>
          <?php if(!empty($projet['note'])) : ?>
            <div class="alert alert-warning mb-0 mt-3"><i class="fas fa-circle-info me-2"></i><?= nl2br($projet['note']) ?></div>
          <?php else : ?>
            <p class="text-muted-wc mb-0 mt-3">Nous vous tenons informé ici à chaque étape. Vous recevez aussi un mail à chaque nouveau document.</p>
          <?php endif; ?>
          <p class="small text-muted-wc mt-3 mb-0">Projet créé le <?= Toolbox::dateFr($projet['created_at'], false) ?> · dernière mise à jour le <?= Toolbox::dateFr($projet['updated_at']) ?></p>
        </div>

        <div class="dash-card">
          <h2><span><i class="fas fa-folder-open"></i>Documents du projet</span></h2>
          <?php if(empty($documents)) : ?>
            <p class="text-muted-wc mb-0">Aucun document pour l'instant. Les devis, factures et livrables apparaîtront ici.</p>
          <?php else : ?>
            <div class="d-grid gap-2">
              <?php foreach($documents as $document) : $lienDocument = URL."compte/document/".$document['id']; include "inc/partials/document_item.php"; endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="dash-card">
          <h2><span><i class="fas fa-comments"></i>Une question sur ce projet ?</span></h2>
          <p class="text-muted-wc">Envoyez-nous une demande : nous vous répondons sous 48h, directement dans votre espace.</p>
          <a href="<?= URL ?>compte/nouvelleDemande?sujet=<?= rawurlencode(html_entity_decode($projet['titre'])) ?>" class="btn btn-gold w-100"><i class="fas fa-paper-plane me-2"></i>Écrire à l'agence</a>
        </div>
      </div>
    </div>
  </div>
</section>
