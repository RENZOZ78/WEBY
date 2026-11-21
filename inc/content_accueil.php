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
            <a href="<?= URL ?>contact?offre=Pack%20Lancement" class="btn btn-ghost">Demander un devis gratuit</a>
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
            <a href="<?= URL ?>contact?offre=Pack%20Croissance" class="btn btn-ghost">Demander un devis gratuit</a>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>

<!-- SECTION METIERS : bandeau défilant, une page par métier (juste après les packs) ------------------------------->
<?php include "inc/partials/secteurs.php"; ?>

<?php
  include "inc/partials/stats.php";

  /* Accueil volontairement court (2026-11-21) : une seule présentation de l'offre et des prix en plus des packs.
   * - La grille des 6 prestations n'est plus affichée ici : elle répétait les packs et les tarifs ;
   *   chaque prestation garde sa page (liens « Voir le détail » ci-dessous et menu « Prestations »).
   * - La méthode en 4 étapes n'est plus affichée ici : le cycle animé du haut de page porte déjà cette idée.
   * Les partiels inc/partials/features.php et pricing.php restent utilisés par les pages prestations et métier. */

  include "inc/partials/realisations.php";

  $tarifs = [
    "titre" => "Des tarifs clairs, dès le départ",
    "texte" => "Chaque projet est unique : ces prix sont indicatifs, demandez-nous un devis personnalisé.",
    "compact" => true,
    "offres" => [
      ["nom" => "Business plan", "prix" => "299 €", "periode" => "", "lien" => "prestations/lancement", "option" => "Prévisionnel financier seul dès 150 €", "details" => ["Étude de marché", "Stratégie commerciale", "Prévisionnel 3 ou 5 ans", "Mise en page investisseurs"]],
      ["nom" => "Création de société", "prix" => "200 €", "periode" => "+ frais", "lien" => "prestations/lancement", "details" => ["Statuts SASU, SARL, EURL, micro", "Immatriculation & Journal officiel", "Aide ACRE / ARCE", "Livraison 48h à 7 jours"]],
      ["nom" => "Gestion & administratif", "prix" => "30 €", "periode" => "/ acte RH", "lien" => "prestations/gestion", "details" => ["Contrats de travail", "Fiches de paie", "Devis et factures pros", "À la carte"]],
      ["nom" => "Site internet", "prix" => "300 €", "periode" => "", "lien" => "prestations/sites", "details" => ["Vitrine ou e-commerce", "Responsive PC / mobile", "Référencement SEO", "Maintenance incluse"]],
      ["nom" => "Marketing & croissance", "prix" => "500 €", "periode" => "", "lien" => "prestations/marketing", "details" => ["Audit de votre activité", "Acquisition clients", "Image de marque", "Réseaux sociaux & publicité"]],
    ],
  ];
  include "inc/partials/pricing.php";

  $cta_titre = "Appelez-nous pour transformer votre activité";
  include "inc/partials/cta.php";

  include "inc/partials/contact_form.php";
?>
