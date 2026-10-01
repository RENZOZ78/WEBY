<section class="section">
  <div class="container">
    <?php include "inc/partials/espace_nav.php"; ?>
    <div class="dash-card">
      <h2><span><i class="fas fa-folder-open"></i>Tous mes documents</span><span class="text-muted-wc small"><?= count($documents) ?> fichier<?= count($documents) > 1 ? "s" : "" ?></span></h2>
      <?php if(empty($documents)) : ?>
        <div class="empty-state"><i class="fas fa-folder-open"></i>Vos devis, factures, contrats et rapports seront déposés ici par l'agence.</div>
      <?php else : ?>
        <div class="d-grid gap-2">
          <?php foreach($documents as $document) : $lienDocument = URL."compte/document/".$document['id']; include "inc/partials/document_item.php"; endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
