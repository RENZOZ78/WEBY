<?php
  /* Section d'introduction d'une prestation
   * $intro = ["kicker", "titre", "paragraphes" => [], "image", "points" => [[icone, titre, texte]]] */
  $idAccordeon = "accordeon-".substr(md5($intro['titre']), 0, 6);
?>
<section class="section">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6<?= !empty($intro['inverse']) ? ' order-lg-2' : '' ?>" data-aos="reveal" data-aos-duration="1100">
        <div class="intro-img-wrap">
          <div class="photo tilt">
            <img class="intro-img" src="<?= URL.$intro['image'] ?>" alt="<?= htmlspecialchars($intro['alt'] ?? '') ?>" loading="lazy">
            <?php if(!empty($intro['legende'])) : ?><div class="caption"><strong><?= $intro['legende'][0] ?></strong><small><?= $intro['legende'][1] ?></small></div><?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <span class="kicker"><?= $intro['kicker'] ?></span>
        <h2 class="mb-3"><?= $intro['titre'] ?></h2>
        <?php foreach($intro['paragraphes'] as $paragraphe) : ?>
          <p class="text-muted-wc"><?= $paragraphe ?></p>
        <?php endforeach; ?>

        <div class="accordion wc-accordion mt-4" id="<?= $idAccordeon ?>">
          <?php foreach($intro['points'] as $i => $point) : ?>
            <div class="accordion-item">
              <h3 class="accordion-header">
                <button class="accordion-button<?= $i > 0 ? ' collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $idAccordeon.'-'.$i ?>" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
                  <i class="fas <?= $point[0] ?>"></i><?= $point[1] ?>
                </button>
              </h3>
              <div id="<?= $idAccordeon.'-'.$i ?>" class="accordion-collapse collapse<?= $i === 0 ? ' show' : '' ?>" data-bs-parent="#<?= $idAccordeon ?>">
                <div class="accordion-body"><?= $point[2] ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
