<?php $a = $audience['actuelle']; ?>
<div class="dash-card">
  <h2><span><i class="fas <?= $iconeWidget ?>"></i>Visiteurs <?= $periode > 90 ? "par mois" : "par jour" ?></span><a href="<?= URL ?>supervision/audience?periode=<?= $periode ?>">Détail de l'audience</a></h2>
  <p class="sv-resume"><strong><?= sv_nombre($a['visiteurs']) ?></strong> visiteurs · <strong><?= sv_nombre($a['vues']) ?></strong> pages vues
    <?php if($a['vues'] > 0) : ?> · <strong><?= round($a['mobiles'] * 100 / $a['vues']) ?> %</strong> sur mobile<?php endif; ?>
    · <strong><?= sv_nombre($robots['visiteurs']) ?></strong> robots et spams écartés</p>
  <?php if($a['vues'] === 0) : ?>
    <p class="text-muted-wc mb-0">Aucune visite enregistrée sur cette période. Seuls les vrais navigateurs sont comptés : les robots et les administrateurs ne le sont pas.</p>
  <?php else : ?>
    <?= sv_histogramme($serie, "visiteurs", function($p){ return $p['libelle']." : ".$p['visiteurs']." visiteur(s), ".$p['vues']." page(s) vue(s)"; }, "Visiteurs ".($periode > 90 ? "par mois" : "par jour")) ?>
  <?php endif; ?>
  <?php if($debut_mesure !== null) : ?>
    <p class="sv-note">Mesure par le navigateur depuis le <?= date("d/m/Y", strtotime($debut_mesure)) ?> : les robots ne sont plus comptés.</p>
  <?php endif; ?>
</div>
