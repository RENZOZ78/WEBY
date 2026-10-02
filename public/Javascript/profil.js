// Page profil : affichage du formulaire de modification du mail et confirmation de suppression
(function () {
  var affichageMail = document.querySelector("#affichageMail");
  var formMail = document.querySelector("#modificationMail");
  var btnModifMail = document.querySelector("#btnModifMail");
  var btnAnnulerMail = document.querySelector("#btnAnnulerMail");

  if (btnModifMail && formMail && affichageMail) {
    btnModifMail.addEventListener("click", function () {
      affichageMail.classList.add("d-none");
      formMail.classList.remove("d-none");
      formMail.querySelector("input[type=email]").focus();
    });
    btnAnnulerMail.addEventListener("click", function () {
      formMail.classList.add("d-none");
      affichageMail.classList.remove("d-none");
    });
  }

  // envoi automatique de la nouvelle photo des qu'elle est choisie
  var inputImage = document.querySelector("#image");
  if (inputImage) {
    inputImage.addEventListener("change", function () {
      if (inputImage.files.length) inputImage.form.submit();
    });
  }

  // affiche la confirmation de suppression du compte
  var btnSupCompte = document.querySelector("#btnSupCompte");
  if (btnSupCompte) {
    btnSupCompte.addEventListener("click", function () {
      document.querySelector("#suppressionCompte").classList.remove("d-none");
      btnSupCompte.classList.add("d-none");
    });
  }
})();
