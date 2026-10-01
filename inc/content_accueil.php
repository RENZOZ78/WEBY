<?php
  $prestations = [
    ["fa-briefcase", "Création de société", "Nous vous accompagnons dans la création de votre société et dans tous les besoins liés à votre activité.", "public/Assets/images/accueil/entreprise%20rc.png", "prestations/entreprises"],
    ["fa-laptop-code", "Votre site web", "Grâce à un site internet responsive, vous affichez votre activité sur internet et captez de nouveaux clients.", "public/Assets/images/site%20internet/si3.png", "prestations/sites"],
    ["fa-hashtag", "Vos réseaux sociaux", "Il est temps d'exploiter les réseaux sociaux à votre profit grâce à une gestion dynamique de votre communauté.", "public/Assets/images/reseaux%20sociaux/rx4.png", "prestations/reseaux"],
    ["fa-bullhorn", "Marketing web", "Nous mettons en place une stratégie marketing pour vous amener des clients et développer votre chiffre d'affaires.", "public/Assets/images/strategie_marketing/st3.png", "prestations/marketing"],
  ];
?>
<!-- SECTION PRESTATIONS ------------------------------->
<section class="section" id="prestations">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <span class="kicker">Nos prestations</span>
      <h2>Tout ce qu'il faut pour réussir sur le web</h2>
      <p>Une palette de prestations pour vous mener droit au succès de votre activité.</p>
    </div>
    <div class="row g-4">
      <?php foreach($prestations as $i => $prestation) : ?>
        <div class="col-md-6 col-xl-3" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
          <article class="service-card">
            <div class="media">
              <div class="img-wrap"><img src="<?= URL.$prestation[3] ?>" alt="" loading="lazy"></div>
              <span class="icon"><i class="fas <?= $prestation[0] ?>"></i></span>
            </div>
            <div class="body">
              <h3><?= $prestation[1] ?></h3>
              <p><?= $prestation[2] ?></p>
              <a href="<?= URL.$prestation[4] ?>" class="link-arrow">En savoir plus <i class="fas fa-arrow-right"></i></a>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
  $intro = [
    "kicker" => "À propos",
    "titre" => "Une agence qui vous écoute",
    "image" => "public/Assets/images/entreprise/brainstorming.png",
    "alt" => "L'équipe WebyCloudy en réunion",
    "paragraphes" => [
      "Notre agence vous propose plusieurs solutions afin que votre activité prenne l'importance qu'elle mérite sur le web.",
      "Nous écoutons vos demandes, identifions vos besoins, puis nous réalisons votre projet de A à Z.",
    ],
    "points" => [
      ["fa-rocket", "Lancer votre activité", "Nous mettons un point d'honneur à vous proposer des solutions modernes, afin que vous puissiez attirer une large palette de clients."],
      ["fa-laptop-code", "Créer votre site internet", "Nous créons votre site internet afin que vous puissiez capter de nouveaux clients. Vous renforcerez également l'identité de votre activité."],
      ["fa-hashtag", "Gérer vos réseaux sociaux", "Nous accentuons votre présence sur le web pour que vous profitiez de tout le potentiel de votre entreprise. Parce que votre réputation est primordiale, nous veillons à ce que vos clients soient satisfaits et le disent tout haut."],
      ["fa-bullhorn", "Mettre en place votre stratégie marketing", "Nous mettons en place votre stratégie marketing digitale pour que vous puissiez obtenir des clients plus rapidement."],
    ],
  ];
  include "inc/partials/intro.php";

  $features = [
    "kicker" => "Notre méthode",
    "titre" => "Un accompagnement simple, en 4 étapes",
    "texte" => "Ne vous inquiétez pas, on s'occupe de tout.",
    "sombre" => true,
    "etapes" => true,
    "items" => [
      ["fa-comments", "Écoute", "Nous échangeons sur votre activité, vos objectifs et votre budget."],
      ["fa-magnifying-glass-chart", "Analyse", "Nous identifions vos besoins et vous proposons la solution adaptée."],
      ["fa-pen-ruler", "Réalisation", "Nous réalisons votre projet et vous tenons informé à chaque étape."],
      ["fa-headset", "Suivi", "Nous restons à vos côtés après la mise en ligne pour vous faire grandir."],
    ],
  ];
  include "inc/partials/features.php";

  include "inc/partials/realisations.php";

  $tarifs = [
    "titre" => "Des offres claires, adaptées à chaque étape",
    "texte" => "Chaque projet est unique : ces prix sont indicatifs, demandez-nous un devis personnalisé.",
    "offres" => [
      ["nom" => "Création d'entreprise", "prix" => "200€", "periode" => "+ frais", "details" => ["Business plan", "Création de société", "Modification de société", "Suppression de société"]],
      ["nom" => "Votre site web", "prix" => "350€", "periode" => "", "vedette" => true, "details" => ["Site statique", "Site dynamique ou e-commerce", "SEO + référencement", "Nom de domaine + hébergement"]],
      ["nom" => "Réseaux sociaux", "prix" => "300€", "periode" => "/mois", "details" => ["Facebook", "Instagram", "Snapchat", "Google"]],
      ["nom" => "Publicité", "prix" => "200€", "periode" => "/mois", "details" => ["Google Ads", "Instagram Ads", "Facebook Ads", "TikTok Ads"]],
    ],
  ];
  include "inc/partials/pricing.php";

  $features = [
    "kicker" => "Nos garanties",
    "titre" => "Travailler avec nous, en toute sérénité",
    "items" => [
      ["fa-bolt", "Traitement rapide", "Nous traitons vos demandes sous 48h."],
      ["fa-lock", "Paiement sécurisé", "CB, PayPal, et paiement en 2x ou 3x dès 200€ avec Alma."],
      ["fa-headset", "Une équipe disponible", "Notre service client vous répond de 10h à 18h."],
    ],
  ];
  include "inc/partials/features.php";

  $cta_titre = "Passer au niveau supérieur n'aura jamais été aussi simple";
  include "inc/partials/cta.php";

  include "inc/partials/contact_form.php";
?>
