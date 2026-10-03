<div class="dash-card">
  <h2><span><i class="fas <?= $iconeWidget ?>"></i><?= $titreWidget ?></span><a href="<?= URL ?>supervision/audience?periode=<?= $periode ?>">Tout voir</a></h2>
  <?= sv_classement(array_map(function($l){ return [$l['cle'] === "direct" ? "Accès direct" : $l['cle'], (int)$l['visiteurs'], $l['vues']." pages"]; }, $sources)) ?>
  <p class="sv-note">Astuce : ajoutez <code>?utm_source=instagram</code> (ou leboncoin…) à vos liens pour les reconnaître ici.</p>
</div>
