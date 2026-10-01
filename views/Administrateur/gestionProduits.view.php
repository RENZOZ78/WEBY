<section class="section">
  <div class="container">
    <?php include "inc/partials/admin_nav.php"; ?>
    <div class="table-card">
      <?php if(empty($produits)) : ?>
        <div class="empty-state"><i class="fas fa-box"></i>Aucun produit enregistré.</div>
      <?php else : ?>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr><th>#</th><th>Désignation</th><th class="text-end">Prix</th></tr>
            </thead>
            <tbody>
              <?php foreach ($produits as $produit) : ?>
                <tr>
                  <td class="text-muted-wc"><?= htmlspecialchars((string)$produit['id']) ?></td>
                  <td class="fw-semibold"><?= htmlspecialchars((string)$produit['designation']) ?></td>
                  <td class="text-end"><?= htmlspecialchars((string)$produit['prix']) ?> €</td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
