<section class="section">
  <div class="container text-center" style="max-width: 640px;">
    <div class="error-code mb-3"><?= http_response_code() ?: 404 ?></div>
    <h2 class="mb-3"><?= http_response_code() === 500 ? "Un problème est survenu" : "Cette page est introuvable" ?></h2>
    <p class="text-muted-wc mb-4"><?= htmlspecialchars($msg ?? "") ?></p>
    <div class="d-flex flex-wrap justify-content-center gap-3">
      <a href="<?= URL ?>accueils" class="btn btn-gold">Retour à l'accueil</a>
      <a href="<?= URL ?>contact" class="btn btn-outline-navy">Nous contacter</a>
    </div>
  </div>
</section>
