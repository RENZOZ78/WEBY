<section class="section">
  <div class="container">
    <?php include "inc/partials/admin_nav.php"; ?>
    <div class="table-card">
      <?php if(empty($projets)) : ?>
        <div class="empty-state"><i class="fas fa-diagram-project"></i>Aucun projet.<br><a href="<?= URL ?>administration/nouveauProjet" class="btn btn-gold btn-sm mt-3"><i class="fas fa-plus me-1"></i>Créer un projet</a></div>
      <?php else : ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead><tr><th>Projet</th><th>Client</th><th>Type</th><th>Étape</th><th>Mis à jour</th><th></th></tr></thead>
            <tbody>
              <?php foreach($projets as $projet) : ?>
                <tr>
                  <td><a href="<?= URL ?>administration/projet/<?= $projet['id'] ?>"><?= $projet['titre'] ?></a></td>
                  <td><?= $projet['login'] ?><br><small class="text-muted-wc"><?= $projet['mail'] ?></small></td>
                  <td><?= EspaceManager::TYPES[$projet['type']] ?? "" ?></td>
                  <td><span class="badge-etape e<?= (int)$projet['etape'] ?>"><?= EspaceManager::ETAPES[(int)$projet['etape']] ?? "" ?></span></td>
                  <td class="text-muted-wc"><?= Toolbox::dateFr($projet['updated_at']) ?></td>
                  <td class="text-end"><a href="<?= URL ?>administration/projet/<?= $projet['id'] ?>" class="btn btn-light btn-sm">Gérer</a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
