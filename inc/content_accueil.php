<!-- SECTION PACKS ------------------------------->
<section class="section" id="packs">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <span class="kicker">Deux packs, un objectif</span>
      <h2>Où en est votre projet ?</h2>
      <p>Que vous lanciez votre entreprise ou que vous vouliez passer à la vitesse supérieure, nous avons le pack qu'il vous faut.</p>
    </div>
    <div class="row g-4">
      <div class="col-lg-6" data-aos="fade-up">
        <article class="pack-card pack-gold tilt">
          <div class="pack-bg" aria-hidden="true"><img src="<?= URL ?>public/Assets/images/entreprise/BP3.png" alt="" loading="lazy"></div>
          <span class="pack-tag"><i class="fas fa-rocket"></i>Pack Lancement &amp; Financement</span>
          <h3>Vous lancez votre projet ?</h3>
          <p class="pack-cible">Pour les futurs entrepreneurs et porteurs de projets. Objectif : obtenir le Kbis et l'accord de la banque.</p>
          <ul>
            <li><i class="fas fa-circle-check"></i><span><strong>Business plan complet</strong> — étude de marché, prévisionnel 3 ou 5 ans, mise en page investisseurs</span></li>
            <li><i class="fas fa-circle-check"></i><span><strong>Création de société</strong> — statuts, immatriculation, Journal officiel, Kbis</span></li>
            <li><i class="fas fa-circle-check"></i><span><strong>Aide aux aides</strong> — ACRE, ARCE</span></li>
            <li><i class="fas fa-circle-check"></i><span><strong>Livraison express</strong> — 48h à 7 jours</span></li>
          </ul>
          <div class="pack-prix">À partir de <b>299 €</b> le business plan · <b>200 €</b> + frais la création</div>
          <div class="d-flex flex-wrap gap-2">
            <a href="<?= URL ?>prestations/lancement" class="btn btn-gold">Découvrir le pack</a>
            <a href="<?= URL ?>contact?offre=Pack%20Lancement" class="btn btn-ghost">Devis gratuit</a>
          </div>
        </article>
      </div>
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="120">
        <article class="pack-card pack-cyan tilt">
          <div class="pack-bg" aria-hidden="true"><img src="<?= URL ?>img/pc_lumineux.jpg" alt="" loading="lazy"></div>
          <span class="pack-tag"><i class="fas fa-chart-line"></i>Pack Croissance</span>
          <h3>Votre entreprise existe déjà ?</h3>
          <p class="pack-cible">Pour passer à la vitesse supérieure. Objectif : développer le chiffre d'affaires et déléguer la paperasse.</p>
          <ul>
            <li><i class="fas fa-circle-check"></i><span><strong>Gestion &amp; administratif</strong> — RH, paie, devis et factures, à la carte</span></li>
            <li><i class="fas fa-circle-check"></i><span><strong>Site internet professionnel</strong> — vitrine ou e-commerce, SEO, maintenance</span></li>
            <li><i class="fas fa-circle-check"></i><span><strong>Stratégie marketing</strong> — audit, acquisition clients, image de marque</span></li>
            <li><i class="fas fa-circle-check"></i><span><strong>Suivi dans votre espace client</strong> — documents, demandes, avancement</span></li>
          </ul>
          <div class="pack-prix">RH dès <b>30 €</b> · Site dès <b>300 €</b> · Marketing dès <b>500 €</b></div>
          <div class="d-flex flex-wrap gap-2">
            <a href="<?= URL ?>prestations/marketing" class="btn btn-cyan">Découvrir le pack</a>
            <a href="<?= URL ?>contact?offre=Pack%20Croissance" class="btn btn-ghost">Devis gratuit</a>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>

<?php include "inc/partials/stats.php"; ?>

<!-- SECTION PRESTATIONS ------------------------------->
<?php
  $prestations = [
    ["fa-file-invoice", "Business plan professionnel", "Dès 299 €", "Un dossier de 30 pages : étude de marché, stratégie commerciale, prévisionnel financier sur 3 ou 5 ans, mise en page pour investisseurs.", "public/Assets/images/entreprise/BP2.png", "prestations/lancement", ""],
    ["fa-stamp", "Création de société", "Dès 200 € + frais", "Rédaction des statuts (SASU, SARL, EURL, micro-entreprise), immatriculation au greffe, Journal officiel et aide aux aides ACRE / ARCE.", "public/Assets/images/entreprise/ent.png", "prestations/lancement", ""],
    ["fa-folder-open", "Gestion & administratif", "RH dès 30 €", "Contrats, fiches de paie, entrées et sorties de salariés, création de devis et factures pros. À la carte, selon vos besoins.", "public/Assets/images/entreprise/bs3.png", "prestations/gestion", "cyan"],
    ["fa-laptop-code", "Site internet professionnel", "Dès 300 €", "Site vitrine ou e-commerce moderne et responsive, référencement SEO pour être trouvé sur Google, maintenance et fluidité garanties.", "public/Assets/images/site%20internet/si2.png", "prestations/sites", "cyan"],
    ["fa-bullhorn", "Marketing & croissance", "Dès 500 €", "Audit de votre activité, acquisition de prospects qualifiés, réseaux sociaux, publicité, identité visuelle et positionnement.", "public/Assets/images/site%20internet/rx3.png", "prestations/marketing", "cyan"],
    ["fa-headset", "Espace client inclus", "Offert", "Suivez l'avancement de vos projets, retrouvez vos devis, factures et documents, et échangez avec nous depuis votre espace.", "public/Assets/images/site%20internet/Design%20sans%20titre.png", "creerCompte", ""],
  ];
