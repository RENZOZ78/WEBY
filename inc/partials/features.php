<?php
  /* Grille d'avantages
   * $features = ["kicker", "titre", "texte", "sombre" => bool, "items" => [[icone, titre, texte]]] */
  $nbFeatures = count($features['items']);
?>
<section class="section <?= !empty($features['sombre']) ? 'section-glow' : '' ?>">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <span class="kicker"><?= $features['kicker'] ?></span>
      <h2><?= $features['titre'] ?></h2>
      <?php if(!empty($features['texte'])) : ?><p><?= $features['texte'] ?></p><?php endif; ?>
    </div>
    <div class="row g-4 justify-content-center">
      <?php foreach($features['items'] as $i => $item) : ?>
        <div class="col-md-6 <?= $nbFeatures === 4 ? 'col-lg-3' : 'col-lg-4' ?>" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
          <div class="feature">
            <?php if(!empty($features['etapes'])) : ?><div class="step-num">0<?= $i + 1 ?></div><?php endif; ?>
            <div class="icon"><i class="fas <?= $item[0] ?>"></i></div>
            <h3><?= $item[1] ?></h3>
            <p><?= $item[2] ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
