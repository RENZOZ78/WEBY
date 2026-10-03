<?php
  $s = $systeme;
  $verifs = [
    [$s['https'], "Connexion sécurisée (HTTPS)", $s['https'] ? "active" : "inactive : le site devrait être servi en https"],
    [!$s['erreurs_affichees'], "Erreurs PHP", $s['erreurs_affichees'] ? "affichées aux visiteurs (display_errors à désactiver)" : "masquées aux visiteurs"],
    [$s['stockage_ecriture'], "Dossier des documents clients", $s['stockage_ecriture'] ? "accessible en écriture" : "non accessible en écriture : les dépôts échoueront"],
    [$s['mail'], "Envoi de mails", $s['mail'] ? "fonction mail() disponible (expéditeur ".$s['mail_contact'].")" : "fonction mail() indisponible"],
    [$s['schema'] >= 2, "Schéma de la base", "version ".$s['schema']],
  ];
?>
<section class="section">
  <div class="container">
    <?php include "inc/partials/supervision_nav.php"; ?>

    <div class="row g-4">
      <div class="col-lg-6">
        <div class="dash-card">
          <h2><span><i class="fas fa-shield-halved"></i>Contrôles</span></h2>
          <ul class="sv-checks">
            <?php foreach($verifs as [$ok, $nom, $detail]) : ?>
              <li class="<?= $ok ? "ok" : "ko" ?>"><i class="fas <?= $ok ? "fa-circle-check" : "fa-circle-xmark" ?>" aria-hidden="true"></i><div><strong><?= $nom ?></strong><small><?= sv_txt($detail) ?></small></div></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="dash-card">
          <h2><span><i class="fas fa-server"></i>Serveur</span></h2>
          <div class="sv-kv">
            <div><span><?= sv_txt($s['php']) ?></span>version de PHP</div>
            <div><span><?= sv_txt(explode("-", $s['base'])[0]) ?></span>base de données<?= stripos($s['base'], "mariadb") !== false ? " (MariaDB)" : "" ?></div>
            <div><span><?= $s['deploiement'] ? sv_depuis($s['deploiement']) : "—" ?></span>dernière mise à jour des fichiers<?= $s['deploiement'] ? " (".Toolbox::dateFr($s['deploiement']).")" : "" ?></div>
            <div><span><?= $s['disque_libre'] === null ? "—" : Toolbox::tailleFichier($s['disque_libre']) ?></span>espace disque libre</div>
            <div><span><?= Toolbox::tailleFichier($s['stockage']) ?></span>documents clients sur le disque (<?= sv_nombre($documents['total']) ?>)</div>
            <div><span><?= Toolbox::tailleFichier($s['taille_base']) ?></span>taille de la base</div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="table-card">
          <div class="table-responsive">
            <table class="table align-middle">
              <thead><tr><th>Table</th><th class="text-end">Lignes</th><th class="text-end">Taille</th></tr></thead>
              <tbody>
                <?php foreach($s['tables'] as $t) : ?>
                  <tr><td><?= sv_txt($t['nom']) ?></td><td class="text-end"><?= sv_nombre($t['lignes']) ?></td><td class="text-end"><?= Toolbox::tailleFichier((int)$t['taille']) ?></td></tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
