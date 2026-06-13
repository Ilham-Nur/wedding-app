/* ============================================================
   UNDANGAN PERNIKAHAN — Habib & Mia
   Vanilla JavaScript — tanpa library.
   ============================================================ */
(function () {
  "use strict";

  /* ---------- shortcut ---------- */
  const $  = (s, c = document) => c.querySelector(s);
  const $$ = (s, c = document) => [...c.querySelectorAll(s)];

  /* ========================================================
     1. NAMA TAMU dari URL  (?to=Nama)
     ======================================================== */
  (function setGuest() {
    const params = new URLSearchParams(location.search);
    const to = params.get("to") || params.get("kepada");
    if (to) {
      const clean = decodeURIComponent(to.replace(/\+/g, " ")).trim();
      if (clean) $("#guestName").textContent = clean;
    }
  })();

  /* ========================================================
     2. BUKA UNDANGAN  +  3. MUSIK
     ======================================================== */
  const cover    = $("#cover");
  const openBtn  = $("#openBtn");
  const bgm      = $("#bgm");
  const musicBtn = $("#musicBtn");

  function playMusic() {
    musicBtn.hidden = false;
    bgm.play().then(() => {
      musicBtn.classList.add("is-playing");
    }).catch(() => {
      /* file musik belum ada / diblokir browser — tombol tetap tampil */
      musicBtn.classList.remove("is-playing");
    });
  }

  function openInvitation() {
    cover.classList.add("is-open");
    document.body.classList.remove("is-locked");
    const inv = document.getElementById("invitation");
    if (inv) inv.removeAttribute("aria-hidden");   // tampilkan konten utama
    playMusic();
    // pastikan mulai dari atas konten
    requestAnimationFrame(() => window.scrollTo({ top: 0 }));
    setTimeout(() => { cover.style.display = "none"; }, 1100);
  }

  openBtn.addEventListener("click", openInvitation);

  /* toggle musik */
  musicBtn.addEventListener("click", () => {
    if (bgm.paused) {
      bgm.play().then(() => musicBtn.classList.add("is-playing")).catch(() => {});
    } else {
      bgm.pause();
      musicBtn.classList.remove("is-playing");
    }
  });

  /* ========================================================
     4. COUNTDOWN TIMER
     ======================================================== */
  (function countdown() {
    const el = $("#countdown");
    if (!el) return;
    const target = new Date(el.dataset.target).getTime();
    const units  = {
      days:    $('[data-unit="days"]',    el),
      hours:   $('[data-unit="hours"]',   el),
      minutes: $('[data-unit="minutes"]', el),
      seconds: $('[data-unit="seconds"]', el),
    };
    const pad = (n) => String(n).padStart(2, "0");

    function tick() {
      const diff = target - Date.now();
      if (diff <= 0) {
        Object.values(units).forEach((u) => (u.textContent = "00"));
        return;
      }
      const s = Math.floor(diff / 1000);
      units.days.textContent    = pad(Math.floor(s / 86400));
      units.hours.textContent   = pad(Math.floor((s % 86400) / 3600));
      units.minutes.textContent = pad(Math.floor((s % 3600) / 60));
      units.seconds.textContent = pad(s % 60);
    }
    tick();
    setInterval(tick, 1000);

    /* tautan "Simpan ke Kalender" (Google Calendar) */
    const cal = $("#calBtn");
    if (cal) {
      const start = new Date(el.dataset.target);
      const end   = new Date(start.getTime() + 3 * 3600 * 1000);
      const fmt   = (d) => d.toISOString().replace(/[-:]|\.\d{3}/g, "");
      const url = "https://calendar.google.com/calendar/render?action=TEMPLATE"
        + "&text=" + encodeURIComponent("Pernikahan Habib & Mia")
        + "&dates=" + fmt(start) + "/" + fmt(end)
        + "&details=" + encodeURIComponent("Dengan senang hati mengundang Anda.")
        + "&location=" + encodeURIComponent("Graha Melati, Jakarta Selatan");
      cal.href = url;
    }
  })();

  /* ========================================================
     5. SCROLL REVEAL (IntersectionObserver)
     ======================================================== */
  (function reveal() {
    const items = $$(".reveal");
    if (!("IntersectionObserver" in window)) {
      items.forEach((i) => i.classList.add("is-visible"));
      return;
    }
    const io = new IntersectionObserver((entries) => {
      entries.forEach((e) => {
        if (e.isIntersecting) {
          e.target.classList.add("is-visible");
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.14, rootMargin: "0px 0px -8% 0px" });
    items.forEach((i) => io.observe(i));
  })();

  /* ========================================================
     6. FOTO UTAMA: BATASI PORTRAIT YANG TERLALU TINGGI
     ======================================================== */
  (function mainPhotoFrame() {
    const image = $("#mainPhotoImage");
    if (!image) return;

    const classify = () => {
      const frame = image.closest(".main-photo__frame");
      if (!frame || !image.naturalWidth || !image.naturalHeight) return;
      frame.classList.toggle("is-tall", image.naturalHeight / image.naturalWidth > 1.45);
    };

    if (image.complete) classify();
    else image.addEventListener("load", classify, { once: true });
  })();

  /* ========================================================
     7. GALERI RESPONSIF BERDASARKAN ORIENTASI FOTO
     ======================================================== */
  (function responsiveGallery() {
    $$(".gallery__grid .gal img").forEach((img) => {
      const classify = () => {
        const item = img.closest(".gal");
        if (!item || !img.naturalWidth || !img.naturalHeight) return;

        item.classList.remove("gal--landscape", "gal--portrait");
        item.classList.add(
          img.naturalWidth > img.naturalHeight ? "gal--landscape" : "gal--portrait"
        );
      };

      if (img.complete) classify();
      else img.addEventListener("load", classify, { once: true });
    });
  })();

  /* ========================================================
     8. SALIN NOMOR REKENING
     ======================================================== */
  $$(".btn--copy").forEach((btn) => {
    btn.addEventListener("click", async () => {
      const no = btn.dataset.copy;
      try {
        await navigator.clipboard.writeText(no);
      } catch (_) {
        const t = document.createElement("textarea");
        t.value = no; document.body.appendChild(t); t.select();
        document.execCommand("copy"); t.remove();
      }
      const old = btn.textContent;
      btn.textContent = "Tersalin \u2713";
      btn.classList.add("is-copied");
      setTimeout(() => { btn.textContent = old; btn.classList.remove("is-copied"); }, 1800);
    });
  });

  /* ========================================================
     9. RSVP via WHATSAPP
     ======================================================== */
  (function rsvp() {
    const form = $("#rsvpForm");
    if (!form) return;
    // GANTI nomor berikut dengan nomor WhatsApp Anda (format 62...)
    const WA_NUMBER = "6281234567890";

    form.addEventListener("submit", (e) => {
      e.preventDefault();
      const name   = $("#rsvpName").value.trim();
      const count  = $("#rsvpCount").value;
      const attend = (form.querySelector('input[name="attend"]:checked') || {}).value || "Hadir";
      const msg    = $("#rsvpMsg").value.trim();

      if (!name) { $("#rsvpName").focus(); return; }

      const text =
        "*Konfirmasi Kehadiran — Habib & Mia*%0A" +
        "%0ANama: " + encodeURIComponent(name) +
        "%0AKehadiran: " + encodeURIComponent(attend) +
        "%0AJumlah Tamu: " + encodeURIComponent(count + " orang") +
        (msg ? "%0AUcapan: " + encodeURIComponent(msg) : "");

      window.open("https://wa.me/" + WA_NUMBER + "?text=" + text, "_blank");
    });
  })();

  /* ========================================================
     10. ANIMASI KELOPAK JATUH  (canvas)
     ======================================================== */
  (function petals() {
    const canvas = $("#petals");
    if (!canvas || window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;
    const ctx = canvas.getContext("2d");

    let W, H, dpr;
    function resize() {
      dpr = Math.min(window.devicePixelRatio || 1, 2);
      W = canvas.width  = innerWidth  * dpr;
      H = canvas.height = innerHeight * dpr;
      canvas.style.width  = innerWidth + "px";
      canvas.style.height = innerHeight + "px";
    }
    resize();
    addEventListener("resize", resize);

    // warna kelopak — diambil dari palet (hijau, merah, emas, blush)
    const COLORS = ["#b1463c", "#8e2a2a", "#c2a14d", "#ddc488", "#e8c9b0"];
    const COUNT  = innerWidth < 480 ? 16 : 26;

    const rnd = (a, b) => a + Math.random() * (b - a);

    function makePetal() {
      return {
        x: rnd(0, W),
        y: rnd(-H, 0),
        size: rnd(7, 14) * dpr,
        speedY: rnd(0.4, 1.1) * dpr,
        speedX: rnd(-0.5, 0.5) * dpr,
        sway: rnd(0.4, 1.4),
        swayPhase: rnd(0, Math.PI * 2),
        spin: rnd(-0.02, 0.02),
        rot: rnd(0, Math.PI * 2),
        color: COLORS[(Math.random() * COLORS.length) | 0],
        alpha: rnd(0.45, 0.9),
      };
    }
    let petals = Array.from({ length: COUNT }, makePetal);

    function drawPetal(p) {
      ctx.save();
      ctx.translate(p.x, p.y);
      ctx.rotate(p.rot);
      ctx.globalAlpha = p.alpha;
      ctx.fillStyle = p.color;
      // bentuk kelopak (dua kurva)
      ctx.beginPath();
      ctx.moveTo(0, -p.size);
      ctx.quadraticCurveTo(p.size * 0.8, -p.size * 0.2, 0, p.size);
      ctx.quadraticCurveTo(-p.size * 0.8, -p.size * 0.2, 0, -p.size);
      ctx.fill();
      ctx.restore();
    }

    function frame(t) {
      ctx.clearRect(0, 0, W, H);
      for (const p of petals) {
        p.swayPhase += 0.01 * p.sway;
        p.x += p.speedX + Math.sin(p.swayPhase) * 0.6 * dpr;
        p.y += p.speedY;
        p.rot += p.spin;
        if (p.y > H + 20) Object.assign(p, makePetal(), { y: -20 });
        if (p.x < -20) p.x = W + 20;
        if (p.x > W + 20) p.x = -20;
        drawPetal(p);
      }
      requestAnimationFrame(frame);
    }
    requestAnimationFrame(frame);
  })();

  /* ========================================================
     11. ORNAMEN BUNGA (aset pengguna) + bunga emas melayang
     ======================================================== */
  (function decor() {
    const svg = (id, vb) =>
      '<svg viewBox="' + vb + '" aria-hidden="true"><use href="#' + id + '"></use></svg>';

    // section -> [posisi sudut, nomor ornamen (assets/decor/ornament-N.png)]
    const orn = [
      [".events",  "br", 2],
      [".gallery", "tl", 1],
      [".gift",    "br", 3],
    ];
    const made = [];
    orn.forEach(([sel, spot, n]) => {
      const sec = document.querySelector(sel);
      if (!sec) return;
      const s = document.createElement("span");
      s.className = "deco deco--" + spot + " orn-" + n;
      s.setAttribute("aria-hidden", "true");
      s.innerHTML = '<img src="assets/decor/ornament-' + n + '.png" alt="" loading="lazy" />';
      sec.appendChild(s);
      made.push(s);
    });

    // animasi MUNCUL saat discroll (fade + zoom-in)
    if ("IntersectionObserver" in window) {
      const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
          if (e.isIntersecting) { e.target.classList.add("in"); io.unobserve(e.target); }
        });
      }, { threshold: 0.18, rootMargin: "0px 0px -6% 0px" });
      made.forEach((m) => io.observe(m));
    } else {
      made.forEach((m) => m.classList.add("in"));
    }

    function addFloatingBlooms(selector, blooms) {
      const section = document.querySelector(selector);
      if (!section) return;

      blooms.forEach((b, i) => {
        const s = document.createElement("span");
        s.className = "bloom-float";
        s.setAttribute("aria-hidden", "true");
        s.style.cssText =
          "top:" + b.top + ";left:" + b.left + ";width:" + b.size + "px;height:" + b.size + "px;" +
          "animation-delay:" + (-i * 1.7) + "s, " + (-i * 3) + "s";
        s.innerHTML = svg("bloom", "0 0 60 60");
        section.appendChild(s);
      });
    }

    addFloatingBlooms(".countdown", [
      { top: "14%", left: "8%",  size: 34 },
      { top: "62%", left: "86%", size: 26 },
      { top: "78%", left: "12%", size: 22 },
      { top: "22%", left: "82%", size: 30 },
    ]);

    addFloatingBlooms(".main-photo", [
      { top: "8%",  left: "8%",  size: 38 },
      { top: "22%", left: "84%", size: 24 },
      { top: "70%", left: "7%",  size: 26 },
      { top: "82%", left: "86%", size: 34 },
      { top: "48%", left: "91%", size: 18 },
    ]);
  })();

})();
