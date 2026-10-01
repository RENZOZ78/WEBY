<?php
  /* Chiffres clés (identiques sur toutes les pages publiques) */
  $chiffres = $chiffres ?? [
    ["95 %", "de clients satisfaits", 95, " %"],
    ["48h – 7j", "livraison express"],
    ["30", "pages de business plan", 30, " pages"],
    ["2x · 3x", "paiement sans frais dès 200 €"],
  ];
?>
<section class="section-sm">
  <div class="container">
    <div class="row g-3">
      <?php foreach($chiffres as $i => $chiffre) : ?>
        <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
          <div class="stat-tile">
            <?php if(isset($chiffre[2])) : ?>
              <div class="val"><span data-count="<?= $chiffre[2] ?>" data-suffix="<?= $chiffre[3] ?? '' ?>">0<?= $chiffre[3] ?? '' ?></span></div>
            <?php else : ?>
              <div class="val"><?= $chiffre[0] ?></div>
            <?php endif; ?>
            <div class="lbl"><?= $chiffre[1] ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
