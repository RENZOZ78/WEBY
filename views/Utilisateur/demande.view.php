<section class="section">
  <div class="container">
    <?php include "inc/partials/espace_nav.php"; ?>
    <div class="row g-4">
      <div class="col-lg-8">
        <div class="dash-card">
          <h2><span><i class="fas fa-comments"></i>Échanges</span><span class="status-badge <?= $demande['statut'] ?>"><?= EspaceManager::STATUTS_DEMANDE[$demande['statut']] ?? "" ?></span></h2>
          <div class="chat mb-4">
            <?php foreach($messages as $message) : ?>
              <div class="msg <?= $message['de_agence'] ? 'agence' : 'client' ?>">
                <div class="meta"><strong><?= $message['de_agence'] ? "WebyCloudy" : "Vous" ?></strong><span class="who"><?= $message['de_agence'] ? "Agence" : "Client" ?></span><span><?= Toolbox::dateFr($message['created_at']) ?></span></div>
                <p><?= $message['message'] ?></p>
              </div>
            <?php endforeach; ?>
          </div>
          <form method="post" action="<?= URL ?>compte/validation_message" class="needs-validation" novalidate>
            <?= Securite::csrfField() ?>
            <input type="hidden" name="demande_id" value="<?= $demande['id'] ?>">
            <label for="message" class="form-label">Répondre</label>
            <textarea class="form-control mb-3" id="message" name="message" rows="4" required maxlength="5000" placeholder="Votre message…"></textarea>
            <div class="invalid-feedback">Écrivez votre message.</div>
            <button type="submit" class="btn btn-gold"><i class="fas fa-paper-plane me-2"></i>Envoyer</button>
          </form>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="dash-card">
          <h2><span><i class="fas fa-circle-info"></i>Demande n°<?= $demande['id'] ?></span></h2>
          <p class="mb-1"><strong><?= $demande['sujet'] ?></strong></p>
          <p class="text-muted-wc small mb-3">Ouverte le <?= Toolbox::dateFr($demande['created_at']) ?></p>
          <p class="text-muted-wc small mb-0">Nous répondons sous 48h ouvrées. Vous recevez un mail à chaque réponse.</p>
        </div>
      </div>
    </div>
  </div>
</section>
