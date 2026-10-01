<section class="section">
  <div class="container">
    <?php include "inc/partials/admin_nav.php"; ?>
    <div class="table-card">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr><th>Utilisateur</th><th>Email</th><th>Compte</th><th>Rôle</th></tr>
          </thead>
          <tbody>
            <?php foreach ($utilisateurs as $utilisateur) : ?>
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img src="<?= URL ?>public/Assets/images/<?= $utilisateur['image'] ?>" alt="" width="36" height="36" class="rounded-circle" style="object-fit:cover">
                    <span class="fw-semibold"><?= $utilisateur['login'] ?></span>
                  </div>
                </td>
                <td><?= $utilisateur['mail'] ?></td>
                <td>
                  <?php if((int)$utilisateur['is_valid'] === 1) : ?>
                    <span class="status-badge ok"><i class="fas fa-check"></i>Validé</span>
                  <?php else : ?>
                    <span class="status-badge ko"><i class="fas fa-clock"></i>Non validé</span>
                  <?php endif; ?>
                </td>
                <td><span class="role-badge <?= $utilisateur['role'] ?>"><?= $utilisateur['role'] ?></span></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
