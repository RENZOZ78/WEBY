<section class="section">
  <div class="container">
    <?php include "inc/partials/espace_nav.php"; ?>
    <div class="row g-4">
      <div class="col-lg-8">
        <form method="post" action="<?= URL ?>compte/validation_nouvelleDemande" class="form-card needs-validation" novalidate>
          <?= Securite::csrfField() ?>
          <div class="mb-3">
            <label for="sujet" class="form-label">Sujet</label>
            <input type="text" class="form-control" id="sujet" name="sujet" required maxlength="150" value="<?= $sujet_defaut ?>" placeholder="Modification de mon site, question sur ma facture, nouveau projet…">
            <div class="invalid-feedback">Indiquez un sujet.</div>
          </div>
          <div class="mb-4">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="6" required maxlength="5000" placeholder="Décrivez votre demande le plus précisément possible."></textarea>
            <div class="invalid-feedback">Écrivez votre message.</div>
          </div>
          <div class="d-flex gap-2">
            <a href="<?= URL ?>compte/demandes" class="btn btn-light">Annuler</a>
            <button type="submit" class="btn btn-gold flex-grow-1"><i class="fas fa-paper-plane me-2"></i>Envoyer la demande</button>
          </div>
        </form>
      </div>
      <div class="col-lg-4">
        <div class="dash-card">
          <h2><span><i class="fas fa-lightbulb"></i>Exemples de demandes</span></h2>
          <ul class="check-list mt-0">
            <li><i class="fas fa-circle-check"></i><span>Modifier un texte ou une photo de mon site</span></li>
            <li><i class="fas fa-circle-check"></i><span>Demander une fiche de paie ou un contrat</span></li>
            <li><i class="fas fa-circle-check"></i><span>Lancer une campagne publicitaire</span></li>
            <li><i class="fas fa-circle-check"></i><span>Poser une question sur un devis ou une facture</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
