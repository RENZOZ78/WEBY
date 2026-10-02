<?php
  $intro = [
    "kicker" => "Business plan professionnel",
    "titre" => "Un dossier qui convainc votre banquier",
    "image" => "public/Assets/images/entreprise/entreprise3.png",
    "alt" => "Équipe qui prépare un dossier de création d'entreprise",
    "legende" => ["Un dossier de 30 pages", "Étude de marché, prévisionnel, mise en page investisseurs"],
    "paragraphes" => [
      "Vous lancez votre projet ? Mettez toutes les chances de votre côté pour convaincre votre banquier et l'administration.",
      "95 % de nos clients ont validé leur dossier grâce à notre expertise. Votre business plan complet : un dossier de 30 pages haute qualité, livré en 48h à 7 jours.",
    ],
    "points" => [
      ["fa-magnifying-glass-chart", "Étude de marché et stratégie commerciale", "Analyse de votre marché, de vos concurrents et de vos clients cibles, avec la stratégie commerciale pour les atteindre."],
      ["fa-chart-line", "Prévisionnel financier sur 3 ou 5 ans", "Compte de résultat, bilan, plan de trésorerie et seuil de rentabilité : les chiffres que la banque attend. Option : prévisionnel financier seul dès 150 €."],
      ["fa-file-lines", "Mise en page professionnelle", "Un dossier clair et soigné, prêt à être présenté aux investisseurs, aux banques et aux organismes d'aide."],
    ],
  ];
  include "inc/partials/intro.php";

  $features = [
    "kicker" => "Création de société — dès 200 € + frais",
    "titre" => "Gagnez du temps, évitez les erreurs juridiques",
    "texte" => "Secteurs : VTC, BTP, restauration, e-commerce, professions libérales, etc.",
    "sombre" => true,
    "items" => [
      ["fa-file-signature", "Rédaction des statuts", "SASU, SARL, EURL ou micro-entreprise : nous choisissons avec vous la forme adaptée et rédigeons les statuts."],
      ["fa-stamp", "Immatriculation", "Greffe, Chambre des métiers, annonce au Journal officiel : nous constituons et déposons le dossier jusqu'à l'obtention du Kbis."],
      ["fa-hand-holding-dollar", "Aide aux aides", "ACRE, ARCE : nous montons vos dossiers d'aides pour alléger vos charges au démarrage."],
    ],
  ];
  include "inc/partials/features.php";

  $chiffres = [["95 %", "de dossiers validés"], ["30 pages", "de business plan"], ["48h – 7j", "livraison express"], ["Gratuit", "le devis et le premier échange"]];
  include "inc/partials/stats.php";

  $tarifs = [
    "titre" => "Pack Lancement & Financement",
    "texte" => "Objectif : obtenir le Kbis et l'accord de la banque.",
    "offres" => [
      ["nom" => "Prévisionnel financier", "prix" => "150 €", "periode" => "", "details" => ["Compte de résultat", "Bilan prévisionnel", "Plan de trésorerie", "Seuil de rentabilité"]],
      ["nom" => "Business plan complet", "prix" => "299 €", "periode" => "", "vedette" => true, "details" => ["Dossier de 30 pages haute qualité", "Étude de marché & stratégie commerciale", "Prévisionnel financier 3 ou 5 ans", "Mise en page pour investisseurs"]],
      ["nom" => "Création de société", "prix" => "200 €", "periode" => "+ frais", "details" => ["Rédaction des statuts", "Immatriculation (greffe, CMA, JO)", "Aide aux aides ACRE / ARCE", "Obtention du Kbis"]],
    ],
  ];
  include "inc/partials/pricing.php";

  $cta_titre = "Contactez-nous pour un devis gratuit";
  $cta_image = "public/Assets/images/entreprise/vtc3.png";
  include "inc/partials/cta.php";
?>
