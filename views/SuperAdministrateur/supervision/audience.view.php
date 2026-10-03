<?php $a = $audience['actuelle']; $p = $audience['precedente']; $nomsAppareils = ["mobile" => "Mobile", "ordinateur" => "Ordinateur", "tablette" => "Tablette"]; ?>
<section class="section">
  <div class="container">
    <?php include "inc/partials/supervision_nav.php"; ?>
    <div class="sv-toolbar"><?= sv_periodes($periode) ?></div>

    <div class="row g-3 mb-4">
      <div class="col-6 col-lg-3"><div class="stat-mini sv-stat"><span class="icon cyan"><i class="fas fa-eye"></i></span><div><div class="val"><?= sv_nombre($a['visiteurs']) ?></div><div class="lbl">visiteurs</div><?= sv_evolution($a['visiteurs'], $p['visiteurs']) ?></div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-mini sv-stat"><span class="icon"><i class="fas fa-file-lines"></i></span><div><div class="val"><?= sv_nombre($a['vues']) ?></div><div class="lbl">pages vues</div><?= sv_evolution($a['vues'], $p['vues']) ?></div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-mini sv-stat"><span class="icon green"><i class="fas fa-layer-group"></i></span><div><div class="val"><?= $a['visiteurs'] > 0 ? str_replace(".", ",", (string)round($a['vues'] / $a['visiteurs'], 1)) : "—" ?></div><div class="lbl">pages par visiteur</div></div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-mini sv-stat"><span class="icon pink"><i class="fas fa-percent"></i></span><div><div class="val"><?= $conversion['taux'] === null ? "—" : str_replace(".", ",", (string)$conversion['taux'])." %" ?></div><div class="lbl">taux de contact</div><small class="sv-evo"><?= $conversion['demandes'] ?> message(s), <?= $conversion['inscriptions'] ?> compte(s)</small></div></div></div>
    </div>

    <div class="row g-4">
      <div class="col-12">
        <div class="dash-card">
          <h2><span><i class="fas fa-chart-column"></i>Visiteurs <?= $periode > 90 ? "par mois" : "par jour" ?></span></h2>
          <?php if($a['vues'] === 0) : ?>
            <p class="text-muted-wc mb-0">Aucune visite enregistrée sur cette période. La mesure démarre à la mise en ligne de la supervision.</p>
          <?php else : ?>
            <?= sv_histogramme($serie, "visiteurs", function($pt){ return $pt['libelle']." : ".$pt['visiteurs']." visiteur(s), ".$pt['vues']." page(s) vue(s)"; }, "Visiteurs ".($periode > 90 ? "par mois" : "par jour")) ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="dash-card">
          <h2><span><i class="fas fa-file-lines"></i>Pages vues</span></h2>
          <?= sv_classement(array_map(function($l){ return [Audience::nomPage($l['cle']), (int)$l['vues'], $l['visiteurs']." vis."]; }, $pages)) ?>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="dash-card">
          <h2><span><i class="fas fa-signs-post"></i>Provenance</span></h2>
          <?= sv_classement(array_map(function($l){ return [$l['cle'] === "direct" ? "Accès direct" : $l['cle'], (int)$l['visiteurs'], $l['vues']." pages"]; }, $sources)) ?>
          <p class="sv-note">Pour suivre une campagne, ajoutez <code>?utm_source=</code> suivi du nom de la source à vos liens, par exemple
            <code><?= URL ?>?utm_source=leboncoin</code>.</p>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="dash-card">
          <h2><span><i class="fas fa-mobile-screen"></i>Appareils</span></h2>
          <?= sv_classement(array_map(function($l) use ($nomsAppareils){ return [$nomsAppareils[$l['cle']] ?? $l['cle'], (int)$l['visiteurs'], $l['vues']." pages"]; }, $appareils)) ?>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="dash-card">
          <h2><span><i class="fas fa-clock"></i>Heures de visite</span></h2>
          <?php if($a['vues'] === 0) : ?>
            <p class="text-muted-wc mb-0">Pas encore de données sur cette période.</p>
          <?php else : ?>
            <?= sv_histogramme($heures, "vues", function($pt){ return $pt['libelle']." : ".$pt['vues']." page(s) vue(s)"; }, "Pages vues par heure de la journée") ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <p class="sv-note mt-4"><i class="fas fa-shield-halved me-1"></i>Mesure sans cookie : aucune adresse IP n'est conservée, un visiteur est compté une fois par jour.
      Les robots, les administrateurs et les pages privées ne sont pas comptés. Données conservées <?= Audience::CONSERVATION_JOURS ?> jours.</p>
  </div>
</section>
