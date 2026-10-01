<section class="section">
  <div class="container">
    <?php include "inc/partials/admin_nav.php"; ?>
    <div class="table-card">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr><th>Login</th><th>Email</th><th>Rôle</th><th>Compte</th><th class="text-end">Action</th></tr>
          </thead>
          <tbody>
            <?php foreach ($utilisateurs as $i => $utilisateur) : ?>
              <?php $formId = "form-utilisateur-".$i; ?>
              <tr>
                <td class="fw-semibold">
                  <?= $utilisateur['login'] ?>
                  <form id="<?= $formId ?>" method="POST" action="<?= URL ?>administration/validationModificationFullUtilisateur"
                        data-confirm="Enregistrer les modifications de <?= $utilisateur['login'] ?> ?">
                    <?= Securite::csrfField() ?>
                    <input type="hidden" name="login" value="<?= $utilisateur['login'] ?>">
                  </form>
                </td>
                <td><input form="<?= $formId ?>" type="email" class="form-control" name="mail" value="<?= $utilisateur['mail'] ?>" required aria-label="Email de <?= $utilisateur['login'] ?>"></td>
                <td>
                  <select form="<?= $formId ?>" class="form-select" name="role" aria-label="Rôle de <?= $utilisateur['login'] ?>">
                    <option value="utilisateur"<?= $utilisateur['role'] === "utilisateur" ? " selected" : "" ?>>Utilisateur</option>
                    <option value="administrateur"<?= $utilisateur['role'] === "administrateur" ? " selected" : "" ?>>Administrateur</option>
                    <option value="superAdministrateur"<?= $utilisateur['role'] === "superAdministrateur" ? " selected" : "" ?>>Super administrateur</option>
                  </select>
                </td>
                <td>
                  <select form="<?= $formId ?>" class="form-select" name="is_valid" aria-label="Validation du compte de <?= $utilisateur['login'] ?>">
                    <option value="1"<?= (int)$utilisateur['is_valid'] === 1 ? " selected" : "" ?>>Validé</option>
                    <option value="0"<?= (int)$utilisateur['is_valid'] === 0 ? " selected" : "" ?>>Non validé</option>
                  </select>
                </td>
                <td class="text-end">
                  <button form="<?= $formId ?>" type="submit" class="btn btn-primary btn-sm"><i class="fas fa-floppy-disk me-1"></i>Enregistrer</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
