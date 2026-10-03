<div class="dash-card">
  <h2><span><i class="fas <?= $iconeWidget ?>"></i><?= $titreWidget ?></span><a href="<?= URL ?>administration/projets">Gérer</a></h2>
  <?php if($projets['total'] === 0) : ?>
    <p class="text-muted-wc mb-0">Aucun projet pour le moment.</p>
  <?php else : ?>
    <h3 class="sv-subtitle mt-0">Avancement (<?= $projets['total'] ?> projets)</h3>
    <?= sv_classement(array_map(function($etape, $nom) use ($projets){ return [$nom, (int)($projets['etapes'][$etape] ?? 0)]; }, array_keys(EspaceManager::ETAPES), EspaceManager::ETAPES)) ?>
    <h3 class="sv-subtitle">Par prestation</h3>
    <?= sv_classement(array_map(function($type, $nb){ return [EspaceManager::TYPES[$type] ?? $type, (int)$nb]; }, array_keys($projets['types']), $projets['types'])) ?>
  <?php endif; ?>
</div>
