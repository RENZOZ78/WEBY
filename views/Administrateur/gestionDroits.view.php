<section class="section">
  <div class="container">
    <?php include "inc/partials/admin_nav.php"; ?>
    <div class="table-card">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr><th>Login</th><th>Compte</th><th>Rôle</th></tr>
          </thead>
          <tbody>
            <?php foreach ($utilisateurs as $utilisateur) : ?>
              <?php $modifiable = $utilisateur['login'] !== $_SESSION['profil']['login']
                    && (Securite::estSuperAdministrateur() || $utilisateur['role'] === "utilisateur"); ?>
              <tr>
                <td class="fw-semibold"><?= $utilisateur['login'] ?></td>
                <td>
                  <?php if((int)$utilisateur['is_valid'] === 1) : ?>
                    <span class="status-badge ok"><i class="fas fa-check"></i>Validé</span>
                  <?php else : ?>
                    <span class="status-badge ko"><i class="fas fa-clock"></i>Non validé</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if(!$modifiable) : ?>
                    <span class="role-badge <?= $utilisateur['role'] ?>"><?= $utilisateur['role'] ?></span>
                  <?php else : ?>
                    <form method="POST" action="<?= URL ?>administration/validation_modificationRole">
                      <?= Securite::csrfField() ?>
                      <input type="hidden" name="login" value="<?= $utilisateur['login'] ?>">
                      <select class="form-select" name="role" aria-label="Rôle de <?= $utilisateur['login'] ?>"
                              data-confirm="Confirmez-vous la modification du rôle de <?= $utilisateur['login'] ?> ?" data-initial="<?= $utilisateur['role'] ?>">
                        <option value="utilisateur"<?= $utilisateur['role'] === "utilisateur" ? " selected" : "" ?>>Utilisateur</option>
                        <option value="administrateur"<?= $utilisateur['role'] === "administrateur" ? " selected" : "" ?>>Administrateur</option>
                        <?php if(Securite::estSuperAdministrateur()) : ?>
                          <option value="superAdministrateur"<?= $utilisateur['role'] === "superAdministrateur" ? " selected" : "" ?>>Super administrateur</option>
                        <?php endif; ?>
                      </select>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
