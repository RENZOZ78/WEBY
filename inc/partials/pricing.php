<?php
  /* Grille de tarifs
   * $tarifs = ["titre", "texte", "offres" => [["nom", "prix", "periode", "details" => [], "vedette" => bool, "lien" => page de détail]]]
   * "compact" => true : une ligne par offre au lieu d'une carte (accueil), avec un lien vers la page de la prestation */
  $nbOffres = count($tarifs['offres']);
?>
<section class="section" id="tarifs">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <span class="kicker">Tarifs</span>
      <h2><?= $tarifs['titre'] ?></h2>
      <?php if(!empty($tarifs['texte'])) : ?><p><?= $tarifs['texte'] ?></p><?php endif; ?>
    </div>
    <?php if(!empty($tarifs['compact'])) : ?>
      <ul class="tarifs-liste" data-aos="fade-up">
        <?php foreach($tarifs['offres'] as $offre) : ?>
          <li>
            <div class="tarif-nom">
              <h3><?= $offre['nom'] ?></h3>
              <p><?= implode(" · ", $offre['details']) ?><?php if(!empty($offre['option'])) : ?> · <?= $offre['option'] ?><?php endif; ?></p>
            </div>
            <div class="tarif-prix"><span>À partir de</span> <b><?= $offre['prix'] ?></b><?php if(!empty($offre['periode'])) : ?> <small><?= $offre['periode'] ?></small><?php endif; ?></div>
            <div class="tarif-actions">
              <?php if(!empty($offre['lien'])) : ?><a href="<?= URL.$offre['lien'] ?>" class="link-arrow">Voir le détail<span class="visually-hidden"> : <?= $offre['nom'] ?></span> <i class="fas fa-arrow-right"></i></a><?php endif; ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
      <p class="text-center mt-4 mb-0"><a href="<?= URL ?>contact" class="btn btn-gold btn-lg">Demander un devis gratuit</a></p>
    <?php else : ?>
    <div class="row g-4 justify-content-center">
      <?php foreach($tarifs['offres'] as $i => $offre) : ?>
        <div class="col-md-6 <?= $nbOffres === 4 ? 'col-xl-3' : 'col-lg-4' ?>" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
          <div class="price-card tilt<?= !empty($offre['vedette']) ? ' featured' : '' ?>">
            <?php if(!empty($offre['vedette'])) : ?><span class="badge-pop">Le plus demandé</span><?php endif; ?>
            <div class="name"><?= $offre['nom'] ?></div>
            <div class="from">À partir de</div>
            <div class="price"><?= $offre['prix'] ?><?php if(!empty($offre['periode'])) : ?> <small><?= $offre['periode'] ?></small><?php endif; ?></div>
            <?php if(!empty($offre['option'])) : ?><div class="small text-muted-wc mt-1"><?= $offre['option'] ?></div><?php endif; ?>
            <ul>
              <?php foreach($offre['details'] as $detail) : ?>
                <li><i class="fas fa-circle-check"></i><span><?= $detail ?></span></li>
              <?php endforeach; ?>
            </ul>
            <a href="<?= URL ?>contact?offre=<?= rawurlencode(html_entity_decode(strip_tags($offre['nom']))) ?>" class="btn <?= !empty($offre['vedette']) ? 'btn-gold' : 'btn-outline-navy' ?> w-100">Demander un devis gratuit</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <p class="price-note"><i class="fas fa-credit-card me-1"></i> Prix indicatifs « à partir de », devis gratuit et personnalisé. Paiement sécurisé par CB ou PayPal, en 2x ou 3x dès 200 € avec Alma.</p>
  </div>
</section>
