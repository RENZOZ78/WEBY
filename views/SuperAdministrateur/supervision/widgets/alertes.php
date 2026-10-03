<?php
  $points = [];
  if($demandes['sans_reponse_48h'] > 0) $points[] = ["danger", "fa-hourglass-end", $demandes['sans_reponse_48h']." demande(s) sans réponse depuis plus de 48 h", "administration/demandes?statut=nouvelle"];
  if(($demandes['statuts']['nouvelle'] ?? 0) > 0) $points[] = ["warning", "fa-inbox", (int)$demandes['statuts']['nouvelle']." demande(s) nouvelle(s) à traiter", "administration/demandes?statut=nouvelle"];
  $nbEchecs = array_sum(array_column($echecs, "nb"));
  $suspects = array_filter($echecs, function($e){ return $e['nb'] >= 5; });
  if($suspects) $points[] = ["danger", "fa-user-secret", count($suspects)." adresse(s) avec 5 échecs de connexion ou plus en 24 h", "supervision/activite?categorie=securite&periode=7"];
  elseif($nbEchecs > 0) $points[] = ["warning", "fa-triangle-exclamation", $nbEchecs." échec(s) de connexion en 24 h", "supervision/activite?categorie=securite&periode=7"];
  if($projets['sans_nouvelles'] > 0) $points[] = ["warning", "fa-hourglass-half", $projets['sans_nouvelles']." projet(s) en cours sans mise à jour depuis 30 jours", "administration/projets"];
  if($comptes_attente > 0) $points[] = ["info", "fa-user-clock", $comptes_attente." compte(s) en attente de validation par mail", "supervision/comptes"];
?>
<div class="dash-card">
  <h2><span><i class="fas <?= $iconeWidget ?>"></i><?= $titreWidget ?></span></h2>
  <?php if(empty($points)) : ?>
    <p class="sv-ok mb-0"><i class="fas fa-circle-check"></i>Rien à signaler : tout est à jour.</p>
  <?php else : ?>
    <ul class="sv-alertes">
      <?php foreach($points as [$niveau, $icone, $texte, $lien]) : ?>
        <li class="<?= $niveau ?>"><i class="fas <?= $icone ?>" aria-hidden="true"></i><a href="<?= URL.$lien ?>"><?= $texte ?></a></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <?php if(!empty($attente)) : ?>
    <h3 class="sv-subtitle">Les plus anciennes en attente</h3>
    <?php foreach($attente as $demande) : ?>
      <div class="list-item">
        <div class="txt">
          <a href="<?= URL ?>administration/demande/<?= (int)$demande['id'] ?>"><?= sv_txt($demande['sujet']) ?></a>
          <small><?= sv_txt($demande['nom']) ?> · <?= sv_depuis($demande['updated_at']) ?></small>
        </div>
        <span class="status-badge nouvelle">Nouvelle</span>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
