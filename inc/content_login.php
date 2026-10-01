<!-- FORMULAIRE DE CONNEXION -->
<section class="section">
  <div class="container" style="max-width: 980px;">
    <div class="auth-split" data-aos="fade-up">
      <div class="auth-photo">
        <img src="<?= URL ?>img/pc_cafe.jpg" alt="">
        <div class="caption">
          <h2>Votre espace client</h2>
          <ul>
            <li><i class="fas fa-circle-check"></i>Suivez l'avancement de vos projets</li>
            <li><i class="fas fa-circle-check"></i>Téléchargez devis, factures et documents</li>
            <li><i class="fas fa-circle-check"></i>Échangez avec l'agence</li>
          </ul>
        </div>
      </div>
      <form method="post" action="<?= URL ?>validation_login" class="form-card needs-validation" novalidate>
        <?= Securite::csrfField() ?>
        <h2 class="h4 mb-1">Bon retour parmi nous</h2>
        <p class="text-muted-wc mb-4">Connectez-vous pour accéder à votre espace.</p>

        <div class="mb-3">
          <label for="login" class="form-label">Login</label>
          <div class="input-group has-validation">
            <span class="input-group-text"><i class="far fa-user"></i></span>
            <input type="text" class="form-control" id="login" name="login" autocomplete="username" required>
            <div class="invalid-feedback">Entrez votre login.</div>
          </div>
        </div>

        <div class="mb-4">
          <label for="password" class="form-label">Mot de passe</label>
          <div class="input-group has-validation">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>
            <div class="invalid-feedback">Entrez votre mot de passe.</div>
          </div>
        </div>

        <button class="btn btn-gold w-100 btn-lg" type="submit">Se connecter</button>
        <p class="auth-switch mb-0">Pas encore de compte ? <a href="<?= URL ?>creerCompte" class="fw-semibold">Créer un compte</a></p>
      </form>
    </div>
  </div>
</section>
