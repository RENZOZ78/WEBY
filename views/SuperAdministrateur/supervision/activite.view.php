<section class="section">
  <div class="container">
    <?php include "inc/partials/supervision_nav.php"; ?>

    <form class="sv-filtres" method="GET" action="<?= URL ?>supervision/activite">
      <div>
        <label for="f-categorie" class="form-label">Catégorie</label>
        <select id="f-categorie" name="categorie" class="form-select">
          <option value="">Toutes</option>
          <?php foreach(Journal::CATEGORIES as $cle => $nom) : ?>
            <option value="<?= $cle ?>"<?= $categorie === $cle ? " selected" : "" ?>><?= $nom ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label for="f-login" class="form-label">Compte</label>
        <input id="f-login" type="text" name="login" class="form-control" value="<?= sv_txt($login_filtre) ?>" placeholder="login">
      </div>
      <div>
        <label for="f-periode" class="form-label">Période</label>
        <select id="f-periode" name="periode" class="form-select">
          <?php foreach(SupervisionController::PERIODES as $jours => $nom) : ?>
            <option value="<?= $jours ?>"<?= $periode === $jours ? " selected" : "" ?>><?= $nom ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-gold"><i class="fas fa-filter me-1"></i>Filtrer</button>
        <?php if($categorie !== "" || $login_filtre !== "") : ?><a href="<?= URL ?>supervision/activite" class="btn btn-ghost">Effacer</a><?php endif; ?>
      </div>
    </form>

    <?php if(!empty($echecs)) : ?>
      <div class="dash-card mb-4">
        <h2><span><i class="fas fa-user-secret"></i>Échecs de connexion sur 7 jours, par adresse</span></h2>
        <div class="table-responsive"><table class="table table-sm align-middle mb-0 sv-table">
          <thead><tr><th>Adresse (tronquée)</th><th>Logins essayés</th><th class="text-end">Échecs</th><th class="text-end">Dernier</th></tr></thead>
          <tbody>
            <?php foreach($echecs as $e) : ?>
              <tr class="<?= $e['nb'] >= 5 ? "sv-danger" : "" ?>"><td><?= sv_txt($e['ip'] ?: "inconnue") ?></td><td><?= sv_txt($e['logins']) ?></td><td class="text-end fw-semibold"><?= (int)$e['nb'] ?></td><td class="text-end"><?= sv_depuis($e['dernier']) ?></td></tr>
            <?php endforeach; ?>
          </tbody>
        </table></div>
      </div>
    <?php endif; ?>

    <div class="table-card">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead><tr><th>Date</th><th>Événement</th><th>Compte</th><th>Détail</th></tr></thead>
          <tbody>
            <?php if(empty($evenements)) : ?>
              <tr><td colspan="4" class="text-muted-wc">Aucun événement pour ces critères.</td></tr>
            <?php endif; ?>
            <?php foreach($evenements as $ev) : ?>
              <tr>
                <td class="text-nowrap"><?= Toolbox::dateFr($ev['created_at']) ?></td>
                <td class="text-nowrap"><span class="sv-ev sv-cat-<?= Journal::categorie($ev['type']) ?>"><i class="fas <?= Journal::icone($ev['type']) ?>"></i></span><?= Journal::libelle($ev['type']) ?></td>
                <td><?php if($ev['login'] !== null) : ?><a href="<?= URL ?>supervision/activite?login=<?= rawurlencode(html_entity_decode($ev['login'])) ?>&periode=<?= $periode ?>"><?= sv_txt($ev['login']) ?></a><?php else : ?><span class="text-muted-wc">visiteur</span><?php endif; ?></td>
                <td class="sv-detail"><?= sv_txt($ev['detail']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="sv-pagination">
      <span class="text-muted-wc"><?= sv_nombre($total) ?> événement(s)</span>
      <?php if($pages_total > 1) : ?>
        <?php $base = ["categorie" => $categorie, "login" => $login_filtre, "periode" => $periode]; ?>
        <nav aria-label="Pages du journal" class="d-flex gap-2 align-items-center">
          <?php if($page > 1) : ?><a class="btn btn-ghost btn-sm" href="?<?= sv_txt(http_build_query($base + ["p" => $page - 1])) ?>"><i class="fas fa-chevron-left"></i><span class="visually-hidden">Page précédente</span></a><?php endif; ?>
          <span>Page <?= $page ?> / <?= $pages_total ?></span>
          <?php if($page < $pages_total) : ?><a class="btn btn-ghost btn-sm" href="?<?= sv_txt(http_build_query($base + ["p" => $page + 1])) ?>"><i class="fas fa-chevron-right"></i><span class="visually-hidden">Page suivante</span></a><?php endif; ?>
        </nav>
      <?php endif; ?>
    </div>
  </div>
</section>
