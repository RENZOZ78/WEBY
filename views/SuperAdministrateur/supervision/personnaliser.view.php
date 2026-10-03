<?php
  //widgets affiches d'abord (dans l'ordre choisi), puis les masques
  $affiches = array_column($prefs['widgets'], "largeur", "id");
  $ordre = array_merge(array_keys($affiches), array_diff(array_keys(SupervisionController::WIDGETS), array_keys($affiches)));
  $nb = count($ordre);
?>
<section class="section">
  <div class="container">
    <?php include "inc/partials/supervision_nav.php"; ?>

    <form method="POST" action="<?= URL ?>supervision/validation_personnaliser">
      <?= Securite::csrfField() ?>
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="dash-card">
            <h2><span><i class="fas fa-table-cells-large"></i>Blocs du tableau de bord</span></h2>
            <p class="text-muted-wc">Cochez les blocs à afficher, choisissez leur position (1 = en haut) et leur largeur.</p>
            <div class="sv-widgets-list">
              <?php foreach($ordre as $i => $id) : ?>
                <?php [$titre, $icone, $largeurDefaut] = SupervisionController::WIDGETS[$id]; $visible = isset($affiches[$id]); $largeur = $affiches[$id] ?? $largeurDefaut; ?>
                <div class="sv-widget-row">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="w-<?= $id ?>" name="afficher[<?= $id ?>]" value="1"<?= $visible ? " checked" : "" ?>>
                    <label class="form-check-label" for="w-<?= $id ?>"><i class="fas <?= $icone ?>"></i><?= $titre ?></label>
                  </div>
                  <div class="sv-widget-opts">
                    <label class="visually-hidden" for="p-<?= $id ?>">Position de « <?= $titre ?> »</label>
                    <select id="p-<?= $id ?>" name="position[<?= $id ?>]" class="form-select form-select-sm">
                      <?php for($n = 1; $n <= $nb; $n++) : ?><option value="<?= $n ?>"<?= $n === $i + 1 ? " selected" : "" ?>>Position <?= $n ?></option><?php endfor; ?>
                    </select>
                    <label class="visually-hidden" for="l-<?= $id ?>">Largeur de « <?= $titre ?> »</label>
                    <select id="l-<?= $id ?>" name="largeur[<?= $id ?>]" class="form-select form-select-sm">
                      <option value="demi"<?= $largeur === "demi" ? " selected" : "" ?>>Demi-largeur</option>
                      <option value="pleine"<?= $largeur === "pleine" ? " selected" : "" ?>>Pleine largeur</option>
                    </select>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="dash-card h-auto">
            <h2><span><i class="fas fa-user-lock"></i>Mon accès</span></h2>
            <label for="accueil" class="form-label">Après ma connexion, ouvrir</label>
            <select id="accueil" name="accueil" class="form-select mb-3">
              <?php foreach(SupervisionController::ACCUEILS as $cle => $nom) : ?>
                <option value="<?= $cle ?>"<?= $prefs['accueil'] === $cle ? " selected" : "" ?>><?= $nom ?></option>
              <?php endforeach; ?>
            </select>
            <label for="periode" class="form-label">Période affichée par défaut</label>
            <select id="periode" name="periode" class="form-select mb-4">
              <?php foreach(SupervisionController::PERIODES as $jours => $nom) : ?>
                <option value="<?= $jours ?>"<?= $prefs['periode'] === $jours ? " selected" : "" ?>><?= $nom ?></option>
              <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-gold w-100 mb-2"><i class="fas fa-floppy-disk me-1"></i>Enregistrer</button>
            <button type="submit" form="form-reinitialiser" class="btn btn-ghost w-100"><i class="fas fa-rotate-left me-1"></i>Présentation d'origine</button>
          </div>
          <p class="sv-note mt-3"><i class="fas fa-lock me-1"></i>La supervision n'est accessible qu'aux comptes super administrateur. Le rôle est revérifié en base à chaque page.</p>
        </div>
      </div>
    </form>
    <form id="form-reinitialiser" method="POST" action="<?= URL ?>supervision/validation_personnaliser" data-confirm="Revenir à la présentation d'origine du tableau de bord ?">
      <?= Securite::csrfField() ?>
      <input type="hidden" name="reinitialiser" value="1">
    </form>
  </div>
</section>
