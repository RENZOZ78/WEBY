// Verifie que les 2 nouveaux mots de passe sont identiques avant d'activer le bouton Valider
(function () {
  var nouveauPassword = document.querySelector("#nouveauPassword");
  var confirmNouveauPassword = document.querySelector("#confirmNouveauPassword");
  var btnValidation = document.querySelector("#btnValidation");
  var erreur = document.querySelector("#erreur");
  if (!nouveauPassword || !confirmNouveauPassword) return;

  function verificationPassword() {
    var identiques = nouveauPassword.value === confirmNouveauPassword.value;
    var rempli = nouveauPassword.value.length > 0;
    btnValidation.disabled = !(identiques && rempli);
    erreur.classList.toggle("d-none", identiques || confirmNouveauPassword.value === "");
  }

  nouveauPassword.addEventListener("input", verificationPassword);
  confirmNouveauPassword.addEventListener("input", verificationPassword);
})();
