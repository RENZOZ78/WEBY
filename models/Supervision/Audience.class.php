<?php
  require_once(__DIR__."/../Model.class.php");

  /**
   * Mesure d'audience interne (supervision du super administrateur), sans outil externe ni cookie.
   * Une ligne par page publique vue. Aucune adresse IP n'est conservee : le visiteur est une empreinte
   * anonyme (IP + navigateur + jour + sel secret) qui change chaque jour.
   * Ne sont pas comptes : les robots, les administrateurs et les pages privees (espace client, administration).
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

    //enregistre la page affichee (appele a la generation de chaque page) ; ne bloque jamais le site
    public static function enregistrer(){
      try {
        if(($_SERVER['REQUEST_METHOD'] ?? "GET") !== "GET" || http_response_code() !== 200) return;
        if(Securite::estAdministrateur() || Securite::estSuperAdministrateur()) return;
        $agent = (string)($_SERVER['HTTP_USER_AGENT'] ?? "");
        if($agent === "" || preg_match(self::ROBOTS, $agent)) return;
        $page = self::pageCourante();
        if($page === null) return;

        $empreinte = substr(hash("sha256", ($_SERVER['REMOTE_ADDR'] ?? "")."|".$agent."|".date("Y-m-d")."|".self::sel()), 0, 16);
        $bdd = (new self())->getBdd();
        $stmt = $bdd->prepare("INSERT INTO visites (page, visiteur, source, appareil, connecte) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$page, $empreinte, self::source(), self::appareil($agent), Securite::estConnecte() ? 1 : 0]);

        //purge occasionnelle des donnees anciennes
        if(random_int(1, 300) === 1){
          $limite = date("Y-m-d", strtotime("-".self::CONSERVATION_JOURS." days"));
          $bdd->prepare("DELETE FROM visites WHERE created_at < ?")->execute([$limite]);
          $bdd->prepare("DELETE FROM journal WHERE created_at < ?")->execute([$limite]);
        }
      } catch (Throwable $e) {
        error_log("Audience : ".$e->getMessage());
      }
    }

    //page publique courante (ex. "prestations/sites"), null pour une page privee
    private static function pageCourante(){
      $segments = array_values(array_filter(explode("/", trim((string)($_GET['page'] ?? ""), "/")), "strlen"));
      $page = $segments[0] ?? "accueils";
      if(in_array($page, ["compte", "administration", "supervision"], true)) return null;
      if($page === "prestations" && isset($segments[1])) $page .= "/".$segments[1];
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
      return self::PAGES[$page] ?? $page;
    }
  }
