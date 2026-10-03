<?php
  $a = $audience['actuelle']; $p = $audience['precedente'];
  $tuiles = [
    ["icon" => "fa-eye", "classe" => "cyan", "val" => sv_nombre($a['visiteurs']), "lbl" => "visiteurs", "evo" => sv_evolution($a['visiteurs'], $p['visiteurs']), "lien" => "supervision/audience"],
    ["icon" => "fa-file-lines", "classe" => "", "val" => sv_nombre($a['vues']), "lbl" => "pages vues", "evo" => sv_evolution($a['vues'], $p['vues']), "lien" => "supervision/audience"],
    ["icon" => "fa-inbox", "classe" => "pink", "val" => sv_nombre($demandes['periode']), "lbl" => "demandes reçues", "evo" => "", "lien" => "administration/demandes"],
    ["icon" => "fa-user-plus", "classe" => "green", "val" => sv_nombre($comptes['inscriptions']), "lbl" => "comptes créés", "evo" => "", "lien" => "supervision/comptes"],
    ["icon" => "fa-percent", "classe" => "", "val" => $conversion['taux'] === null ? "—" : str_replace(".", ",", (string)$conversion['taux'])." %", "lbl" => "taux de contact", "evo" => "", "lien" => "supervision/audience"],
    ["icon" => "fa-diagram-project", "classe" => "cyan", "val" => sv_nombre($projets['total'] - (int)($projets['etapes'][4] ?? 0)), "lbl" => "projets en cours", "evo" => "", "lien" => "administration/projets"],
  ];
?>
<div class="sv-widget">
  <h2 class="sv-widget-title"><span><i class="fas <?= $iconeWidget ?>"></i><?= $titreWidget ?></span><small><?= SupervisionController::PERIODES[$periode] ?></small></h2>
  <div class="row g-3">
    <?php foreach($tuiles as $t) : ?>
      <div class="col-6 col-md-4 col-xl-2">
        <a href="<?= URL.$t['lien'] ?>" class="stat-mini sv-stat">
          <span class="icon <?= $t['classe'] ?>"><i class="fas <?= $t['icon'] ?>"></i></span>
          <div><div class="val"><?= $t['val'] ?></div><div class="lbl"><?= $t['lbl'] ?></div><?= $t['evo'] ?></div>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</div>
