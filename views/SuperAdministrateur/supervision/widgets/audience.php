<?php $a = $audience['actuelle']; ?>
<div class="dash-card">
  <h2><span><i class="fas <?= $iconeWidget ?>"></i>Visiteurs <?= $periode > 90 ? "par mois" : "par jour" ?></span><a href="<?= URL ?>supervision/audience?periode=<?= $periode ?>">Détail de l'audience</a></h2>
  <p class="sv-resume"><strong><?= sv_nombre($a['visiteurs']) ?></strong> visiteurs · <strong><?= sv_nombre($a['vues']) ?></strong> pages vues
    <?php if($a['vues'] > 0) : ?> · <strong><?= round($a['mobiles'] * 100 / $a['vues']) ?> %</strong> sur mobile<?php endif; ?></p>
  <?php if($a['vues'] === 0) : ?>
    <p class="text-muted-wc mb-0">Aucune visite enregistrée sur cette période. La mesure démarre à la mise en ligne de la supervision (les robots et les administrateurs ne sont pas comptés).</p>
  <?php else : ?>
    <?= sv_histogramme($serie, "visiteurs", function($p){ return $p['libelle']." : ".$p['visiteurs']." visiteur(s), ".$p['vues']." page(s) vue(s)"; }, "Visiteurs ".($periode > 90 ? "par mois" : "par jour")) ?>
  <?php endif; ?>
</div>
