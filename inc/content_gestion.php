<?php
  $intro = [
    "kicker" => "Gestion & administratif — à la carte",
    "titre" => "Libérez-vous du temps pour votre métier",
    "image" => "public/Assets/images/entreprise/brainstorming.png",
    "alt" => "Gestion administrative",
    "paragraphes" => [
      "Votre entreprise existe déjà et la paperasse vous prend un temps précieux ? Déléguez-nous les tâches administratives et concentrez-vous sur vos clients.",
      "Vous ne payez que ce dont vous avez besoin : chaque prestation se commande à l'unité ou en forfait mensuel.",
    ],
    "points" => [
      ["fa-users", "Ressources humaines — dès 30 €", "Contrats de travail, fiches de paie, déclarations d'embauche (DPAE), entrées et sorties de salariés, déclarations sociales (DSN)."],
      ["fa-file-invoice-dollar", "Facturation", "Création de vos devis et factures professionnels, aux normes, avec vos mentions légales et votre identité visuelle."],
      ["fa-folder-open", "Suivi dans votre espace client", "Chaque document que nous produisons est déposé dans votre espace client : vous le retrouvez à tout moment."],
    ],
  ];
  include "inc/partials/intro.php";

  $features = [
    "kicker" => "Pourquoi déléguer",
    "titre" => "Moins d'administratif, plus de chiffre d'affaires",
    "sombre" => true,
    "items" => [
      ["fa-clock", "Du temps récupéré", "Chaque heure passée sur la paie ou les contrats est une heure de moins pour vendre."],
      ["fa-shield-halved", "Zéro erreur", "Des documents conformes, à jour des obligations légales, livrés dans les délais."],
      ["fa-sliders", "À la carte", "Une fiche de paie ponctuelle ou un suivi mensuel complet : vous choisissez."],
    ],
  ];
  include "inc/partials/features.php";

  $tarifs = [
    "titre" => "Tarifs gestion & administratif",
    "texte" => "À l'unité ou en forfait, selon votre volume. Devis gratuit.",
    "offres" => [
      ["nom" => "RH à la carte", "prix" => "30 €", "periode" => "/ acte", "vedette" => true, "details" => ["Contrat de travail", "Fiche de paie", "Entrée de salarié (DPAE)", "Sortie de salarié & DSN"]],
      ["nom" => "Facturation", "prix" => "Sur devis", "periode" => "", "details" => ["Devis professionnels", "Factures aux normes", "Modèles à vos couleurs", "Relances clients"]],
      ["nom" => "Forfait mensuel", "prix" => "Sur devis", "periode" => "", "details" => ["Paie de vos salariés", "Déclarations sociales", "Facturation courante", "Interlocuteur dédié"]],
    ],
  ];
  include "inc/partials/pricing.php";

  $cta_titre = "Déléguez la paperasse, développez votre activité";
  include "inc/partials/cta.php";
?>
