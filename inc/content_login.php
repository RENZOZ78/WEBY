<!-- FORMULAIRE DE CONNEXION -->
<section class="section">
  <div class="container">
    <div class="auth-wrap" data-aos="fade-up">
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
      </form>
      <p class="auth-switch">Pas encore de compte ? <a href="<?= URL ?>creerCompte" class="fw-semibold">Créer un compte</a></p>
    </div>
  </div>
</section>
