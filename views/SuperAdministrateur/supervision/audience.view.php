<?php $a = $audience['actuelle']; $p = $audience['precedente']; $nomsAppareils = ["mobile" => "Mobile", "ordinateur" => "Ordinateur", "tablette" => "Tablette"]; ?>
<section class="section">
  <div class="container">
    <?php include "inc/partials/supervision_nav.php"; ?>
    <div class="sv-toolbar"><?= sv_periodes($periode) ?></div>

    <div class="row g-3 mb-4">
      <div class="col-6 col-lg-3"><div class="stat-mini sv-stat"><span class="icon cyan"><i class="fas fa-eye"></i></span><div><div class="val"><?= sv_nombre($a['visiteurs']) ?></div><div class="lbl">visiteurs</div><?= sv_evolution($a['visiteurs'], $p['visiteurs']) ?></div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-mini sv-stat"><span class="icon"><i class="fas fa-file-lines"></i></span><div><div class="val"><?= sv_nombre($a['vues']) ?></div><div class="lbl">pages vues</div><?= sv_evolution($a['vues'], $p['vues']) ?></div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-mini sv-stat"><span class="icon green"><i class="fas fa-layer-group"></i></span><div><div class="val"><?= $a['visiteurs'] > 0 ? str_replace(".", ",", (string)round($a['vues'] / $a['visiteurs'], 1)) : "—" ?></div><div class="lbl">pages par visiteur</div></div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-mini sv-stat"><span class="icon pink"><i class="fas fa-percent"></i></span><div><div class="val"><?= $conversion['taux'] === null ? "—" : str_replace(".", ",", (string)$conversion['taux'])." %" ?></div><div class="lbl">taux de contact</div><small class="sv-evo"><?= $conversion['demandes'] ?> message(s), <?= $conversion['inscriptions'] ?> compte(s), <?= $conversion['clics'] ?> clic(s)</small></div></div></div>
    </div>

    <div class="row g-4">
      <div class="col-12">
        <div class="dash-card">
          <h2><span><i class="fas fa-chart-column"></i>Visiteurs <?= $periode > 90 ? "par mois" : "par jour" ?></span></h2>
          <?php if($a['vues'] === 0) : ?>
            <p class="text-muted-wc mb-0">Aucune visite enregistrée sur cette période. Seuls les vrais navigateurs sont comptés.</p>
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
      <div class="col-12">
        <div class="dash-card">
          <h2><span><i class="fas fa-phone"></i>Contacts directs</span></h2>
          <div class="row g-3">
            <?php foreach(["telephone" => ["fas fa-phone", "cyan"], "mail" => ["fas fa-envelope", ""], "whatsapp" => ["fab fa-whatsapp", "green"]] as $type => [$icone, $classe]) : $c = $clics['types'][$type]; ?>
              <div class="col-12 col-md-4"><div class="stat-mini sv-stat"><span class="icon <?= $classe ?>"><i class="<?= $icone ?>"></i></span><div><div class="val"><?= sv_nombre($c['visiteurs']) ?></div><div class="lbl"><?= $c['libelle'] ?></div><small class="sv-evo"><?= sv_nombre($c['clics']) ?> clic(s)</small></div></div></div>
            <?php endforeach; ?>
          </div>
          <p class="sv-note">Visiteurs qui ont cliqué sur le numéro de téléphone, l'adresse mail ou un lien WhatsApp du site.
            Ces contacts n'apparaissent pas dans les demandes : l'appel ou le mail part directement de leur appareil.</p>
        </div>
      </div>
      <div class="col-12">
        <div class="dash-card">
          <h2><span><i class="fas fa-robot"></i>Robots et spams écartés</span></h2>
          <p class="sv-resume"><strong><?= sv_nombre($robots['visiteurs']) ?></strong> robot(s) · <strong><?= sv_nombre($robots['pages']) ?></strong> page(s) demandée(s)
            <?php if($a['visiteurs'] + $robots['visiteurs'] > 0) : ?> · <strong><?= round($robots['visiteurs'] * 100 / ($a['visiteurs'] + $robots['visiteurs'])) ?> %</strong> des visiteurs<?php endif; ?></p>
          <?= sv_classement(array_map(function($c){ return [$c['libelle'], $c['visiteurs'], $c['pages']." pages"]; }, array_values($robots['categories']))) ?>
          <p class="sv-note">Non comptés dans les visiteurs ci-dessus. <em>Robots déclarés</em> : moteurs de recherche et outils qui se
            présentent comme tels. <em>Spam de provenance</em> : visites prétendant venir de sites de spam. <em>Robots déguisés</em> :
            se présentent comme un navigateur mais n'affichent jamais la page (estimation : une personne sans JavaScript ou qui
            repart en moins d'une seconde y est aussi comptée).</p>
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
    <p class="sv-note mt-4"><i class="fas fa-shield-halved me-1"></i>Mesure sans cookie de suivi : aucune adresse IP n'est conservée, un visiteur est compté une fois par jour.
      Une page est comptée quand le navigateur l'affiche réellement : les robots (y compris ceux qui se font passer pour un navigateur
      sans exécuter le JavaScript), les visites venues de sites de spam, les administrateurs et les pages privées ne sont pas comptés.
      <?php if($debut_mesure !== null) : ?>Mesure par le navigateur depuis le <?= date("d/m/Y", strtotime($debut_mesure)) ?> (les chiffres d'avant, qui comptaient des robots, ne sont plus affichés).<?php endif; ?>
      Données conservées <?= Audience::CONSERVATION_JOURS ?> jours.</p>
  </div>
</section>
