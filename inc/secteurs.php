<?php
  /* Métiers accompagnés : bandeau défilant de l'accueil et pages secteurs/{slug}
   * Pour chaque métier :
   *  - nom, icone (Font Awesome), couleur (gold, cyan ou violet), qui (professions concernées)
   *  - titre et accroche : en-tête de la page du métier
   *  - problemes : [icone, titre court, explication] — les 3 premiers titres sont repris sur la carte du bandeau
   *  - solutions : [icone, titre, texte, prestation (lancement, gestion, sites ou marketing)]
   *  - gains : [icone, titre, texte] */
  return [
    "vtc" => [
      "nom" => "VTC & transport",
      "icone" => "fa-taxi",
      "couleur" => "gold",
      "qui" => "Chauffeurs VTC, taxis, ambulanciers, transport de personnes et de marchandises",
      "titre" => "Chauffeurs VTC : remplissez votre agenda sans dépendre des plateformes",
      "accroche" => "Clients en direct, factures propres pour les entreprises, financement du véhicule : nous vous aidons à rouler pour vous, pas pour une application.",
      "problemes" => [
        ["fa-mobile-screen", "Trop dépendant des plateformes", "Commissions élevées, courses imposées, compte suspendu du jour au lendemain : votre revenu dépend d'une application."],
        ["fa-user-group", "Pas de clientèle en direct", "Hôtels, entreprises, clients réguliers : ces courses rentables ne vous trouvent pas, faute de site et de fiche Google."],
        ["fa-file-invoice", "Factures faites le soir, à la main", "Les clients professionnels veulent une facture propre à chaque course ; vous la faites après dix heures de route."],
        ["fa-building-columns", "Financer le véhicule", "Achat ou location longue durée, statut à choisir : sans dossier solide, la banque hésite."],
      ],
      "solutions" => [
        ["fa-laptop-code", "Site avec réservation", "Vos tarifs, vos zones, vos véhicules et un formulaire de réservation : vos clients vous réservent en direct, sans commission.", "sites"],
        ["fa-magnifying-glass", "Visible sur Google", "Fiche Google, référencement local « VTC + votre ville », avis clients : vous apparaissez quand on cherche un chauffeur.", "marketing"],
        ["fa-file-invoice-dollar", "Devis et factures pros", "Des modèles de devis et de factures à votre nom, prêts à envoyer aux entreprises et aux hôtels.", "gestion"],
        ["fa-file-lines", "Business plan & création", "Prévisionnel pour financer le véhicule, choix du statut et création de votre société.", "lancement"],
      ],
      "gains" => [
        ["fa-hand-holding-dollar", "Plus de marge par course", "Chaque réservation directe, c'est la commission de la plateforme qui reste dans votre poche."],
        ["fa-calendar-check", "Un agenda plus régulier", "Des clients fidèles qui vous rappellent : moins d'attente entre deux courses."],
        ["fa-briefcase", "Une image de professionnel", "Site, factures, logo : entreprises et hôtels vous confient plus facilement leurs clients."],
      ],
    ],

    "btp" => [
      "nom" => "BTP & artisans",
      "icone" => "fa-helmet-safety",
      "couleur" => "gold",
      "qui" => "Maçons, plombiers, électriciens, peintres, menuisiers, entreprises de rénovation",
      "titre" => "Artisans du bâtiment : moins de paperasse, plus de chantiers rentables",
      "accroche" => "Devis, factures, salariés, visibilité : nous prenons en charge ce qui vous éloigne du chantier, pour que vous fassiez ce que vous savez faire.",
      "problemes" => [
        ["fa-file-pen", "Les devis prennent vos soirées", "Vous chiffrez le soir et le week-end, et une bonne partie des devis restent sans réponse."],
        ["fa-hourglass-half", "Paiements en retard", "Acomptes oubliés, relances qui ne partent pas : vous avancez le matériel et attendez d'être payé."],
        ["fa-user-plus", "Embaucher fait peur", "Contrats, déclaration d'embauche, fiches de paie : la paperasse d'un premier salarié ou d'un apprenti freine votre croissance."],
        ["fa-ear-listen", "Seulement le bouche-à-oreille", "Pas de site, pas de photos de chantiers : les clients qui cherchent sur Google trouvent vos concurrents."],
      ],
      "solutions" => [
        ["fa-file-invoice-dollar", "Devis et factures pros", "Des devis clairs, à votre image, avec acomptes et conditions de paiement : vous signez plus vite et vous êtes payé plus vite.", "gestion"],
        ["fa-users", "Gestion RH & paie", "Contrats, déclarations d'embauche, fiches de paie, entrées et sorties : nous gérons vos salariés et vos apprentis, à la carte.", "gestion"],
        ["fa-laptop-code", "Site vitrine avec vos chantiers", "Vos réalisations en photos avant / après, votre zone d'intervention et une demande de devis en ligne.", "sites"],
        ["fa-location-dot", "Des clients près de chez vous", "Référencement local, fiche Google et avis clients pour être trouvé dans votre secteur.", "marketing"],
      ],
      "gains" => [
        ["fa-moon", "Vos soirées libérées", "Les devis et les factures sont prêts plus vite : vous rentrez chez vous à l'heure."],
        ["fa-scale-balanced", "Une trésorerie plus sereine", "Acomptes demandés, factures envoyées et relancées : l'argent rentre au bon moment."],
        ["fa-hand-pointer", "Des chantiers mieux choisis", "Plus de demandes entrantes : vous gardez les chantiers rentables."],
      ],
    ],

    "restauration" => [
      "nom" => "Restauration",
      "icone" => "fa-utensils",
      "couleur" => "cyan",
      "qui" => "Restaurants, food trucks, traiteurs, boulangeries, snacks et métiers de bouche",
      "titre" => "Restaurateurs : une salle pleine et des commandes sans commission",
      "accroche" => "Carte en ligne, commande à emporter, réseaux sociaux, gestion du personnel : nous vous aidons à remplir vos services sans y passer vos nuits.",
      "problemes" => [
        ["fa-motorcycle", "Commissions des applis de livraison", "Les plateformes de livraison prélèvent une grosse part de chaque commande à emporter."],
        ["fa-star-half-stroke", "Les avis en ligne font la loi", "Une fiche Google incomplète ou quelques mauvais avis, et les clients passent devant sans entrer."],
        ["fa-user-clock", "Extras, plannings et paie", "Saisonniers, extras, heures supplémentaires : la gestion du personnel vous prend un temps fou."],
        ["fa-store", "Ouvrir ou reprendre un établissement", "Fonds de commerce, travaux, matériel : il faut convaincre la banque avec des chiffres solides."],
      ],
      "solutions" => [
        ["fa-laptop-code", "Site avec carte et commande en ligne", "Votre carte, vos horaires, la réservation de table et la vente à emporter sur votre propre site.", "sites"],
        ["fa-hashtag", "Réseaux sociaux & image", "Photos de plats, publications régulières, identité visuelle : donnez envie avant la première bouchée.", "marketing"],
        ["fa-users", "Gestion du personnel", "Contrats, extras, fiches de paie, entrées et sorties : nous gérons votre équipe à la carte.", "gestion"],
        ["fa-file-lines", "Business plan pour la banque", "Étude de marché locale et prévisionnel pour financer l'ouverture ou la reprise.", "lancement"],
      ],
      "gains" => [
        ["fa-bag-shopping", "Des commandes sans commission", "La vente à emporter passe par votre site : la marge reste chez vous."],
        ["fa-chair", "Une salle plus remplie", "Visible sur Google et Instagram au moment où l'on cherche où manger."],
        ["fa-kitchen-set", "Du temps en cuisine, pas au bureau", "La paie et les contrats sont faits : vous vous concentrez sur vos clients."],
      ],
    ],

    "commerce" => [
      "nom" => "Commerce de proximité",
      "icone" => "fa-shop",
      "couleur" => "cyan",
      "qui" => "Boutiques, fleuristes, épiceries fines, cavistes, magasins indépendants",
      "titre" => "Commerçants : faites venir les clients du quartier… et d'internet",
      "accroche" => "Vos clients comparent en ligne avant de pousser la porte. Nous vous rendons visible, nous vous aidons à vendre en ligne et à faire revenir vos habitués.",
      "problemes" => [
        ["fa-person-walking", "Moins de passage en boutique", "Les clients regardent en ligne avant de se déplacer : si vous n'y êtes pas, ils vont ailleurs."],
        ["fa-building", "Face aux grandes enseignes", "Difficile de faire valoir votre conseil et vos produits face aux prix des géants du web."],
        ["fa-hourglass-end", "Pas le temps de communiquer", "Entre la caisse, les commandes et les livraisons, Instagram et Facebook passent toujours après."],
        ["fa-rotate-left", "Des clients qui ne reviennent pas", "Vos habitués ne sont prévenus ni des nouveautés, ni des promotions."],
      ],
      "solutions" => [
        ["fa-cart-shopping", "Boutique en ligne & retrait en magasin", "Vos produits en ligne, réservés ou payés sur le site et retirés en boutique.", "sites"],
        ["fa-location-dot", "Fiche Google et référencement local", "Horaires à jour, photos, avis clients : vous apparaissez quand on cherche près de chez vous.", "marketing"],
        ["fa-hashtag", "Réseaux sociaux simplifiés", "Un calendrier de publications, des visuels prêts à poster et des campagnes ciblées autour de votre boutique.", "marketing"],
        ["fa-magnifying-glass-chart", "Audit de votre activité", "Offre, prix, vitrine, concurrence : un plan d'action concret pour vendre plus et plus cher.", "marketing"],
      ],
      "gains" => [
        ["fa-door-open", "Plus de monde en boutique", "Des clients qui vous ont trouvé en ligne et qui viennent acheter."],
        ["fa-moon", "Des ventes même fermé", "Votre boutique en ligne vend le soir et le dimanche."],
        ["fa-heart", "Des clients qui reviennent", "Une communication régulière qui entretient le lien avec vos habitués."],
      ],
    ],

    "e-commerce" => [
      "nom" => "E-commerce",
      "icone" => "fa-cart-shopping",
      "couleur" => "violet",
      "qui" => "Boutiques en ligne, créateurs, marques, vendeurs sur les places de marché",
      "titre" => "E-commerçants : transformez vos visiteurs en clients",
      "accroche" => "Un site rapide et rassurant, des fiches produits trouvées sur Google et une publicité qui rapporte plus qu'elle ne coûte.",
      "problemes" => [
        ["fa-arrow-right-from-bracket", "Des visites, peu de ventes", "Les visiteurs arrivent, regardent et repartent : site lent, achat compliqué, confiance insuffisante."],
        ["fa-money-bill-trend-up", "Une publicité qui coûte trop cher", "Vous payez des campagnes sans savoir lesquelles vous apportent vraiment des clients."],
        ["fa-link", "Dépendant des places de marché", "Commissions, règles qui changent, clients qui ne sont pas les vôtres."],
        ["fa-eye-slash", "Invisible sur Google", "Des fiches produits sans texte travaillé : vos produits ne remontent pas dans les recherches."],
      ],
      "solutions" => [
        ["fa-gauge-high", "Site e-commerce rapide et rassurant", "Catalogue, panier, paiement sécurisé, parfaitement lisible sur mobile : un achat simple en quelques clics.", "sites"],
        ["fa-magnifying-glass", "Fiches produits référencées", "Textes, titres et pages optimisés pour que vos produits soient trouvés sur Google.", "sites"],
        ["fa-bullseye", "Acquisition clients", "Campagnes ciblées, suivies et ajustées : vous savez ce que rapporte chaque euro investi.", "marketing"],
        ["fa-gem", "Image de marque", "Logo, ton, visuels : une marque reconnaissable qui justifie vos prix.", "marketing"],
      ],
      "gains" => [
        ["fa-cart-arrow-down", "Plus de paniers validés", "Un parcours d'achat fluide qui rassure et qui convertit."],
        ["fa-address-book", "Vos propres clients", "Des acheteurs qui reviennent chez vous, pas sur une place de marché."],
        ["fa-sliders", "Des dépenses publicitaires maîtrisées", "Vous gardez ce qui rapporte et vous coupez le reste."],
      ],
    ],

    "beaute" => [
      "nom" => "Beauté & bien-être",
      "icone" => "fa-spa",
      "couleur" => "violet",
      "qui" => "Coiffeurs, barbiers, esthéticiennes, prothésistes ongulaires, praticiens du bien-être",
      "titre" => "Beauté & bien-être : un agenda plein, sans répondre au téléphone",
      "accroche" => "Réservation en ligne, réseaux sociaux qui montrent votre travail, tarifs assumés : nous vous aidons à remplir votre salon et à gagner mieux votre vie.",
      "problemes" => [
        ["fa-phone-volume", "Le téléphone sonne en pleine prestation", "Vous décrochez les mains occupées, ou vous ratez l'appel… et la cliente."],
        ["fa-camera", "Instagram, faute de temps", "Vos réalisations attirent des clients, mais vous n'avez jamais le temps de publier."],
        ["fa-tags", "Des prix difficiles à augmenter", "Vous hésitez à revoir vos tarifs de peur de perdre votre clientèle."],
        ["fa-key", "Ouvrir son propre salon", "Local, matériel, statut : se mettre à son compte demande un dossier solide."],
      ],
      "solutions" => [
        ["fa-calendar-days", "Site avec prise de rendez-vous", "Vos prestations, vos tarifs et un agenda en ligne : vos clients réservent à toute heure.", "sites"],
        ["fa-hashtag", "Réseaux sociaux & image", "Identité visuelle, idées de publications, mise en valeur de vos réalisations.", "marketing"],
        ["fa-magnifying-glass-chart", "Audit et positionnement", "Offre, tarifs, concurrence locale : un plan clair pour vendre plus et plus cher.", "marketing"],
        ["fa-file-lines", "Business plan & création", "Prévisionnel, choix du statut et création de votre société pour ouvrir votre salon.", "lancement"],
      ],
      "gains" => [
        ["fa-calendar-check", "Un agenda qui se remplit", "Les réservations arrivent en ligne, même quand vous êtes occupé."],
        ["fa-hand-sparkles", "Plus de temps pour vos clients", "Moins d'appels à gérer, plus d'attention pendant la prestation."],
        ["fa-gem", "Une image qui vous ressemble", "Un univers reconnaissable qui attire la clientèle que vous visez."],
      ],
    ],

    "professions-liberales" => [
      "nom" => "Professions libérales",
      "icone" => "fa-user-tie",
      "couleur" => "gold",
      "qui" => "Consultants, coachs, avocats, architectes, thérapeutes, professions de santé",
      "titre" => "Professions libérales : votre expertise mérite d'être vue",
      "accroche" => "Une présence en ligne sérieuse, dans le respect des règles de votre profession, et un administratif allégé pour consacrer vos heures à vos clients.",
      "problemes" => [
        ["fa-eye-slash", "Votre expertise ne se voit pas", "Sans site ni présence professionnelle, un prospect ne peut pas juger de votre sérieux avant d'appeler."],
        ["fa-scale-balanced", "Communiquer sans faux pas", "Certaines professions encadrent strictement la publicité : difficile de savoir ce qui est permis."],
        ["fa-clock", "L'administratif mange vos heures", "Devis, factures, relances, documents clients : des heures non facturées chaque semaine."],
        ["fa-sitemap", "Choisir le bon statut", "Micro-entreprise, EURL, SASU… le choix change vos charges et votre protection."],
      ],
      "solutions" => [
        ["fa-laptop-code", "Site professionnel sobre et sérieux", "Votre parcours, vos domaines d'intervention et une prise de contact simple, dans le respect des règles de votre profession.", "sites"],
        ["fa-magnifying-glass", "Trouvé sur votre spécialité", "Être visible sur « votre métier + votre ville » auprès des personnes qui ont besoin de vous.", "sites"],
        ["fa-file-invoice-dollar", "Devis, factures et suivi", "Des documents pros, envoyés et relancés à temps.", "gestion"],
        ["fa-stamp", "Création de votre structure", "Comparaison des statuts, rédaction des statuts, immatriculation et aides ACRE / ARCE.", "lancement"],
      ],
      "gains" => [
        ["fa-handshake", "Des prospects déjà convaincus", "Ils ont lu votre parcours avant de vous appeler : le premier rendez-vous va plus vite."],
        ["fa-hourglass-half", "Plus d'heures facturables", "Moins de temps sur la paperasse, plus de temps avec vos clients."],
        ["fa-award", "Une image à la hauteur", "Une présence en ligne qui reflète la qualité de votre travail."],
      ],
    ],

    "immobilier" => [
      "nom" => "Immobilier",
      "icone" => "fa-house",
      "couleur" => "cyan",
      "qui" => "Agents et mandataires immobiliers, agences, gestionnaires de biens",
      "titre" => "Immobilier : devenez la référence de votre secteur",
      "accroche" => "Plus de mandats, moins de dépendance aux portails d'annonces : un site d'agence, une marque locale et une présence régulière qui rassurent les vendeurs.",
      "problemes" => [
        ["fa-file-signature", "Rentrer des mandats", "Les vendeurs vont vers les grands réseaux : il faut prouver votre connaissance du quartier."],
        ["fa-money-check-dollar", "Dépendant des portails d'annonces", "Abonnements coûteux, contacts partagés avec toutes les agences du coin."],
        ["fa-clone", "Des annonces qui se ressemblent", "Photos moyennes, textes génériques : vos biens ne se démarquent pas."],
        ["fa-person-walking-arrow-right", "Se lancer à son compte", "Mandataire indépendant ou nouvelle agence : statut, aides et prévisionnel à préparer."],
      ],
      "solutions" => [
        ["fa-laptop-code", "Site d'agence avec vos biens", "Vos annonces mises en valeur et une demande d'estimation en ligne, comme le site Delta-Immo que nous avons réalisé.", "sites"],
        ["fa-location-dot", "Référencement local", "Être trouvé sur Google par les vendeurs de votre ville ou de votre quartier.", "marketing"],
        ["fa-hashtag", "Réseaux sociaux & marque", "Biens à la une, ventes réalisées, conseils : une présence régulière qui inspire confiance.", "marketing"],
        ["fa-stamp", "Création & aides au démarrage", "Création de votre structure, dossiers ACRE / ARCE et prévisionnel.", "lancement"],
      ],
      "gains" => [
        ["fa-envelope-open-text", "Plus de demandes d'estimation", "Des vendeurs qui vous contactent directement depuis votre site."],
        ["fa-unlock", "Moins de dépendance aux portails", "Vos contacts sont à vous, pas partagés avec la concurrence."],
        ["fa-medal", "Une marque locale reconnue", "Le nom qu'on cite quand on parle d'immobilier dans votre secteur."],
      ],
    ],

    "sport" => [
      "nom" => "Sport & coaching",
      "icone" => "fa-dumbbell",
      "couleur" => "gold",
      "qui" => "Salles de sport, coachs sportifs, studios de yoga, de danse ou de pilates, clubs",
      "titre" => "Sport & coaching : des inscriptions toute l'année, pas seulement en septembre",
      "accroche" => "Site avec vos cours et vos formules, campagnes d'inscription, contenu qui donne envie : nous vous aidons à recruter et à garder vos adhérents.",
      "problemes" => [
        ["fa-chart-line", "Des inscriptions en dents de scie", "Les nouveaux adhérents arrivent en janvier et en septembre, et le reste de l'année c'est calme."],
        ["fa-person-running", "Des adhérents qui décrochent", "Sans suivi ni communication, les abonnés s'arrêtent au bout de quelques mois."],
        ["fa-comments", "Plannings gérés par messages", "Cours, séances individuelles, essais gratuits : tout passe par téléphone et messagerie."],
        ["fa-dumbbell", "Face aux grandes chaînes", "Difficile d'expliquer en quoi votre accompagnement est différent."],
      ],
      "solutions" => [
        ["fa-laptop-code", "Site avec planning et formules", "Vos cours, vos tarifs et une demande de séance d'essai en ligne. Nous avons réalisé le site de la salle Fiteos.", "sites"],
        ["fa-bullseye", "Campagnes d'inscription", "Offres de rentrée, parrainage, publicité locale ciblée : des inscriptions tout au long de l'année.", "marketing"],
        ["fa-hashtag", "Réseaux sociaux & image", "Coulisses, conseils, progrès des adhérents : du contenu qui donne envie de venir.", "marketing"],
        ["fa-users", "Gestion des coachs et salariés", "Contrats, fiches de paie et facturation gérés pour vous.", "gestion"],
      ],
      "gains" => [
        ["fa-calendar-plus", "Des inscriptions toute l'année", "Des actions régulières plutôt que deux pics par an."],
        ["fa-heart-pulse", "Des adhérents fidèles", "Une communication qui entretient la motivation et l'envie de revenir."],
        ["fa-stopwatch", "Plus de temps sur le terrain", "Moins de messages et de paperasse, plus de temps avec vos adhérents."],
      ],
    ],

    "services-a-la-personne" => [
      "nom" => "Services à la personne",
      "icone" => "fa-hand-holding-heart",
      "couleur" => "violet",
      "qui" => "Ménage, aide à domicile, garde d'enfants, jardinage, petits travaux",
      "titre" => "Services à la personne : inspirez confiance avant même le premier appel",
      "accroche" => "Vos clients vous ouvrent leur porte : nous vous aidons à être trouvé près de chez eux, à rassurer et à gérer vos intervenants sans y passer vos soirées.",
      "problemes" => [
        ["fa-house-user", "Trouver des clients réguliers", "Les familles cherchent quelqu'un de confiance près de chez elles et passent souvent par des plateformes."],
        ["fa-shield-heart", "Rassurer avant de vous ouvrir la porte", "Sans avis ni présentation sérieuse, le client hésite à faire entrer quelqu'un chez lui."],
        ["fa-people-arrows", "Plannings et intervenants", "Remplacements, heures variables, plusieurs clients par jour : la paie devient un casse-tête."],
        ["fa-receipt", "Un avantage fiscal mal expliqué", "Quand votre activité y ouvre droit, l'avantage fiscal de vos clients reste un argument de vente sous-exploité."],
      ],
      "solutions" => [
        ["fa-laptop-code", "Site rassurant et local", "Vos services, vos zones, vos tarifs, les avis de vos clients et une demande de devis simple.", "sites"],
        ["fa-location-dot", "Fiche Google et avis", "Être trouvé dans votre ville et afficher la satisfaction de vos clients.", "marketing"],
        ["fa-users", "Gestion RH & paie", "Contrats, fiches de paie, entrées et sorties de vos intervenants gérés à la carte.", "gestion"],
        ["fa-file-invoice-dollar", "Devis et factures clairs", "Des documents nets, avec les mentions utiles à vos clients.", "gestion"],
      ],
      "gains" => [
        ["fa-map-location-dot", "Des clients près de chez vous", "Moins de route entre deux interventions, plus d'heures travaillées."],
        ["fa-handshake-angle", "La confiance dès le départ", "Votre sérieux se voit avant le premier rendez-vous."],
        ["fa-feather", "Une gestion allégée", "La paie et les factures ne vous prennent plus vos soirées."],
      ],
    ],

    "hotellerie-tourisme" => [
      "nom" => "Hôtellerie & tourisme",
      "icone" => "fa-bed",
      "couleur" => "cyan",
      "qui" => "Gîtes, chambres d'hôtes, petits hôtels, locations saisonnières, activités touristiques",
      "titre" => "Hébergements et tourisme : plus de réservations en direct, toute l'année",
      "accroche" => "Moins de commissions, des périodes creuses mieux remplies, une saison mieux organisée : nous vous aidons à vendre vos nuits et vos activités vous-même.",
      "problemes" => [
        ["fa-percent", "Les commissions des plateformes", "Chaque nuit réservée par une plateforme vous coûte une part importante du prix."],
        ["fa-snowflake", "Complet l'été, vide l'hiver", "La saisonnalité rend le chiffre d'affaires difficile à prévoir."],
        ["fa-image", "Des photos qui ne vendent pas", "Des visuels et des descriptions qui ne donnent pas envie de réserver chez vous plutôt qu'à côté."],
        ["fa-people-carry-box", "La haute saison déborde", "Saisonniers, contrats, factures : l'administratif s'accumule au pire moment."],
      ],
      "solutions" => [
        ["fa-laptop-code", "Site avec réservation en direct", "Vos chambres ou vos activités, vos disponibilités et une demande de réservation sur votre propre site.", "sites"],
        ["fa-magnifying-glass", "Visible auprès des voyageurs", "Référencement et fiche Google pour être trouvé par ceux qui préparent leur séjour dans votre région.", "marketing"],
        ["fa-bullseye", "Campagnes hors saison", "Week-ends, séminaires, événements : des offres ciblées pour remplir les périodes creuses.", "marketing"],
        ["fa-users", "Gestion des saisonniers", "Contrats, déclarations et fiches de paie de vos équipes de saison.", "gestion"],
      ],
      "gains" => [
        ["fa-hand-holding-dollar", "Plus de réservations directes", "La commission reste chez vous, et le client aussi."],
        ["fa-chart-area", "Un remplissage plus régulier", "Des actions ciblées sur les périodes creuses."],
        ["fa-umbrella-beach", "Une saison plus sereine", "L'administratif est géré : vous vous occupez de vos hôtes."],
      ],
    ],

    "start-up" => [
      "nom" => "Sociétés & start-up",
      "icone" => "fa-rocket",
      "couleur" => "gold",
      "qui" => "Porteurs de projet, jeunes sociétés, start-up, PME en croissance",
      "titre" => "Porteurs de projet et start-up : lancez-vous sur des bases solides",
      "accroche" => "Business plan qui convainc, société créée sans erreur, premiers clients : nous vous accompagnons de l'idée au chiffre d'affaires.",
      "problemes" => [
        ["fa-building-columns", "Convaincre banque et investisseurs", "Sans prévisionnel crédible, le prêt ou la levée de fonds n'avance pas."],
        ["fa-scale-unbalanced", "Le juridique au démarrage", "Forme de société, statuts, répartition du capital : les erreurs du début coûtent cher ensuite."],
        ["fa-bullhorn", "Trouver ses premiers clients", "Le produit est prêt, mais personne ne le connaît encore."],
        ["fa-battery-quarter", "Tout faire en même temps", "Produit, ventes, recrutement, administratif : les fondateurs s'épuisent hors de leur cœur de métier."],
      ],
      "solutions" => [
        ["fa-file-lines", "Business plan professionnel", "Étude de marché, stratégie, prévisionnel sur 3 ou 5 ans et mise en page pour les investisseurs.", "lancement"],
        ["fa-stamp", "Création de société", "Statuts, immatriculation, Journal officiel, Kbis et aides ACRE / ARCE.", "lancement"],
        ["fa-laptop-code", "Site & image de marque", "Un site et une identité qui donnent confiance dès le lancement.", "sites"],
        ["fa-users-viewfinder", "Acquisition des premiers clients", "Audit, positionnement et campagnes pour trouver vos premiers clients rapidement.", "marketing"],
      ],
      "gains" => [
        ["fa-file-circle-check", "Un dossier qui rassure", "Banque, investisseurs, organismes d'aide : des chiffres clairs et argumentés."],
        ["fa-bolt", "Un lancement plus rapide", "Le business plan et la société livrés en 48h à 7 jours."],
        ["fa-lightbulb", "Votre énergie sur votre produit", "Gestion, site et marketing pris en charge par une seule agence."],
      ],
    ],
  ];
