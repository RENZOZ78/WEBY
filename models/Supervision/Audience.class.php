<?php
  require_once(__DIR__."/../Model.class.php");

  /**
   * Mesure d'audience interne (supervision du super administrateur), sans outil externe ni cookie de mesure.
   * Une ligne par page publique vue (table pages_vues), envoyee par le navigateur une fois la page affichee,
   * et une ligne par clic sur le telephone, le mail ou WhatsApp (table clics_contact).
   * Aucune adresse IP n'est conservee : le visiteur est une empreinte anonyme (IP + navigateur + jour + sel secret)
   * qui change chaque jour.
   * Ne sont pas comptes : les robots (declares ou sans JavaScript), les visites venues de sites de spam,
   * les administrateurs et les pages privees (espace client, administration).
   */
  class Audience extends Model{

    private const SEL = "storage/.sel";
    //duree de conservation des visites et du journal
    public const CONSERVATION_JOURS = 400;

    //nom lisible des pages publiques
    public const PAGES = [
      "accueils" => "Accueil",
      "prestations/lancement" => "Lancement & financement",
      "prestations/gestion" => "Gestion & administratif",
      "prestations/sites" => "Site internet",
      "prestations/marketing" => "Marketing & croissance",
      "contact" => "Contact",
      "login" => "Connexion",
      "creerCompte" => "Création de compte",
    ];

    //sources de trafic reconnues (domaine du site d'origine => nom)
    private const SOURCES = [
      "google" => "Google", "bing" => "Bing", "qwant" => "Qwant", "duckduckgo" => "DuckDuckGo", "ecosia" => "Ecosia",
      "yahoo" => "Yahoo", "instagram" => "Instagram", "facebook" => "Facebook", "fb" => "Facebook",
      "leboncoin" => "Leboncoin", "linkedin" => "LinkedIn", "lnkd" => "LinkedIn", "t.co" => "X (Twitter)",
      "twitter" => "X (Twitter)", "x.com" => "X (Twitter)", "tiktok" => "TikTok", "youtube" => "YouTube",
      "pinterest" => "Pinterest", "whatsapp" => "WhatsApp", "chatgpt" => "ChatGPT", "perplexity" => "Perplexity",
    ];

    private const ROBOTS = '/bot|crawl|spider|slurp|preview|monitor|scan|curl|wget|python|java\/|go-http|headless|lighthouse|pingdom|uptime|facebookexternalhit|semrush|ahrefs/i';

    //sites de spam de referent : des robots visitent le site en se faisant passer pour ces sites (visite non comptee)
    private const SOURCES_SPAM = '/addurl|linkbuilding|backlink|traffic|trafic|seo-|-seo|onoda-|five\.co\.in|wnnkd|semalt|buttons-for|best-seo|free-share/i';

    //clics de contact mesures (type envoye par le navigateur => libelle)
    public const CLICS = ["telephone" => "Téléphone", "mail" => "Mail", "whatsapp" => "WhatsApp"];

    //duree de validite du jeton de mesure (onglet laisse ouvert avant un clic sur le telephone)
    private const VALIDITE_JETON = 12 * 3600;

    //jeton de la page en cours, insere dans la page par le gabarit (null : page non mesuree)
    private static $jeton = null;

    //categories des pages servies (table pages_servies) => libelle affiche dans la supervision
    public const CATEGORIES_ROBOTS = [
      "robot" => "Robots déclarés",
      "spam" => "Spam de provenance",
      "navigateur" => "Robots déguisés (sans JavaScript)",
    ];

    //prepare la mesure de la page affichee (appele a la generation de chaque page) ; ne bloque jamais le site.
    //La page servie est notee dans pages_servies (robots compris, pour les compter a part) ; pour un navigateur,
    //la page contient un jeton signe que main.js renvoie une fois la page affichee : seule cette confirmation
    //compte une visite (pages_vues). Les robots qui n'executent pas le JavaScript ne sont donc pas comptes.
    public static function preparer(){
      try {
        self::$jeton = null;
        if(($_SERVER['REQUEST_METHOD'] ?? "GET") !== "GET" || http_response_code() !== 200) return;
        if(Securite::estAdministrateur() || Securite::estSuperAdministrateur()) return;
        $page = self::pageCourante();
        if($page === null) return;
        $agent = (string)($_SERVER['HTTP_USER_AGENT'] ?? "");
        $source = self::source();
        $categorie = ($agent === "" || preg_match(self::ROBOTS, $agent)) ? "robot" : (preg_match(self::SOURCES_SPAM, $source) ? "spam" : "navigateur");
        $stmt = (new self())->getBdd()->prepare("INSERT INTO pages_servies (page, visiteur, source, categorie) VALUES (?, ?, ?, ?)");
        $stmt->execute([$page, self::empreinte($agent), mb_substr($source, 0, 80), $categorie]);
        if($categorie !== "navigateur") return;
        $donnees = rtrim(strtr(base64_encode(json_encode(["p" => $page, "s" => $source, "t" => time()])), "+/", "-_"), "=");
        self::$jeton = $donnees.".".hash_hmac("sha256", $donnees, self::sel());
      } catch (Throwable $e) {
        error_log("Audience : ".$e->getMessage());
      }
    }

    public static function jeton(){
      return self::$jeton;
    }

    //reception d'une mesure envoyee par le navigateur (adresse "mesure", POST) : page vue ou clic de contact.
    //Repond toujours 204 sans contenu : un envoi refuse ne renseigne pas son auteur.
    public static function recevoir(){
      http_response_code(204);
      try {
        if(($_SERVER['REQUEST_METHOD'] ?? "") !== "POST" || !Securite::verifierCsrf() || !self::visiteurCompte()) return;
        $mesure = self::lireJeton((string)($_POST['jeton'] ?? ""));
        if($mesure === null) return;
        $type = (string)($_POST['type'] ?? "vue");
        $agent = (string)$_SERVER['HTTP_USER_AGENT'];
        $empreinte = self::empreinte($agent);
        $bdd = (new self())->getBdd();
        if($type === "vue"){
          //une seule page vue par jeton : un jeton rejoue (meme visiteur, meme page, meme seconde d'affichage) est ignore
          $cle = "mesure_".substr(hash("sha256", (string)$_POST['jeton']), 0, 16);
          if(isset($_SESSION[$cle])) return;
          $_SESSION[$cle] = 1;
          $stmt = $bdd->prepare("INSERT INTO pages_vues (page, visiteur, source, appareil, connecte) VALUES (?, ?, ?, ?, ?)");
          $stmt->execute([$mesure['p'], $empreinte, $mesure['s'], self::appareil($agent), Securite::estConnecte() ? 1 : 0]);
        }elseif(isset(self::CLICS[$type])){
          $stmt = $bdd->prepare("INSERT INTO clics_contact (type, page, visiteur, source, appareil) VALUES (?, ?, ?, ?, ?)");
          $stmt->execute([$type, $mesure['p'], $empreinte, $mesure['s'], self::appareil($agent)]);
        }else{
          return;
        }

        //purge occasionnelle des donnees anciennes
        if(random_int(1, 300) === 1){
          $limite = date("Y-m-d", strtotime("-".self::CONSERVATION_JOURS." days"));
          foreach(["pages_vues", "pages_servies", "clics_contact", "visites", "journal"] as $table){
            $bdd->prepare("DELETE FROM ".$table." WHERE created_at < ?")->execute([$limite]);
          }
        }
      } catch (Throwable $e) {
        error_log("Audience : ".$e->getMessage());
      }
    }

    //empreinte anonyme du visiteur (IP + navigateur + jour + sel secret), identique a la generation de la page
    //et a la confirmation du navigateur : c'est ce qui permet de reconnaitre les pages jamais confirmees
    private static function empreinte($agent){
      return substr(hash("sha256", ($_SERVER['REMOTE_ADDR'] ?? "")."|".$agent."|".date("Y-m-d")."|".self::sel()), 0, 16);
    }

    //visiteur a compter : navigateur declare (pas un robot connu), ni administrateur ni super administrateur
    private static function visiteurCompte(){
      if(Securite::estAdministrateur() || Securite::estSuperAdministrateur()) return false;
      $agent = (string)($_SERVER['HTTP_USER_AGENT'] ?? "");
      return $agent !== "" && !preg_match(self::ROBOTS, $agent);
    }

    //contenu d'un jeton signe et encore valable, sinon null
    private static function lireJeton($jeton){
      $parties = explode(".", $jeton);
      if(count($parties) !== 2 || !hash_equals(hash_hmac("sha256", $parties[0], self::sel()), $parties[1])) return null;
      $mesure = json_decode((string)base64_decode(strtr($parties[0], "-_", "+/")), true);
      if(!is_array($mesure) || !isset($mesure['p'], $mesure['s'], $mesure['t'])) return null;
      if(time() - (int)$mesure['t'] > self::VALIDITE_JETON) return null;
      return ["p" => mb_substr((string)$mesure['p'], 0, 120), "s" => mb_substr((string)$mesure['s'], 0, 80)];
    }

    //page publique courante (ex. "prestations/sites"), null pour une page privee
    private static function pageCourante(){
      $segments = array_values(array_filter(explode("/", trim((string)($_GET['page'] ?? ""), "/")), "strlen"));
      $page = $segments[0] ?? "accueils";
      if(in_array($page, ["compte", "administration", "supervision"], true)) return null;
      if(in_array($page, ["prestations", "secteurs"], true) && isset($segments[1])) $page .= "/".$segments[1];
      return mb_substr(preg_replace('/[^A-Za-z0-9_\/-]/', '', $page), 0, 120);
    }

    //source : parametre utm_source (liens Instagram, Leboncoin…) sinon site d'origine, sinon "direct"
    private static function source(){
      $utm = strtolower(preg_replace('/[^A-Za-z0-9_.-]/', '', (string)($_GET['utm_source'] ?? "")));
      if($utm !== "") return self::nomSource($utm);
      $hote = strtolower((string)parse_url((string)($_SERVER['HTTP_REFERER'] ?? ""), PHP_URL_HOST));
      $hote = preg_replace('/^(www|m|l|lm)\./', '', $hote);
      $site = preg_replace('/^www\./', '', strtolower((string)($_SERVER['HTTP_HOST'] ?? "")));
      if($hote === "" || $hote === $site) return "direct";
      return self::nomSource($hote);
    }

    private static function nomSource($valeur){
      foreach(self::SOURCES as $motif => $nom){
        if($valeur === $motif || strpos($valeur, $motif.".") === 0 || strpos($valeur, ".".$motif.".") !== false) return $nom;
      }
      return mb_substr($valeur, 0, 80);
    }

    private static function appareil($agent){
      if(preg_match('/iPad|Tablet|Kindle|Silk/i', $agent)) return "tablette";
      if(preg_match('/Mobi|Android|iPhone|iPod/i', $agent)) return "mobile";
      return "ordinateur";
    }

    //sel secret propre au serveur (fichier hors depot), cree au premier besoin
    private static function sel(){
      if(is_file(self::SEL)) return (string)file_get_contents(self::SEL);
      $sel = bin2hex(random_bytes(16));
      @file_put_contents(self::SEL, $sel);
      return $sel;
    }

    public static function nomPage($page){
      if(isset(self::PAGES[$page])) return self::PAGES[$page];
      if(strpos($page, "secteurs/") === 0){
        $secteurs = require "inc/secteurs.php";
        $slug = substr($page, 9);
        return "Métier : ".($secteurs[$slug]['nom'] ?? $slug);
      }
      return $page;
    }
  }
