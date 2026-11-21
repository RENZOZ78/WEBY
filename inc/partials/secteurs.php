<?php
  /* Bandeau défilant des métiers accompagnés (accueil et bas des pages métier)
   * $bandeau = ["kicker", "titre", "texte", "exclu" => slug du métier à ne pas afficher] (facultatif) */
  $listeSecteurs = require "inc/secteurs.php";
  $bandeau = $bandeau ?? [];
  if(!empty($bandeau['exclu'])) unset($listeSecteurs[$bandeau['exclu']]);
  $nbSecteurs = count($listeSecteurs);
?>
<section class="section secteurs-section" id="secteurs">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <span class="kicker cyan"><?= $bandeau['kicker'] ?? "Votre métier" ?></span>
      <h2><?= $bandeau['titre'] ?? "Nous vous aidons, quel que soit votre métier" ?></h2>
      <p><?= $bandeau['texte'] ?? "Chaque métier a ses propres casse-têtes. Trouvez le vôtre et découvrez comment nous le réglons, partout en France, en visio ou en rendez-vous." ?></p>
    </div>
  </div>

  <div class="secteurs-band" role="region" aria-label="Métiers accompagnés" data-aos="fade-up" style="--nb: <?= $nbSecteurs ?>">
    <?php for($copie = 0; $copie < 2; $copie++) : // la 2e copie sert uniquement à boucler le défilement sans coupure ?>
      <ul class="secteurs-groupe"<?= $copie ? ' aria-hidden="true" inert' : '' ?>>
        <?php foreach($listeSecteurs as $slugMetier => $metier) : ?>
          <li>
            <a href="<?= URL ?>secteurs/<?= $slugMetier ?>" class="metier-card <?= $metier['couleur'] ?>"<?= $copie ? ' tabindex="-1"' : '' ?>>
              <span class="metier-head">
                <span class="icon"><i class="fas <?= $metier['icone'] ?>"></i></span>
                <span>
                  <strong><?= $metier['nom'] ?></strong>
                  <small><?= $metier['qui'] ?></small>
                </span>
              </span>
              <span class="metier-label">Vos casse-têtes</span>
              <span class="metier-pbs">
                <?php foreach(array_slice($metier['problemes'], 0, 3) as $probleme) : ?>
                  <span><i class="fas fa-circle-exclamation"></i><?= $probleme[1] ?></span>
                <?php endforeach; ?>
              </span>
              <span class="link-arrow">Nos solutions pour vous <i class="fas fa-arrow-right"></i></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endfor; ?>
  </div>

  <div class="container">
    <div class="secteurs-controles">
      <button type="button" class="secteurs-btn" data-sens="-1" aria-label="Métiers précédents"><i class="fas fa-arrow-left" aria-hidden="true"></i></button>
      <button type="button" class="secteurs-btn secteurs-pause" aria-pressed="false" aria-label="Mettre le défilement en pause" hidden><i class="fas fa-pause" aria-hidden="true"></i></button>
      <button type="button" class="secteurs-btn" data-sens="1" aria-label="Métiers suivants"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
    </div>
    <?php /* une seule aide, valable à la souris, au clavier et au doigt (plus de « Survolez… » sur téléphone) */ ?>
    <div class="secteurs-aide-ligne">
      <span class="secteurs-aide">Faites glisser ou utilisez les flèches pour parcourir les métiers<span class="secteurs-aide-pause" hidden> ; le bouton pause arrête le défilement</span>.</span>
    </div>
  </div>
</section>
