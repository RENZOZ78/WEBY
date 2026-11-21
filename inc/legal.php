<?php
  /* Outils des pages légales (mentions-legales, confidentialite) et du pied de page.
   * Toutes les valeurs viennent de config/config.php ; une valeur obligatoire encore vide
   * s'affiche « à compléter » en évidence, pour qu'une page incomplète ne passe pas inaperçue. */

  if(!function_exists('legal_manquantes')){

    //valeurs obligatoires de l'identité légale : clé de config => libellé
    function legal_obligatoires(){
      return [
        "legal_nom" => "Raison sociale ou nom",
        "legal_forme" => "Forme juridique",
        "legal_siret" => "Numéro SIRET",
        "legal_adresse" => "Adresse",
        "legal_responsable" => "Responsable de la publication",
        "hebergeur_nom" => "Nom de l'hébergeur",
        "hebergeur_adresse" => "Adresse de l'hébergeur",
      ];
    }

    //libellés des valeurs obligatoires encore vides (tableau vide : tout est renseigné)
    function legal_manquantes($site){
      $manquantes = [];
      foreach(legal_obligatoires() as $cle => $libelle){
        if(trim((string)($site[$cle] ?? "")) === "") $manquantes[$cle] = $libelle;
      }
      return $manquantes;
    }

    //valeur de config prête à afficher (échappée), "" si vide
    function legal_texte($site, $cle){
      return htmlspecialchars(trim((string)($site[$cle] ?? "")));
    }

    //valeur obligatoire : la valeur, ou un repère « à compléter » bien visible
    function legal_valeur($site, $cle){
      $valeur = legal_texte($site, $cle);
      if($valeur !== "") return $valeur;
      $libelle = legal_obligatoires()[$cle] ?? $cle;
      return '<mark class="a-completer"><i class="fas fa-triangle-exclamation" aria-hidden="true"></i>À compléter : '
        .htmlspecialchars(mb_strtolower(mb_substr($libelle, 0, 1)).mb_substr($libelle, 1)).'</mark>';
    }

    //bandeau d'alerte en tête de page tant qu'il manque une valeur obligatoire
    function legal_alerte($site){
      $manquantes = legal_manquantes($site);
      if(empty($manquantes)) return "";
      $html = '<div class="legal-alerte" role="alert"><i class="fas fa-triangle-exclamation" aria-hidden="true"></i><div>'
        .'<strong>Page incomplète : à ne pas mettre en ligne en l\'état.</strong>'
        .'<p>'.count($manquantes).' information'.(count($manquantes) > 1 ? 's obligatoires manquent' : ' obligatoire manque')
        .'. À renseigner dans <code>config/config.php</code> :</p><ul>';
      foreach($manquantes as $cle => $libelle){
        $html .= '<li>'.htmlspecialchars($libelle).' <code>'.htmlspecialchars($cle).'</code></li>';
      }
      return $html.'</ul></div></div>';
    }
  }
