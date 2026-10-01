<?php
  /* Ligne de document : $document, $lienDocument (url de telechargement), $actionSuppression (html optionnel) */
  $ext = strtolower(pathinfo($document['fichier'], PATHINFO_EXTENSION));
  $icone = $ext === "pdf" ? "fa-file-pdf" : (in_array($ext, ["jpg", "jpeg", "png"]) ? "fa-file-image" : (in_array($ext, ["xls", "xlsx", "ods"]) ? "fa-file-excel" : (in_array($ext, ["doc", "docx", "odt"]) ? "fa-file-word" : "fa-file-lines")));
  $classe = $ext === "pdf" ? "pdf" : (in_array($ext, ["jpg", "jpeg", "png"]) ? "img" : "");
?>
<div class="doc-item">
  <span class="icon <?= $classe ?>"><i class="fas <?= $icone ?>"></i></span>
  <div class="txt">
    <strong><?= $document['nom'] ?></strong>
    <small><?= EspaceManager::CATEGORIES_DOCUMENT[$document['categorie']] ?? "Document" ?> · <?= Toolbox::tailleFichier($document['taille']) ?> · <?= Toolbox::dateFr($document['created_at'], false) ?><?= !empty($document['projet_titre']) ? " · ".$document['projet_titre'] : "" ?></small>
  </div>
  <a href="<?= $lienDocument ?>" class="btn btn-light btn-sm"><i class="fas fa-download me-1"></i>Télécharger</a>
  <?= $actionSuppression ?? "" ?>
</div>
