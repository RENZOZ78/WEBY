<section class="section">
  <div class="container">
    <?php include "inc/partials/supervision_nav.php"; ?>

    <div class="sv-toolbar">
      <?= sv_periodes($periode) ?>
      <a href="<?= URL ?>supervision/personnaliser" class="btn btn-ghost btn-sm"><i class="fas fa-sliders me-1"></i>Personnaliser ce tableau</a>
    </div>

    <?php if(empty($prefs['widgets'])) : ?>
      <div class="dash-card text-center">
        <p class="mb-3">Aucun bloc n'est affiché sur votre tableau de bord.</p>
        <a href="<?= URL ?>supervision/personnaliser" class="btn btn-gold btn-sm">Choisir les blocs à afficher</a>
      </div>
    <?php else : ?>
      <div class="row g-4">
        <?php foreach($prefs['widgets'] as $widget) : ?>
          <?php [$titreWidget, $iconeWidget] = SupervisionController::WIDGETS[$widget['id']]; ?>
          <div class="<?= $widget['largeur'] === "pleine" ? "col-12" : "col-lg-6" ?>">
            <?php include __DIR__."/widgets/".$widget['id'].".php"; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
