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

  // cycle des prestations du hero : le point lumineux fait le tour, marque une pause sur chaque phase
  // et l'allume ; l'arc de progression le suit, un segment de couleur par phase.
  // Survol ou focus d'une phase : pause sur celle-ci.
  document.querySelectorAll(".wc-cycle").forEach(function (cycle) {
    var etapes = cycle.querySelectorAll(".cycle-step");
    var n = etapes.length;
    var orbite = cycle.querySelector(".cycle-orbit");
    var arc = cycle.querySelector(".ring-progress");
    var segments = cycle.querySelectorAll(".ring-seg");
    var depart = parseFloat(cycle.getAttribute("data-depart")) || 0;
    var num = cycle.querySelector(".cycle-num b");
    var titre = cycle.querySelector(".cycle-titre");
    var texte = cycle.querySelector(".cycle-texte");
    var phase = cycle.querySelector(".cycle-phase");
    var duree = 3600, pose = .5, tour = duree * n;
    var active = 0, survol = -1, changement = null;

    function afficher(k) {
      if (k === active) return;
      active = k;
      etapes.forEach(function (el, j) { el.classList.toggle("on", j === k); });
      cycle.classList.add("change");
      clearTimeout(changement);
      changement = setTimeout(function () {
        var el = etapes[k];
        num.textContent = (k < 9 ? "0" : "") + (k + 1);
        titre.textContent = el.getAttribute("data-titre");
        texte.textContent = el.getAttribute("data-texte");
        phase.textContent = el.getAttribute("data-phase");
        // le centre et le point lumineux prennent la couleur de la phase
        var style = getComputedStyle(el);
        ["--c", "--g", "--gt"].forEach(function (v) { cycle.style.setProperty(v, style.getPropertyValue(v)); });
        cycle.classList.remove("change");
      }, 250);
    }

    etapes.forEach(function (el, j) {
      var lien = el.querySelector("a");
      function entrer() { survol = j; afficher(j); }
      function sortir() { survol = -1; }
      lien.addEventListener("mouseenter", entrer);
      lien.addEventListener("focus", entrer);
      lien.addEventListener("mouseleave", sortir);
      lien.addEventListener("blur", sortir);
    });

    if (reduit || !arc || !orbite) { etapes[0].classList.add("vu"); return; }

    function adoucir(u) { return u < .5 ? 4 * u * u * u : 1 - Math.pow(-2 * u + 2, 3) / 2; }

    var temps = 0, precedent = null, visible = true, enCours = false, premierTour = true, tourCourant = 0;
    function image(t) {
      if (precedent !== null && survol < 0) temps += Math.min(t - precedent, 100);
      precedent = t;
      var numTour = Math.floor(temps / tour);
      if (numTour !== tourCourant) {
        tourCourant = numTour; premierTour = false;
        etapes.forEach(function (el) { el.classList.remove("vu"); });
        cycle.classList.add("boucle");
        setTimeout(function () { cycle.classList.remove("boucle"); }, 700);
      }
      var dansTour = temps % tour;
      var k = Math.floor(dansTour / duree);
      var u = (dansTour % duree) / duree;
      var pas = u < pose ? 0 : adoucir((u - pose) / (1 - pose));
      var position = k + pas; // en nombre d'etapes parcourues, de 0 a n

      orbite.style.transform = "rotate(" + (depart + position * 360 / n) + "deg)";
      // le tour vient de se boucler : l'arc complet s'efface avant de repartir
      var bouclage = k === 0 && u < pose && !premierTour;
      arc.style.opacity = bouclage ? 1 - u / pose : 1;
      segments.forEach(function (seg, j) {
        var longueur = bouclage ? 1 : Math.max(0, Math.min(1, position - j));
        seg.style.opacity = longueur > 0 ? 1 : 0;
        seg.style.strokeDasharray = longueur + " " + n;
        seg.style.strokeDashoffset = -j;
      });
      var atteinte = Math.floor(position + 1e-6) % n;
      for (var j = 0; j <= Math.min(Math.floor(position + 1e-6), n - 1); j++) etapes[j].classList.add("vu");
      if (survol < 0) afficher(atteinte);
      if (visible && !document.hidden) requestAnimationFrame(image); else enCours = false;
    }

    function relancer() {
      if (enCours || !visible || document.hidden) return;
      enCours = true; precedent = null;
      requestAnimationFrame(image);
    }
    // l'animation s'arrete quand le cycle sort de l'ecran ou que l'onglet est masque
    if ("IntersectionObserver" in window) {
      new IntersectionObserver(function (entries) {
        visible = entries[0].isIntersecting;
        relancer();
      }).observe(cycle);
    }
    document.addEventListener("visibilitychange", relancer);
    relancer();
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
        scene.querySelectorAll(".hero-card").forEach(function (c, i) {
          c.style.transform = "translate(" + (x * (14 + i * 8)) + "px, " + (y * (14 + i * 8)) + "px)";
        });
      });
      hero.addEventListener("mouseleave", function () {
        scene.querySelectorAll(".hero-img, .hero-card").forEach(function (c) { c.style.transform = ""; });
      });
    }
  }
})();
