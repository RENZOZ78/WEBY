<div class="dash-card">
  <h2><span><i class="fas <?= $iconeWidget ?>"></i><?= $titreWidget ?></span><a href="<?= URL ?>supervision/activite">Tout le journal</a></h2>
  <?php if(empty($evenements)) : ?>
    <p class="text-muted-wc mb-0">Aucun événement enregistré pour le moment. Les connexions, demandes, projets et documents apparaîtront ici.</p>
  <?php else : ?>
    <?php foreach($evenements as $ev) : ?>
      <div class="list-item">
        <span class="icon sv-cat-<?= Journal::categorie($ev['type']) ?>"><i class="fas <?= Journal::icone($ev['type']) ?>"></i></span>
        <div class="txt">
          <strong><?= Journal::libelle($ev['type']) ?></strong>
          <small><?= $ev['login'] !== null ? sv_txt($ev['login']) : "visiteur" ?><?= $ev['detail'] !== "" ? " · ".sv_txt($ev['detail']) : "" ?></small>
        </div>
        <small class="text-muted-wc text-nowrap"><?= sv_depuis($ev['created_at']) ?></small>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
