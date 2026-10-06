<?php
  /* Page d'un métier : ses problématiques, nos solutions, ce qu'il y gagne
   * $secteur et $slug viennent du contrôleur (données dans inc/secteurs.php) */
  $prestationsLiees = [
    "lancement" => ["prestations/lancement", "Business plan & création"],
    "gestion" => ["prestations/gestion", "Gestion & administratif"],
    "sites" => ["prestations/sites", "Site internet"],
    "marketing" => ["prestations/marketing", "Marketing & croissance"],
  ];
?>
<!-- PROBLEMATIQUES ------------------------------->
<section class="section" id="problematiques">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <span class="kicker">Vous vous reconnaissez ?</span>
      <h2>Les casse-têtes que nous entendons le plus souvent</h2>
      <p><?= $secteur['qui'] ?> : voici ce qui revient dans nos échanges. Cliquez sur « C'est mon cas » et nous partirons de là.</p>
    </div>
    <div class="row g-4">
      <?php foreach($secteur['problemes'] as $i => $probleme) : ?>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
          <article class="probleme-card">
            <span class="icon"><i class="fas <?= $probleme[0] ?>"></i></span>
            <h3><?= $probleme[1] ?></h3>
            <p><?= $probleme[2] ?></p>
            <a href="<?= URL ?>secteurs/<?= $slug ?>?offre=<?= rawurlencode($secteur['nom']." – ".$probleme[1]) ?>#contact" class="link-arrow">C'est mon cas <i class="fas fa-arrow-right"></i></a>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- SOLUTIONS ------------------------------->
<section class="section section-alt" id="solutions">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <span class="kicker cyan">Nos solutions</span>
      <h2>Ce que nous mettons en place pour vous</h2>
      <p>Des prestations concrètes, adaptées à votre métier, que vous pouvez prendre ensemble ou séparément.</p>
    </div>
    <div class="row g-4">
      <?php foreach($secteur['solutions'] as $i => $solution) : [$lienPrestation, $nomPrestation] = $prestationsLiees[$solution[3]]; ?>
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?= ($i % 2) * 100 ?>">
          <article class="solution-card tilt">
            <span class="num">0<?= $i + 1 ?></span>
            <span class="icon"><i class="fas <?= $solution[0] ?>"></i></span>
            <div>
              <h3><?= $solution[1] ?></h3>
              <p><?= $solution[2] ?></p>
              <a href="<?= URL.$lienPrestation ?>" class="solution-tag"><?= $nomPrestation ?> <i class="fas fa-arrow-right"></i></a>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
  $features = [
    "kicker" => "Ce que vous y gagnez",
    "titre" => "Concrètement, pour votre activité",
    "sombre" => true,
    "items" => $secteur['gains'],
  ];
  include "inc/partials/features.php";

  $cta_titre = "Prêt à régler ces casse-têtes ?";
  include "inc/partials/cta.php";

  $offre_defaut = $secteur['nom'];
  include "inc/partials/contact_form.php";

  $bandeau = [
    "kicker" => "Les autres métiers",
    "titre" => "Nous accompagnons aussi",
    "texte" => "Votre activité touche plusieurs domaines ? Découvrez ce que nous faisons pour les autres métiers.",
    "exclu" => $slug,
  ];
  include "inc/partials/secteurs.php";
?>
