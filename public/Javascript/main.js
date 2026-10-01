// Scripts communs a toutes les pages
(function () {
  var nav = document.getElementById("main-nav");
  var backTop = document.querySelector(".back-top");

  // la barre de navigation devient opaque apres 30px de defilement
  function onScroll() {
    var y = window.scrollY || document.documentElement.scrollTop;
    if (nav) nav.classList.toggle("scrolled", y > 30);
    if (backTop) backTop.classList.toggle("show", y > 600);
  }
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();

  if (backTop) {
    backTop.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  // animations au defilement (si la librairie AOS est chargee)
  if (window.AOS) {
    AOS.init({ once: true, duration: 700, offset: 60 });
    // les images chargees a la demande changent la hauteur de la page : on recalcule les positions
    document.querySelectorAll("img[loading=lazy]").forEach(function (img) {
      if (!img.complete) img.addEventListener("load", function () { AOS.refresh(); });
    });
  } else {
    document.querySelectorAll("[data-aos]").forEach(function (el) {
      el.removeAttribute("data-aos");
    });
  }

  // validation Bootstrap des formulaires marques .needs-validation
  document.querySelectorAll("form.needs-validation").forEach(function (form) {
    form.addEventListener("submit", function (e) {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add("was-validated");
    });
  });

  // demande de confirmation sur les elements marques data-confirm
  document.querySelectorAll("[data-confirm]").forEach(function (el) {
    var evenement = el.tagName === "SELECT" ? "change" : "submit";
    var cible = el.tagName === "SELECT" ? el : el.closest("form") || el;
    cible.addEventListener(evenement, function (e) {
      if (!window.confirm(el.getAttribute("data-confirm"))) {
        e.preventDefault();
        if (el.tagName === "SELECT") el.value = el.getAttribute("data-initial");
        return;
      }
      if (el.tagName === "SELECT") el.form.submit();
    });
  });
})();
