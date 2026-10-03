<?php
  /* Fonctions d'affichage de la supervision (incluses une fois par page) */

  //texte sur (les donnees du site sont deja echappees a l'enregistrement : pas de double echappement)
  function sv_txt($texte){
    return htmlspecialchars((string)$texte, ENT_QUOTES, "UTF-8", false);
  }

  function sv_nombre($n){
    return number_format((float)$n, 0, ",", "\u{202F}");
  }

  //evolution par rapport a la periode precedente
  function sv_evolution($actuel, $precedent){
    if($precedent <= 0){
      return $actuel > 0 ? '<span class="sv-evo up" title="Aucune donnée sur la période précédente"><i class="fas fa-arrow-up"></i>nouveau</span>' : '';
    }
    $ecart = round(($actuel - $precedent) * 100 / $precedent);
    if($ecart == 0) return '<span class="sv-evo"><i class="fas fa-equals"></i>stable</span>';
    $sens = $ecart > 0 ? "up" : "down";
    return '<span class="sv-evo '.$sens.'" title="Par rapport à la période précédente ('.sv_nombre($precedent).')"><i class="fas fa-arrow-'.($ecart > 0 ? "up" : "down").'"></i>'.($ecart > 0 ? "+" : "").$ecart.' %</span>';
  }

  //delai lisible a partir d'un nombre de minutes
  function sv_delai($minutes){
    if($minutes === null) return "—";
    if($minutes < 60) return $minutes." min";
    if($minutes < 48 * 60) return round($minutes / 60, 1)." h";
    return round($minutes / 1440, 1)." j";
  }

  //"il y a 3 h"
  function sv_depuis($dateSql){
    if(!$dateSql) return "jamais";
    $s = time() - strtotime($dateSql);
    if($s < 60) return "à l'instant";
    if($s < 3600) return "il y a ".floor($s / 60)." min";
    if($s < 86400) return "il y a ".floor($s / 3600)." h";
    if($s < 86400 * 30) return "il y a ".floor($s / 86400)." j";
    return Toolbox::dateFr($dateSql, false);
  }

  //histogramme vertical (une serie) : $serie = [["libelle" => …, $cle => n, …]], infobulle construite par $tip
  function sv_histogramme($serie, $cle, $tip, $titre){
    $max = max(1, max(array_column($serie, $cle) ?: [0]));
    $n = count($serie);
    ob_start(); ?>
    <figure class="sv-chart-wrap">
      <div class="sv-chart" role="img" aria-label="<?= sv_txt($titre) ?>" style="--n: <?= $n ?>">
        <span class="sv-grid" style="bottom: 100%"><em><?= sv_nombre($max) ?></em></span>
        <span class="sv-grid" style="bottom: 50%"><em><?= sv_nombre($max / 2) ?></em></span>
        <?php foreach($serie as $point) : ?>
          <span class="sv-bar" tabindex="0" data-tip="<?= sv_txt($tip($point)) ?>"><span style="height: <?= round($point[$cle] * 100 / $max, 2) ?>%"></span></span>
        <?php endforeach; ?>
      </div>
      <div class="sv-axis">
        <span><?= sv_txt($serie[0]['libelle'] ?? "") ?></span>
        <?php if($n > 2) : ?><span><?= sv_txt($serie[intdiv($n, 2)]['libelle']) ?></span><?php endif; ?>
        <span><?= sv_txt($serie[$n - 1]['libelle'] ?? "") ?></span>
      </div>
      <details class="sv-data">
        <summary>Voir les données</summary>
        <div class="table-responsive"><table class="table table-sm">
          <thead><tr><th>Période</th><th class="text-end"><?= $cle === "visiteurs" ? "Visiteurs" : "Pages vues" ?></th><?php if(isset($serie[0]['visiteurs']) && $cle !== "visiteurs") : ?><th class="text-end">Visiteurs</th><?php endif; ?><?php if(isset($serie[0]['vues']) && $cle !== "vues") : ?><th class="text-end">Pages vues</th><?php endif; ?></tr></thead>
          <tbody>
            <?php foreach(array_reverse($serie) as $point) : ?>
              <tr><td><?= sv_txt($point['libelle']) ?></td><td class="text-end"><?= sv_nombre($point[$cle]) ?></td><?php if(isset($point['visiteurs']) && $cle !== "visiteurs") : ?><td class="text-end"><?= sv_nombre($point['visiteurs']) ?></td><?php endif; ?><?php if(isset($point['vues']) && $cle !== "vues") : ?><td class="text-end"><?= sv_nombre($point['vues']) ?></td><?php endif; ?></tr>
            <?php endforeach; ?>
          </tbody>
        </table></div>
      </details>
    </figure>
    <?php return ob_get_clean();
  }

  //classement en barres horizontales : $lignes = [[libelle, valeur, detail]]
  function sv_classement($lignes, $vide = "Pas encore de données sur cette période."){
    if(empty($lignes)) return '<p class="text-muted-wc mb-0">'.$vide.'</p>';
    $max = max(1, max(array_column($lignes, 1)));
    $html = '<ul class="sv-rank">';
    foreach($lignes as $ligne){
      $html .= '<li><span class="lbl" title="'.sv_txt($ligne[0]).'">'.sv_txt($ligne[0]).'</span>'
        .'<span class="track"><span style="width: '.round($ligne[1] * 100 / $max, 2).'%"></span></span>'
        .'<span class="val">'.sv_nombre($ligne[1]).(isset($ligne[2]) ? '<small>'.sv_txt($ligne[2]).'</small>' : '').'</span></li>';
    }
    return $html.'</ul>';
  }

  //selecteur de periode (liens ?periode=)
  function sv_periodes($courante, $extra = []){
    $html = '<div class="sv-periodes" role="group" aria-label="Période">';
    foreach(SupervisionController::PERIODES as $jours => $libelle){
      $query = http_build_query(array_merge($extra, ["periode" => $jours]));
      $html .= '<a href="?'.sv_txt($query).'" class="'.($jours === $courante ? "active" : "").'"'.($jours === $courante ? ' aria-current="true"' : '').'>'.$libelle.'</a>';
    }
    return $html.'</div>';
  }
