<section class="section">
  <div class="container">
    <?php include "inc/partials/admin_nav.php"; ?>
    <div class="row g-4">
      <div class="col-lg-8">
        <div class="dash-card">
          <h2><span><i class="fas fa-comments"></i>Échanges</span><span class="status-badge <?= $demande['statut'] ?>"><?= EspaceManager::STATUTS_DEMANDE[$demande['statut']] ?? "" ?></span></h2>
          <div class="chat mb-4">
            <?php foreach($messages as $message) : ?>
              <div class="msg <?= $message['de_agence'] ? 'agence' : 'client' ?>">
                <div class="meta"><strong><?= $message['auteur'] ?></strong><span class="who"><?= $message['de_agence'] ? "Agence" : ($demande['login'] ? "Client" : "Visiteur") ?></span><span><?= Toolbox::dateFr($message['created_at']) ?></span></div>
                <p><?= $message['message'] ?></p>
              </div>
            <?php endforeach; ?>
          </div>
          <form method="post" action="<?= URL ?>administration/validation_reponse" class="needs-validation" novalidate>
            <?= Securite::csrfField() ?>
            <input type="hidden" name="demande_id" value="<?= $demande['id'] ?>">
            <label for="message" class="form-label">Répondre <span class="text-muted-wc fw-normal">(envoyé par mail à <?= $demande['mail'] ?><?= $demande['login'] ? " et visible dans son espace" : "" ?>)</span></label>
            <textarea class="form-control mb-3" id="message" name="message" rows="5" required maxlength="5000" placeholder="Bonjour, …"></textarea>
            <div class="invalid-feedback">Écrivez votre réponse.</div>
            <button type="submit" class="btn btn-gold"><i class="fas fa-paper-plane me-2"></i>Envoyer la réponse</button>
          </form>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="dash-card mb-4">
          <h2><span><i class="fas fa-circle-info"></i>Demande n°<?= $demande['id'] ?></span></h2>
          <p class="mb-1"><strong><?= $demande['nom'] ?></strong> <?= $demande['login'] ? '<span class="role-badge">client '.$demande['login'].'</span>' : '<span class="status-badge">visiteur</span>' ?></p>
          <p class="mb-1"><a href="mailto:<?= $demande['mail'] ?>" class="text-white"><i class="fas fa-envelope me-2 text-warning"></i><?= $demande['mail'] ?></a></p>
          <p class="text-muted-wc small mb-0">Reçue le <?= Toolbox::dateFr($demande['created_at']) ?></p>
          <?php if($demande['login']) : ?>
            <a href="<?= URL ?>administration/nouveauProjet?client=<?= rawurlencode($demande['login']) ?>" class="btn btn-outline-navy btn-sm mt-3"><i class="fas fa-plus me-1"></i>Créer un projet pour ce client</a>
          <?php endif; ?>
        </div>
        <div class="dash-card">
          <h2><span><i class="fas fa-tag"></i>Statut</span></h2>
          <form method="post" action="<?= URL ?>administration/validation_statutDemande">
            <?= Securite::csrfField() ?>
            <input type="hidden" name="demande_id" value="<?= $demande['id'] ?>">
            <select class="form-select mb-2" name="statut" aria-label="Statut de la demande">
              <?php foreach(EspaceManager::STATUTS_DEMANDE as $cle => $libelle) : ?>
                <option value="<?= $cle ?>"<?= $demande['statut'] === $cle ? " selected" : "" ?>><?= $libelle ?></option>
              <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-light w-100">Mettre à jour</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
