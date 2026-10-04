<?php
  /* Exemples de sites réalisés par l'agence */
  $realisations = [
    ["Salle de sport", "Fiteos", "Site commercial pour une salle de sport.", "img/gym-accueil.jpg", "https://fiteos.click/"],
    ["Agence immobilière", "Delta-Immo", "Site d'agence immobilière qui présente des biens d'exception.", "img/img-portfolio2.jpg", "https://relaxed-lewin-d05331.netlify.app/"],
    ["Restauration", "Magic Food Panam", "Restaurant en ligne proposant une grande variété de délicieux plats.", "img/magic-food-cap.png", "https://elaborate-dango-33f458.netlify.app/"],
  ];
?>
<section class="section section-alt" id="realisations">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <span class="kicker">Réalisations</span>
      <h2>Vos projets sont notre inspiration</h2>
      <p>Tous nos sites bénéficient d'une optimisation SEO et sont adaptés aux ordinateurs, tablettes et mobiles.</p>
    </div>
    <div class="row g-4">
      <?php foreach($realisations as $i => $projet) : ?>
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
          <article class="project-card tilt">
            <div class="thumb"><img src="<?= URL.$projet[3] ?>" alt="Aperçu du site <?= $projet[1] ?>" loading="lazy"></div>
            <div class="body">
              <span class="tag"><?= $projet[0] ?></span>
              <h3><?= $projet[1] ?></h3>
              <p><?= $projet[2] ?></p>
              <a href="<?= $projet[4] ?>" class="link-arrow" target="_blank" rel="noopener">Voir le site <i class="fas fa-arrow-up-right-from-square"></i></a>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
