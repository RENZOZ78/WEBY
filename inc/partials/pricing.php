<?php
  /* Grille de tarifs
   * $tarifs = ["titre", "texte", "offres" => [["nom", "prix", "periode", "details" => [], "vedette" => bool]]] */
  $nbOffres = count($tarifs['offres']);
?>
<section class="section" id="tarifs">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <span class="kicker">Tarifs</span>
      <h2><?= $tarifs['titre'] ?></h2>
      <?php if(!empty($tarifs['texte'])) : ?><p><?= $tarifs['texte'] ?></p><?php endif; ?>
    </div>
    <div class="row g-4 justify-content-center">
      <?php foreach($tarifs['offres'] as $i => $offre) : ?>
        <div class="col-md-6 <?= $nbOffres === 4 ? 'col-xl-3' : 'col-lg-4' ?>" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
          <div class="price-card<?= !empty($offre['vedette']) ? ' featured' : '' ?>">
            <?php if(!empty($offre['vedette'])) : ?><span class="badge-pop">Le plus demandé</span><?php endif; ?>
            <div class="name"><?= $offre['nom'] ?></div>
            <div class="from">À partir de</div>
            <div class="price"><?= $offre['prix'] ?><?php if(!empty($offre['periode'])) : ?> <small><?= $offre['periode'] ?></small><?php endif; ?></div>
            <ul>
              <?php foreach($offre['details'] as $detail) : ?>
                <li><i class="fas fa-circle-check"></i><span><?= $detail ?></span></li>
              <?php endforeach; ?>
            </ul>
            <a href="<?= URL ?>contact?offre=<?= rawurlencode(html_entity_decode(strip_tags($offre['nom']))) ?>" class="btn <?= !empty($offre['vedette']) ? 'btn-gold' : 'btn-outline-navy' ?> w-100">Demander un devis</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="price-note"><i class="fas fa-credit-card me-1"></i> Paiement sécurisé par CB ou PayPal — paiement en 2x ou 3x dès 200€ avec Alma.</p>
  </div>
</section>
