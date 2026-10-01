<!-- FORMULAIRE DE CREATION DE COMPTE-->
<section class="section">
  <div class="container">
    <div class="auth-wrap" data-aos="fade-up">
      <form method="post" action="<?= URL ?>validation_creerCompte" class="form-card needs-validation" novalidate>
        <?= Securite::csrfField() ?>
        <h2 class="h4 mb-1">Créez votre compte</h2>
        <p class="text-muted-wc mb-4">Un mail de validation vous sera envoyé.</p>

        <div class="mb-3">
          <label for="login" class="form-label">Login</label>
          <div class="input-group has-validation">
            <span class="input-group-text"><i class="far fa-user"></i></span>
            <input type="text" class="form-control" id="login" name="login" autocomplete="username" required maxlength="50">
            <div class="invalid-feedback">Choisissez un login.</div>
          </div>
        </div>

        <div class="mb-3">
          <label for="mail" class="form-label">Email</label>
          <div class="input-group has-validation">
            <span class="input-group-text"><i class="far fa-envelope"></i></span>
            <input type="email" id="mail" name="mail" class="form-control" autocomplete="email" required>
            <div class="invalid-feedback">Entrez une adresse email valide.</div>
          </div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe</label>
          <div class="input-group has-validation">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" id="password" name="password" class="form-control" autocomplete="new-password" minlength="8" required aria-describedby="passwordHelp">
            <div class="invalid-feedback">8 caractères minimum.</div>
          </div>
          <div id="passwordHelp" class="form-text">8 caractères minimum. Mélangez lettres et chiffres.</div>
        </div>

        <div class="form-check mb-4">
          <input class="form-check-input" type="checkbox" id="cgu" required>
          <label class="form-check-label" for="cgu">J'accepte les conditions d'utilisation</label>
          <div class="invalid-feedback">Vous devez donner votre accord avant de valider.</div>
        </div>

        <button class="btn btn-gold w-100 btn-lg" type="submit">Créer mon compte</button>
      </form>
      <p class="auth-switch">Déjà inscrit ? <a href="<?= URL ?>login" class="fw-semibold">Se connecter</a></p>
    </div>
  </div>
</section>