?>
<section class="section section-alt" id="prestations">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <span class="kicker">Nos prestations</span>
      <h2>Tout ce qu'il faut pour réussir, au même endroit</h2>
      <p>Secteurs : VTC, BTP, restauration, e-commerce, professions libérales… Nous accompagnons tous les entrepreneurs.</p>
    </div>
    <div class="row g-4">
      <?php foreach($prestations as $i => $prestation) : ?>
        <div class="col-md-6 col-xl-4" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 100 ?>">
          <article class="service-card tilt">
            <div class="media">
              <div class="img-wrap"><img src="<?= URL.$prestation[4] ?>" alt="" loading="lazy"></div>
              <span class="icon <?= $prestation[6] ?>"><i class="fas <?= $prestation[0] ?>"></i></span>
            </div>
            <div class="body">
              <div class="prix"><?= $prestation[2] ?></div>
              <h3><?= $prestation[1] ?></h3>
              <p><?= $prestation[3] ?></p>
              <a href="<?= URL.$prestation[5] ?>" class="link-arrow">En savoir plus <i class="fas fa-arrow-right"></i></a>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- SECTION SECTEURS ------------------------------->
<?php
  $secteurs = [
    ["fa-taxi", "VTC & transport", "public/Assets/images/entreprise/vtc3.png"],
    ["fa-helmet-safety", "BTP & artisans", "public/Assets/images/entreprise/entreprise3.png"],
    ["fa-utensils", "Restauration", "img/pc_cafe.jpg"],
    ["fa-cart-shopping", "E-commerce", "public/Assets/images/site%20internet/si2.png"],
    ["fa-user-tie", "Professions libérales", "public/Assets/images/entreprise/ent.png"],
    ["fa-building", "Sociétés & start-up", "public/Assets/images/entreprise/1_20230314_082639_0000.png"],
  ];
?>
<section class="section">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <span class="kicker cyan">Secteurs</span>
      <h2>Nous accompagnons tous les entrepreneurs</h2>
      <p>VTC, BTP, restauration, e-commerce, professions libérales… partout en France, en visio ou en rendez-vous.</p>
    </div>
    <div class="row g-3">
      <?php foreach($secteurs as $i => $secteur) : ?>
        <div class="col-6 col-md-4 col-lg-2" data-aos="zoom-in" data-aos-delay="<?= $i * 70 ?>">
          <a href="<?= URL ?>contact?offre=<?= rawurlencode($secteur[1]) ?>" class="sector">
            <img src="<?= URL.$secteur[2] ?>" alt="" loading="lazy">
            <span class="lbl"><i class="fas <?= $secteur[0] ?>"></i><?= $secteur[1] ?></span>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
  $features = [
    "kicker" => "Notre méthode",
    "titre" => "Un accompagnement simple, en 4 étapes",
    "texte" => "Vous nous expliquez votre projet, nous nous occupons du reste.",
    "sombre" => true,
    "etapes" => true,
    "items" => [
      ["fa-comments", "Écoute", "Un premier échange gratuit, en visio ou en rendez-vous, pour comprendre votre activité et vos objectifs."],
      ["fa-magnifying-glass-chart", "Analyse", "Nous identifions vos besoins et vous envoyons un devis clair sous 48h."],
      ["fa-pen-ruler", "Réalisation", "Nous réalisons votre prestation et vous suivez l'avancement depuis votre espace client."],
      ["fa-headset", "Suivi", "Vos documents, vos demandes et notre support restent accessibles après la livraison."],
    ],
  ];
  include "inc/partials/features.php";

  include "inc/partials/realisations.php";

  $tarifs = [
    "titre" => "Des tarifs clairs, dès le départ",
    "texte" => "Chaque projet est unique : ces prix sont indicatifs, demandez-nous un devis personnalisé.",
    "offres" => [
      ["nom" => "Business plan", "prix" => "299 €", "periode" => "", "option" => "Prévisionnel financier seul dès 150 €", "details" => ["Étude de marché", "Stratégie commerciale", "Prévisionnel 3 ou 5 ans", "Mise en page investisseurs"]],
      ["nom" => "Création de société", "prix" => "200 €", "periode" => "+ frais", "details" => ["Statuts SASU, SARL, EURL, micro", "Immatriculation & Journal officiel", "Aide ACRE / ARCE", "Livraison 48h à 7 jours"]],
      ["nom" => "Site internet", "prix" => "300 €", "periode" => "", "vedette" => true, "details" => ["Vitrine ou e-commerce", "Responsive PC / mobile", "Référencement SEO", "Maintenance incluse"]],
      ["nom" => "Marketing & croissance", "prix" => "500 €", "periode" => "", "details" => ["Audit de votre activité", "Acquisition clients", "Image de marque", "Réseaux sociaux & publicité"]],
    ],
  ];
  include "inc/partials/pricing.php";

  $cta_titre = "Appelez-nous pour transformer votre activité";
  include "inc/partials/cta.php";

  include "inc/partials/contact_form.php";
?>
