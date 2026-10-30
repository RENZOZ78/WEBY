<?php

  /**
   * Filtre anti-spam du formulaire de contact, en plus du champ piege invisible :
   *  - le formulaire porte l'heure de son affichage, signee avec le jeton anti-CSRF de la session :
   *    un envoi moins de DELAI_MINIMUM secondes apres l'affichage (ou sans heure valable) est refuse ;
   *  - un message contenant du code de lien, plus de MAX_LIENS liens ou des formules de demarchage
   *    (vente de trafic, de liens, casino, crypto…) est refuse.
   */
  class AntiSpam{

    private const DELAI_MINIMUM = 3;
    private const MAX_LIENS = 2;

    //formules de demarchage en anglais (mots entiers) : "SEO" seul n'en fait pas partie, c'est une prestation de l'agence
    private const FORMULES = '/\b(traffic|backlinks?|guest ?posts?|link ?building|seo services|rank (your|you) (website|site)|first page (of|on) google|google first page|crypto(currency)?|bitcoin|forex|casino|viagra|cialis|porn|loan offer|unsubscribe|opt[ -]out)\b/i';

    //valeur du champ cache "ouverture" du formulaire : heure d'affichage signee
    public static function jetonOuverture(){
      $t = time();
      return $t.".".hash_hmac("sha256", "contact|".$t, Securite::csrfToken());
    }

    //raison du refus (texte court pour le journal), null si le message peut etre enregistre
    public static function motif($jeton, $nom, $sujet, $message){
      $parties = explode(".", (string)$jeton);
      if(count($parties) !== 2 || !ctype_digit($parties[0])
        || !hash_equals(hash_hmac("sha256", "contact|".$parties[0], Securite::csrfToken()), $parties[1])){
        return "formulaire sans heure d'ouverture valable";
      }
      if(time() - (int)$parties[0] < self::DELAI_MINIMUM) return "envoyé moins de ".self::DELAI_MINIMUM." s après l'ouverture";
      $texte = $nom."\n".$sujet."\n".$message;
      if(preg_match('/<a\s|\[url|\[link/i', $texte)) return "code de lien dans le message";
      if(preg_match_all('/https?:\/\/|www\./i', $texte) > self::MAX_LIENS) return "plus de ".self::MAX_LIENS." liens";
      if(preg_match(self::FORMULES, $texte, $trouve)) return "formule de démarchage « ".mb_strtolower($trouve[0])." »";
      return null;
    }
  }

 ?>
