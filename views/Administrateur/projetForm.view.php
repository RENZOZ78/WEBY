<?php $edition = $projet !== null; ?>
<section class="section">
  <div class="container">
    <?php include "inc/partials/admin_nav.php"; ?>
    <div class="row g-4">
      <div class="col-lg-6">
        <form method="post" action="<?= URL ?>administration/<?= $edition ? "validation_projet" : "validation_nouveauProjet" ?>" class="form-card needs-validation" novalidate>
          <?= Securite::csrfField() ?>
          <h2 class="h5 mb-3"><i class="fas fa-diagram-project me-2 text-warning"></i><?= $edition ? "Modifier le projet" : "Nouveau projet" ?></h2>
          <?php if($edition) : ?><input type="hidden" name="projet_id" value="<?= $projet['id'] ?>"><?php endif; ?>

          <div class="mb-3">
            <label for="login" class="form-label">Client</label>
            <?php if($edition) : ?>
              <input type="text" class="form-control" value="<?= $projet['login'] ?> — <?= $projet['mail'] ?>" disabled>
              <input type="hidden" name="login" value="<?= $projet['login'] ?>">
            <?php else : ?>
              <select class="form-select" id="login" name="login" required>
                <option value="">Choisir un client…</option>
                <?php foreach($clients as $client) : ?>
                  <option value="<?= $client['login'] ?>"<?= $client['login'] === $login_defaut ? " selected" : "" ?>><?= $client['login'] ?> — <?= $client['mail'] ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Choisissez un client.</div>
              <div class="form-text">Seuls les comptes validés apparaissent. Le client doit d'abord créer son espace sur le site.</div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label for="titre" class="form-label">Titre du projet</label>
            <input type="text" class="form-control" id="titre" name="titre" required maxlength="150" value="<?= $projet['titre'] ?? "" ?>" placeholder="Site vitrine Boulangerie Martin">
            <div class="invalid-feedback">Indiquez un titre.</div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-sm-6">
              <label for="type" class="form-label">Prestation</label>
              <select class="form-select" id="type" name="type">
                <?php foreach(EspaceManager::TYPES as $cle => $libelle) : ?>
                  <option value="<?= $cle ?>"<?= ($projet['type'] ?? "") === $cle ? " selected" : "" ?>><?= $libelle ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-sm-6">
              <label for="etape" class="form-label">Étape</label>
              <select class="form-select" id="etape" name="etape">
                <?php foreach(EspaceManager::ETAPES as $num => $libelle) : ?>
                  <option value="<?= $num ?>"<?= (int)($projet['etape'] ?? 1) === $num ? " selected" : "" ?>><?= $num ?>. <?= $libelle ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="mb-4">
            <label for="note" class="form-label">Message visible par le client</label>
            <textarea class="form-control" id="note" name="note" rows="3" maxlength="2000" placeholder="Ex : Maquette envoyée, en attente de votre validation."><?= $projet['note'] ?? "" ?></textarea>
          </div>

          <button type="submit" class="btn btn-gold w-100"><i class="fas fa-floppy-disk me-2"></i><?= $edition ? "Enregistrer" : "Créer le projet" ?></button>
        </form>

        <?php if($edition) : ?>
          <form method="post" action="<?= URL ?>administration/suppression_projet" class="mt-3 text-end" data-confirm="Supprimer définitivement ce projet et tous ses documents ?">
            <?= Securite::csrfField() ?>
            <input type="hidden" name="projet_id" value="<?= $projet['id'] ?>">
            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash me-1"></i>Supprimer le projet</button>
          </form>
        <?php endif; ?>
      </div>

      <div class="col-lg-6">
        <?php if($edition) : ?>
          <div class="dash-card mb-4">
            <h2><span><i class="fas fa-list-check"></i>Vu par le client</span></h2>
            <?php $etapeCourante = (int)$projet['etape']; $compact = false; include "inc/partials/etapes.php"; ?>
          </div>

          <div class="dash-card mb-4">
            <h2><span><i class="fas fa-upload"></i>Déposer un document</span></h2>
            <form method="post" action="<?= URL ?>administration/validation_document" enctype="multipart/form-data" class="needs-validation" novalidate>
              <?= Securite::csrfField() ?>
              <input type="hidden" name="projet_id" value="<?= $projet['id'] ?>">
              <div class="mb-3">
                <label for="document" class="form-label">Fichier</label>
                <input type="file" class="form-control" id="document" name="document" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.odt,.ods,.zip,.txt">
                <div class="form-text">PDF, images, Office ou zip — 10 Mo maximum.</div>
              </div>
              <div class="row g-3 mb-3">
                <div class="col-sm-7">
                  <label for="nom" class="form-label">Nom affiché <span class="text-muted-wc fw-normal">(facultatif)</span></label>
                  <input type="text" class="form-control" id="nom" name="nom" maxlength="150" placeholder="Devis n°2026-12">
                </div>
                <div class="col-sm-5">
                  <label for="categorie" class="form-label">Catégorie</label>
                  <select class="form-select" id="categorie" name="categorie">
                    <?php foreach(EspaceManager::CATEGORIES_DOCUMENT as $cle => $libelle) : ?>
                      <option value="<?= $cle ?>"><?= $libelle ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <button type="submit" class="btn btn-cyan w-100"><i class="fas fa-cloud-arrow-up me-2"></i>Ajouter au projet</button>
            </form>
          </div>

          <div class="dash-card">
            <h2><span><i class="fas fa-folder-open"></i>Documents (<?= count($documents) ?>)</span></h2>
            <?php if(empty($documents)) : ?>
              <p class="text-muted-wc mb-0">Aucun document déposé.</p>
            <?php else : ?>
              <div class="d-grid gap-2">
                <?php foreach($documents as $document) :
                  $lienDocument = URL."administration/document/".$document['id'];
                  $actionSuppression = '<form method="post" action="'.URL.'administration/suppression_document" data-confirm="Supprimer ce document ?">'.Securite::csrfField().'<input type="hidden" name="document_id" value="'.$document['id'].'"><button type="submit" class="btn btn-outline-danger btn-sm" aria-label="Supprimer"><i class="fas fa-trash"></i></button></form>';
                  include "inc/partials/document_item.php";
                endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        <?php else : ?>
          <div class="dash-card">
            <h2><span><i class="fas fa-lightbulb"></i>Comment ça marche</span></h2>
            <ul class="check-list mt-0">
              <li><i class="fas fa-circle-check"></i><span>Le client crée son espace sur le site et valide son mail.</span></li>
              <li><i class="fas fa-circle-check"></i><span>Vous créez ici son projet : il le voit immédiatement dans son espace.</span></li>
              <li><i class="fas fa-circle-check"></i><span>À chaque avancée, vous changez l'étape et laissez un message.</span></li>
              <li><i class="fas fa-circle-check"></i><span>Vous déposez devis, factures et livrables : il les télécharge.</span></li>
            </ul>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
