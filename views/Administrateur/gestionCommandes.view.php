<section class="section">
  <div class="container">
    <?php include "inc/partials/admin_nav.php"; ?>
    <div class="table-card">
      <?php if(empty($commandes)) : ?>
        <div class="empty-state"><i class="fas fa-receipt"></i>Aucune commande pour le moment.</div>
      <?php else : ?>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <?php foreach(array_keys($commandes[0]) as $colonne) : ?>
                  <th><?= htmlspecialchars(str_replace("_", " ", $colonne)) ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($commandes as $commande) : ?>
                <tr>
                  <?php foreach($commande as $valeur) : ?>
                    <td><?= htmlspecialchars((string)$valeur) ?></td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
