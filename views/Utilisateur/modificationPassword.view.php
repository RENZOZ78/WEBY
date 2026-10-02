<section class="section">
  <div class="container">
    <?php include "inc/partials/espace_nav.php"; ?>
    <div class="auth-wrap ms-0">
      <form method="post" action="<?= URL ?>compte/validation_modificationPassword" class="form-card needs-validation" novalidate>
        <?= Securite::csrfField() ?>
        <div class="mb-3">
          <label for="ancienPassword" class="form-label">Mot de passe actuel</label>
          <input type="password" id="ancienPassword" name="ancienPassword" class="form-control" autocomplete="current-password" required>
          <div class="invalid-feedback">Tapez votre mot de passe actuel.</div>
        </div>

        <div class="mb-3">
          <label for="nouveauPassword" class="form-label">Nouveau mot de passe</label>
          <input type="password" id="nouveauPassword" name="nouveauPassword" class="form-control" autocomplete="new-password" minlength="8" required aria-describedby="aideNouveau">
          <div id="aideNouveau" class="form-text">8 caractères minimum.</div>
        </div>

        <div class="mb-3">
          <label for="confirmNouveauPassword" class="form-label">Confirmation du nouveau mot de passe</label>
          <input type="password" id="confirmNouveauPassword" name="confirmNouveauPassword" class="form-control" autocomplete="new-password" minlength="8" required>
        </div>

        <div class="alert alert-danger d-none py-2" id="erreur">Les mots de passe ne correspondent pas.</div>

        <div class="d-flex gap-2">
          <a href="<?= URL ?>compte/profil" class="btn btn-light border">Annuler</a>
          <button class="btn btn-gold flex-grow-1" id="btnValidation" type="submit" disabled>Valider</button>
        </div>
      </form>
    </div>
  </div>
</section>
