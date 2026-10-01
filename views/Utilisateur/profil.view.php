<section class="section">
  <div class="container">
    <div class="row g-4">

      <!-- Carte d'identite + photo -->
      <div class="col-lg-4">
        <div class="form-card profile-card h-100">
          <img class="avatar mb-3" src="<?= URL ?>public/Assets/images/<?= $utilisateur['image'] ?>" alt="Photo de profil" width="120" height="120">
          <h2 class="h4 mb-1"><?= $utilisateur['login'] ?></h2>
          <p class="text-muted-wc mb-2"><?= $utilisateur['mail'] ?></p>
          <span class="role-badge <?= $utilisateur['role'] ?>"><?= $utilisateur['role'] ?></span>

          <form class="mt-4" action="<?= URL ?>compte/validation_modificationImage" enctype="multipart/form-data" method="post">
            <?= Securite::csrfField() ?>
            <label for="image" class="btn btn-outline-navy btn-sm"><i class="fas fa-camera me-2"></i>Changer la photo</label>
            <input type="file" name="image" class="d-none" id="image" accept="image/png, image/jpeg, image/gif, image/webp">
            <div class="form-text">JPG, PNG, GIF ou WEBP — 500 Ko maximum</div>
          </form>
        </div>
      </div>

      <div class="col-lg-8">
        <!-- Modification du mail -->
        <div class="form-card mb-4">
          <h2 class="h5 mb-3"><i class="far fa-envelope me-2 text-warning"></i>Adresse email</h2>
          <div id="affichageMail" class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <span class="fw-semibold"><?= $utilisateur['mail'] ?></span>
            <button class="btn btn-outline-navy btn-sm" id="btnModifMail" type="button"><i class="fas fa-pen me-2"></i>Modifier</button>
          </div>
          <form class="d-none needs-validation" id="modificationMail" method="post" action="<?= URL ?>compte/validation_modificationMail" novalidate>
            <?= Securite::csrfField() ?>
            <label for="nouveauMail" class="form-label">Nouvelle adresse email</label>
            <div class="input-group has-validation">
              <input type="email" class="form-control" id="nouveauMail" name="mail" value="<?= $utilisateur['mail'] ?>" required>
              <button type="submit" class="btn btn-primary"><i class="fas fa-check me-1"></i>Valider</button>
              <button type="button" class="btn btn-light border" id="btnAnnulerMail">Annuler</button>
              <div class="invalid-feedback">Entrez une adresse email valide.</div>
            </div>
          </form>
        </div>

        <!-- Mot de passe -->
        <div class="form-card mb-4">
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
              <h2 class="h5 mb-1"><i class="fas fa-key me-2 text-warning"></i>Mot de passe</h2>
              <p class="text-muted-wc mb-0">Changez régulièrement votre mot de passe.</p>
            </div>
            <a href="<?= URL ?>compte/modificationPassword" class="btn btn-outline-navy btn-sm">Changer le mot de passe</a>
          </div>
        </div>

        <!-- Suppression du compte -->
        <div class="form-card danger-zone">
          <h2 class="h5 mb-1 text-danger"><i class="fas fa-triangle-exclamation me-2"></i>Supprimer mon compte</h2>
          <p class="text-muted-wc">Cette action est définitive : votre compte et votre photo seront supprimés.</p>
          <button id="btnSupCompte" class="btn btn-outline-danger btn-sm" type="button">Supprimer mon compte</button>
          <form id="suppressionCompte" class="d-none mt-3" method="post" action="<?= URL ?>compte/suppressionCompte">
            <?= Securite::csrfField() ?>
            <div class="alert alert-danger mb-0 d-flex flex-wrap align-items-center justify-content-between gap-3">
              <span>Confirmez-vous la suppression définitive de votre compte ?</span>
              <button type="submit" class="btn btn-danger btn-sm">Oui, supprimer définitivement</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>
