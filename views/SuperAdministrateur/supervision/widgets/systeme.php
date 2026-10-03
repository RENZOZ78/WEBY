<div class="dash-card">
  <h2><span><i class="fas <?= $iconeWidget ?>"></i><?= $titreWidget ?></span><a href="<?= URL ?>supervision/systeme">Détail</a></h2>
  <ul class="sv-checks">
    <li class="<?= $systeme['https'] ? "ok" : "ko" ?>"><i class="fas <?= $systeme['https'] ? "fa-lock" : "fa-lock-open" ?>"></i>Connexion sécurisée (HTTPS) <?= $systeme['https'] ? "active" : "inactive" ?></li>
    <li class="<?= $systeme['erreurs_affichees'] ? "ko" : "ok" ?>"><i class="fas <?= $systeme['erreurs_affichees'] ? "fa-bug" : "fa-shield-halved" ?>"></i>Erreurs PHP <?= $systeme['erreurs_affichees'] ? "affichées aux visiteurs" : "masquées aux visiteurs" ?></li>
    <li class="<?= $systeme['stockage_ecriture'] ? "ok" : "ko" ?>"><i class="fas fa-folder-open"></i>Dossier des documents <?= $systeme['stockage_ecriture'] ? "accessible en écriture" : "non accessible en écriture" ?></li>
  </ul>
  <div class="sv-kv">
    <div><span><?= sv_txt($systeme['php']) ?></span>version de PHP</div>
    <div><span><?= sv_nombre($documents['total']) ?></span>documents (<?= Toolbox::tailleFichier($documents['taille']) ?>)</div>
    <div><span><?= $systeme['deploiement'] ? sv_depuis($systeme['deploiement']) : "—" ?></span>dernière mise à jour du site</div>
    <div><span><?= sv_nombre($documents['telecharges']) ?></span>téléchargements clients</div>
  </div>
</div>
