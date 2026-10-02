// Scripts communs a toutes les pages
(function () {
  var nav = document.getElementById("main-nav");
  var backTop = document.querySelector(".back-top");
  var progress = document.querySelector(".scroll-progress");
  var reduit = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  // navigation opaque, bouton retour en haut et barre de progression au defilement
  function onScroll() {
    var y = window.scrollY || document.documentElement.scrollTop;
    if (nav) nav.classList.toggle("scrolled", y > 30);
    if (backTop) backTop.classList.toggle("show", y > 600);
    if (progress) {
      var h = document.documentElement.scrollHeight - window.innerHeight;
      progress.style.width = (h > 0 ? Math.min(100, (y / h) * 100) : 0) + "%";
    }
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
    AOS.init({ once: true, duration: 750, offset: 60, easing: "ease-out-cubic" });
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

  // mot qui tourne dans le titre du hero
  document.querySelectorAll(".rotating").forEach(function (box) {
    var mots = box.querySelectorAll("span");
    if (mots.length < 2 || reduit) { if (mots[0]) mots[0].classList.add("on"); return; }
    var i = 0;
    mots[0].classList.add("on");
    //l'ancien mot disparait entierement avant que le suivant n'apparaisse (pas de chevauchement)
    setInterval(function () {
      mots[i].classList.remove("on");
      i = (i + 1) % mots.length;
      var suivant = mots[i];
      setTimeout(function () { suivant.classList.add("on"); }, 400);
    }, 2800);
  });

  // compteurs : les nombres montent quand la tuile devient visible
  function animerCompteur(el) {
    var cible = parseFloat(el.getAttribute("data-count"));
    var suffixe = el.getAttribute("data-suffix") || "";
    var decimales = (String(cible).split(".")[1] || "").length;
    var debut = null, duree = 1400;
    function etape(t) {
      if (!debut) debut = t;
      var p = Math.min(1, (t - debut) / duree);
      var e = 1 - Math.pow(1 - p, 3);
      el.textContent = (cible * e).toFixed(decimales).replace(".", ",") + suffixe;
      if (p < 1) requestAnimationFrame(etape);
    }
    requestAnimationFrame(etape);
  }
  var compteurs = document.querySelectorAll("[data-count]");
  if (compteurs.length && "IntersectionObserver" in window && !reduit) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) { animerCompteur(entry.target); io.unobserve(entry.target); }
      });
    }, { threshold: .5 });
    compteurs.forEach(function (el) { io.observe(el); });
  }

  // inclinaison 3D des cartes au passage de la souris
  if (!reduit && window.matchMedia("(hover: hover) and (pointer: fine)").matches) {
    document.querySelectorAll(".tilt").forEach(function (card) {
      if (!card.querySelector(".shine")) { var s = document.createElement("span"); s.className = "shine"; card.appendChild(s); }
      card.addEventListener("mousemove", function (e) {
        var r = card.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width, y = (e.clientY - r.top) / r.height;
        card.classList.add("is-tilting");
        card.style.transform = "perspective(900px) rotateX(" + ((.5 - y) * 6).toFixed(2) + "deg) rotateY(" + ((x - .5) * 8).toFixed(2) + "deg) translateY(-6px)";
        card.style.setProperty("--mx", (x * 100) + "%");
        card.style.setProperty("--my", (y * 100) + "%");
      });
      card.addEventListener("mouseleave", function () {
        card.classList.remove("is-tilting");
        card.style.transform = "";
      });
    });

    // parallaxe douce du visuel du hero
    var scene = document.querySelector(".hero-scene");
    if (scene) {
      var hero = scene.closest(".wc-hero");
      hero.addEventListener("mousemove", function (e) {
        var r = hero.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width - .5, y = (e.clientY - r.top) / r.height - .5;
        scene.querySelector(".hero-img").style.transform = "rotateY(" + (x * 6) + "deg) rotateX(" + (-y * 6) + "deg)";
        scene.querySelectorAll(".hero-card, .hero-mock").forEach(function (c, i) {
          c.style.transform = "translate(" + (x * (14 + i * 8)) + "px, " + (y * (14 + i * 8)) + "px)";
        });
      });
      hero.addEventListener("mouseleave", function () {
        scene.querySelectorAll(".hero-img, .hero-card, .hero-mock").forEach(function (c) { c.style.transform = ""; });
      });
    }
  }
})();
