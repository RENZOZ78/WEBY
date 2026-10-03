<div class="dash-card">
  <h2><span><i class="fas <?= $iconeWidget ?>"></i><?= $titreWidget ?></span><a href="<?= URL ?>administration/demandes">Gérer</a></h2>
  <div class="sv-kv">
    <div><span><?= sv_nombre($demandes['periode']) ?></span>reçues sur <?= SupervisionController::PERIODES[$periode] ?></div>
    <div><span><?= sv_nombre($demandes['contact']) ?></span>formulaire de contact</div>
    <div><span><?= sv_nombre($demandes['clients']) ?></span>espace client</div>
    <div><span><?= sv_delai($demandes['delai_minutes']) ?></span>délai moyen de 1re réponse</div>
  </div>
  <h3 class="sv-subtitle">Toutes les demandes, par statut</h3>
  <?= sv_classement(array_map(function($statut) use ($demandes){ return [EspaceManager::STATUTS_DEMANDE[$statut], (int)($demandes['statuts'][$statut] ?? 0)]; }, array_keys(EspaceManager::STATUTS_DEMANDE)), "Aucune demande.") ?>
</div>
