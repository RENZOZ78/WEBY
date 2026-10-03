<div class="dash-card">
  <h2><span><i class="fas <?= $iconeWidget ?>"></i><?= $titreWidget ?></span><a href="<?= URL ?>supervision/audience?periode=<?= $periode ?>">Tout voir</a></h2>
  <?= sv_classement(array_map(function($l){ return [Audience::nomPage($l['cle']), (int)$l['vues'], $l['visiteurs']." vis."]; }, $pages)) ?>
</div>
