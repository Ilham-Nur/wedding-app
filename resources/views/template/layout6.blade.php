@php
    $assetPath = 'layout_undangan/' . ($wedding->layout->folder_path ?? 'layout5');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
    <title>The Wedding of {{ $wedding->nama_pria }} & {{ $wedding->nama_wanita }}</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset($assetPath . '/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
    <!-- COVER -->
    <section class="wedding-cover" id="cover">
        <div class="side left"></div>
        <div class="side right"></div>
        <div class="overlay"></div>

        <div class="content">
            <p class="subtitle">THE WEDDING OF</p>
            <h1 class="names" data-anim="down">
                <!-- {{ $wedding->nama_pria }} &amp; {{ $wedding->nama_wanita }} -->
                Yudi & Ayu
            </h1>
            <div class="divider" aria-hidden="true"></div>
            <p class="date">
                {{ \Carbon\Carbon::parse($wedding->tanggal)->format('d') }}<span
                    class="dot">.</span>{{ \Carbon\Carbon::parse($wedding->tanggal)->format('m') }}<span
                    class="dot">.</span>{{ \Carbon\Carbon::parse($wedding->tanggal)->format('Y') }}
            </p>
            @if (isset($tamu) && $tamu->nama_tamu !== '-')
                <p class="guest-cover">
                    Kepada Yth.<br />
                    <span class="guest-name">{{ $tamu->nama_tamu }}</span>
                </p>
            @endif
            <button class="btn-invite" id="openInvite">BUKA UNDANGAN</button>
        </div>
    </section>

    <!-- WEDDING CONTENT -->
    <main id="wedding-content" class="wedding-content hidden" aria-hidden="true">

        <!-- Music Button -->
        <div class="music-control">
            <button class="music-button" id="musicButton">
                <i class="fa fa-music"></i>
            </button>
            <audio id="mySong" loop>
                <source src="{{ asset('storage/' . $wedding->file_musik) }}" type="audio/mp3" />
            </audio>
        </div>

        <!-- HERO -->
        <section class="hero" data-anim="up">
            <div class="hero-media">
                <img src="{{ asset('storage/' . $wedding->foto_utama) }}"
                    alt="Foto {{ $wedding->nama_pria }} & {{ $wedding->nama_wanita }}" />
            </div>
            <div class="hero-info">
                <h2>Yudi & Ayu</h2>
                <!-- <h2>{{ $wedding->nama_pria }} &amp; {{ $wedding->nama_wanita }}</h2> -->
                <p class="hero-date">
                    {{ \Carbon\Carbon::parse($wedding->tanggal)->format('d') }} .
                    {{ \Carbon\Carbon::parse($wedding->tanggal)->format('m') }} .
                    {{ \Carbon\Carbon::parse($wedding->tanggal)->format('Y') }}
                </p>
            </div>
        </section>

        <!-- QUOTE -->
        <section class="quote" data-anim="down">
            <blockquote>
                <p style="font-style: italic; font-family: 'Georgia', serif; margin-bottom: 10px;">
                    "Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan
                    untukmu pasangan-pasangan dari jenismu sendiri, agar kamu merasa tenteram
                    dan merasa nyaman dengan mereka, dan Dia menanamkan di antara kalian
                    rasa kasih sayang dan cinta. Sungguh, di dalam itu benar-benar terdapat
                    tanda bagi orang yang berpikir."
                </p>
                <p style="font-style: italic; font-family: 'Georgia', serif;">
                    (QS. Ar-Rum: 21)
                </p>
            </blockquote>
        </section>

        <!-- COUPLE -->
        <section class="couple" data-anim="left">
            <h3>Meet The Couple</h3>

            <div class="couple-grid elegant-couple">
                <!-- Groom -->
                <figure class="couple-card">
                    <div class="couple-photo">
                        <img src="{{ asset('storage/' . $wedding->foto_suami) }}"
                            alt="Mempelai Pria - {{ $wedding->nama_pria }}" />
                    </div>
                    <figcaption>
                        <h4 class="couple-name">{{ $wedding->nama_pria }}</h4>
                        <p class="couple-parent">
                            Putra dari<br />
                            <span>{{ $wedding->nama_ayah_suami }}</span>
                            &amp;
                            <span>{{ $wedding->nama_ibu_suami }}</span>
                        </p>
                    </figcaption>
                </figure>

                <!-- Bride -->
                <figure class="couple-card">
                    <div class="couple-photo">
                        <img src="{{ asset('storage/' . $wedding->foto_istri) }}"
                            alt="Mempelai Wanita - {{ $wedding->nama_wanita }}" />
                    </div>
                    <figcaption>
                        <h4 class="couple-name">{{ $wedding->nama_wanita }}</h4>
                        <p class="couple-parent">
                            Putri dari<br />
                            <span>{{ $wedding->nama_ayah_istri }}</span>
                            &amp;
                            <span>{{ $wedding->nama_ibu_istri }}</span>
                        </p>
                    </figcaption>
                </figure>
            </div>
        </section>

        <!-- EVENT - Updated dengan Icon Circles -->
        <section class="event" data-anim="right">
            <h3>Event Details</h3>

            <div class="timeline">
                @foreach ($wedding->lokasis as $index => $lokasi)
                    <article class="event-item" data-anim="{{ $index % 2 == 0 ? 'left' : 'right' }}">
                        <div class="event-icon-circle">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div class="event-detail">
                            <h4>{{ $lokasi->nama_acara }}</h4>
                            <p class="when">
                                <i class="fa-regular fa-clock"></i>
                                {{ \Carbon\Carbon::parse($lokasi->tanggal)->translatedFormat('d F Y') }} —
                                {{ \Carbon\Carbon::parse($lokasi->waktu_mulai)->format('H:i') }} WIB
                            </p>
                            <p class="where">{{ $lokasi->alamat }}</p>
                            <a class="map-link" href="{{ $lokasi->maps_link }}" target="_blank" rel="noopener">
                                <i class="fa-solid fa-location-dot"></i> Lihat di peta
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <!-- GALLERY -->
        @if ($wedding->galeris->isNotEmpty())
            <section class="gallery" id="gallerySection" data-anim="left">
                <h3>Gallery</h3>

                <!-- preview besar -->
                <div class="gallery-preview" id="galleryPreview" aria-live="polite">
                    <img id="galleryPreviewImg" src="{{ asset('storage/' . $wedding->galeris->first()->file_path) }}"
                        alt="Preview" />
                    <div class="preview-caption" id="galleryPreviewTitle">
                        {{ $wedding->galeris->first()->judul ?? 'Foto Pernikahan' }}
                    </div>
                </div>

                <!-- thumbnail horizontal scroll -->
                <div class="gallery-thumbs-wrap">
                    <div class="gallery-thumbs" id="galleryThumbs" tabindex="0" role="listbox"
                        aria-label="Daftar foto">
                        @foreach ($wedding->galeris as $index => $foto)
                            <button class="thumb {{ $index == 0 ? 'active' : '' }}" data-idx="{{ $index }}"
                                data-src="{{ asset('storage/' . $foto->file_path) }}"
                                data-title="{{ $foto->judul ?? 'Foto ' . ($index + 1) }}" type="button"
                                role="option" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                <img src="{{ asset('storage/' . $foto->file_path) }}"
                                    alt="{{ $foto->judul ?? 'Thumbnail' }}">
                            </button>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- GIFT -->
        @if (isset($tamu) && $tamu->show_gift && $wedding->gifts->isNotEmpty())
            <section class="gift" data-anim="right">
                <h3>Gifts & Blessings</h3>
                <p>If you wish to send a gift, here is our official account:</p>

                <div class="gift-list" id="giftList">
                    @foreach ($wedding->gifts as $rekening)
                        <div class="gift-card" data-rek="{{ $rekening->no_rekening }}">
                            <img src="{{ asset('layout_undangan/layout6/' . $rekening->bank_nama . '.png') }}"
                                alt="{{ $rekening->bank_nama }}" class="gift-logo"
                                onerror="this.src='{{ asset('layout_undangan/layout6') }}'">

                            <div class="gift-info">
                                <div class="gift-bank">{{ $rekening->bank_nama }}</div>
                                <div class="gift-number">{{ $rekening->no_rekening }}</div>
                                <div class="gift-name">a/n {{ $rekening->atas_nama }}</div>
                                @if ($rekening->catatan)
                                    <div class="gift-note">{{ $rekening->catatan }}</div>
                                @endif
                            </div>

                            <button class="copy-btn" data-copy="{{ $rekening->no_rekening }}">Copy</button>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- TURUT MENGUNDANG -->
        @php
            $turutPria = trim(strip_tags($wedding->turut_mengundang_pria ?? ''));
            $turutWanita = trim(strip_tags($wedding->turut_mengundang_wanita ?? ''));
        @endphp

        @if (!empty($turutPria) || !empty($turutWanita))
            <section class="turut-mengundang" data-anim="left">
                <h3>With Our Warmest Invitation</h3>

                @if (!empty($turutPria))
                    <div class="mengundang-section">
                        <h4>Pihak Mempelai Pria</h4>
                        <div class="mengundang-content">
                            {!! $wedding->turut_mengundang_pria !!}
                        </div>
                    </div>
                @endif

                @if (!empty($turutWanita))
                    <div class="mengundang-section">
                        <h4>Pihak Mempelai Wanita</h4>
                        <div class="mengundang-content">
                            {!! $wedding->turut_mengundang_wanita !!}
                        </div>
                    </div>
                @endif
            </section>
        @endif

        <!-- COMMENTS / RSVP - Menggunakan LocalStorage seperti Template 1 -->
        <section class="comments" data-anim="left">
            <h3>Messages & Prayers</h3>

            @if (isset($tamu))
                @if (is_null($tamu->status_hadir) || $tamu->status_hadir === 'belum_konfirmasi')
                    {{-- ✅ Tamu BELUM konfirmasi → tampilkan form --}}
                    <form id="commentForm" class="comment-form" aria-label="Form komentar">
                        <input type="hidden" id="tamuId" value="{{ $tamu->id }}">
                        <input type="hidden" id="guestOf" value="{{ $tamu->nama_tamu }}">

                        <div class="row">
                            <input type="text" id="name" name="name" value="{{ $tamu->nama_tamu }}"
                                placeholder="Nama" readonly required />

                            <select id="attendance" name="attendance" required>
                                <option value="" disabled selected>Konfirmasi Kehadiran</option>
                                <option style="color: black;" value="hadir">Hadir</option>
                                <option style="color: black;" value="tidak_hadir">Tidak Hadir</option>
                                <option style="color: black;" value="mungkin">Mungkin</option>
                            </select>
                        </div>

                        <div class="row">
                            <input type="number" id="guestCount" name="guestCount"
                                placeholder="Jumlah orang yang datang" min="1" value="1" />
                        </div>

                        <div class="row">
                            <textarea id="message" name="message" rows="3" placeholder="Tulis ucapan & doa Anda..." required></textarea>
                        </div>

                        <div class="row actions">
                            <button type="submit" class="btn-submit">Kirim</button>
                        </div>
                    </form>
                @else
                    {{-- ✅ Tamu SUDAH konfirmasi (hadir / tidak_hadir / mungkin) --}}
                    <p class="already-sent" style="text-align:center;margin-top:15px;">
                        <b>Terima kasih, Anda sudah mengirim konfirmasi & ucapan.</b>
                    </p>
                @endif
            @endif

            <div class="comment-card">
                <div class="comment-card-body">
                    <div id="commentList" class="comment-list" data-comments='@json($tamusWithUcapan)'>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer-note" data-anim="down">
            <!-- <p>&copy; {{ date('Y') }} {{ $wedding->nama_pria }} &amp; {{ $wedding->nama_wanita }}</p> -->
            <p style="font-size: 0.85em; margin-top: 5px;">Powered by <b>Arcdev</b></p>
        </footer>
    </main>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Toggle Cover & Content
        const openBtn = document.getElementById("openInvite");
        const content = document.getElementById("wedding-content");
        const cover = document.getElementById("cover");
        const musicButton = document.getElementById("musicButton");
        const mySong = document.getElementById("mySong");

        function openContent() {
            cover.classList.add("hidden");
            content.classList.remove("hidden");
            content.setAttribute("aria-hidden", "false");
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });

            // Auto play music
            if (mySong && mySong.paused) {
                mySong.play().catch(e => console.log('Autoplay prevented'));
                if (musicButton) musicButton.classList.add("active");
            }
        }

        if (openBtn) {
            openBtn.addEventListener("click", openContent);
        }

        // Music Control
        if (musicButton && mySong) {
            musicButton.addEventListener("click", function() {
                if (mySong.paused) {
                    mySong.play();
                    musicButton.classList.add("active");
                } else {
                    mySong.pause();
                    musicButton.classList.remove("active");
                }
            });
        }

        // Gallery System
        (function() {
            const thumbs = document.querySelectorAll(".thumb");
            const previewImg = document.getElementById("galleryPreviewImg");
            const previewTitle = document.getElementById("galleryPreviewTitle");
            const thumbsContainer = document.getElementById("galleryThumbs");
            const previewWrapper = document.getElementById("galleryPreview");

            if (!thumbs.length || !previewImg) return;

            let activeIndex = 0;

            function setActive(index, options = {
                scrollThumbIntoView: true
            }) {
                if (index < 0 || index >= thumbs.length) return;

                const thumb = thumbs[index];
                const src = thumb.dataset.src;
                const title = thumb.dataset.title;

                // Update preview
                previewImg.src = src;
                previewImg.alt = title;
                if (previewTitle) previewTitle.textContent = title;

                // Update classes
                thumbs.forEach((t, i) => {
                    t.classList.toggle("active", i === index);
                    t.setAttribute("aria-selected", i === index ? "true" : "false");
                });

                activeIndex = index;

                // Scroll thumb into view
                if (options.scrollThumbIntoView && thumbsContainer) {
                    const containerRect = thumbsContainer.getBoundingClientRect();
                    const elRect = thumb.getBoundingClientRect();
                    const offset = (elRect.left + elRect.right) / 2 - (containerRect.left + containerRect.right) / 2;
                    thumbsContainer.scrollBy({
                        left: offset,
                        behavior: "smooth"
                    });
                }

                // Animation
                previewImg.style.transform = "scale(1.01)";
                setTimeout(() => previewImg.style.transform = "", 420);
            }

            // Click handlers
            thumbs.forEach((t) => {
                const idx = parseInt(t.dataset.idx, 10);
                t.addEventListener("click", (e) => {
                    e.preventDefault();
                    setActive(idx);
                }, {
                    passive: true
                });

                // Keyboard support
                t.addEventListener("keydown", (ev) => {
                    if (ev.key === "Enter" || ev.key === " ") {
                        ev.preventDefault();
                        t.click();
                    }
                });
            });

            // Keyboard navigation
            if (thumbsContainer) {
                thumbsContainer.addEventListener("keydown", (e) => {
                    if (e.key === "ArrowRight") setActive(Math.min(activeIndex + 1, thumbs.length - 1));
                    if (e.key === "ArrowLeft") setActive(Math.max(activeIndex - 1, 0));
                    if (e.key === "Home") setActive(0);
                    if (e.key === "End") setActive(thumbs.length - 1);
                });
            }

            // Initial active
            setActive(0, {
                scrollThumbIntoView: false
            });

            // Autoplay
            let autoplayTimer = null;
            const AUTOPLAY_DELAY = 5000;

            function startAutoplay() {
                if (autoplayTimer) return;
                autoplayTimer = setInterval(() => {
                    setActive((activeIndex + 1) % thumbs.length);
                }, AUTOPLAY_DELAY);
            }

            function stopAutoplay() {
                if (autoplayTimer) {
                    clearInterval(autoplayTimer);
                    autoplayTimer = null;
                }
            }

            if (thumbs.length > 1) {
                startAutoplay();
                [thumbsContainer, previewWrapper].forEach((el) => {
                    el.addEventListener("mouseenter", stopAutoplay, {
                        passive: true
                    });
                    el.addEventListener("mouseleave", startAutoplay, {
                        passive: true
                    });
                    el.addEventListener("touchstart", stopAutoplay, {
                        passive: true
                    });
                    el.addEventListener("touchend", startAutoplay, {
                        passive: true
                    });
                });
            }
        })();

        // Copy Gift Number
        document.querySelectorAll(".copy-btn").forEach((btn) => {
            btn.addEventListener("click", () => {
                const number = btn.dataset.copy;

                if (navigator.clipboard) {
                    navigator.clipboard.writeText(number).then(() => {
                        btn.textContent = "Tersalin!";
                        btn.style.background = "var(--gold-light, #d4af37)";

                        setTimeout(() => {
                            btn.textContent = "Copy";
                            btn.style.background = "";
                        }, 1500);
                    });
                }
            });
        });

        (function() {
            const form = document.getElementById("commentForm");
            const commentList = document.getElementById("commentList");

            if (!commentList) return;

            // Escape HTML
            function esc(s) {
                return (s || "").toString()
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;");
            }

            // Ambil komentar dari server (data attribute)
            let comments = JSON.parse(commentList.dataset.comments || "[]");

            function renderComments() {
                if (!comments.length) {
                    commentList.innerHTML = `
                <div class="comment" style="text-align:center;color:var(--text-light);">
                    Belum ada ucapan. Jadilah yang pertama memberi doa.
                </div>
            `;
                    return;
                }

                commentList.innerHTML = comments.map(c => `
            <div class="comment">
                <div class="meta">
                    <div class="left">
                        <div class="guest-name">${esc(c.nama_tamu)}</div>
                        <div class="guest-count">${c.jumlah_orang} orang</div>
                    </div>
                    <div class="right">
                        <span class="badge ${esc(c.status_hadir)}">
                            ${c.status_hadir === "hadir" ? "Hadir" :
                              c.status_hadir === "tidak_hadir" ? "Tidak Hadir" :
                              "Mungkin"}
                        </span>
                    </div>
                </div>
                <div class="message">${esc(c.ucapan)}</div>
            </div>
        `).join("");
            }

            // Tampilkan komentar awal
            renderComments();

            // Jika form tidak ada (tamu sudah isi), hentikan
            if (!form) return;

            // Submit form
            form.addEventListener("submit", function(e) {
                e.preventDefault();

                const tamuId = document.getElementById('tamuId').value;

                const attendance = form.attendance.value;
                const guestCount = parseInt(form.guestCount.value) || 1;
                const message = form.message.value.trim();

                // Validation
                if (!attendance) return Swal.fire("Pilih kehadiran", "", "warning");
                if (!message) return Swal.fire("Tuliskan ucapan", "", "warning");

                // Kirim ke server
                fetch(`/tamu/${tamuId}/update-wish`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            status_hadir: attendance,
                            jumlah_orang: guestCount,
                            ucapan: message
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire("Berhasil!", "Ucapan Anda tersimpan.", "success");

                            // Tambahkan komentar ke list (tanpa reload)
                            comments.unshift({
                                nama_tamu: document.getElementById("name").value,
                                status_hadir: attendance,
                                jumlah_orang: guestCount,
                                ucapan: message
                            });

                            renderComments();

                            // Sembunyikan form
                            form.style.display = "none";
                        }
                    });
            });

        })();

        // Scroll Animation Observer
        document.addEventListener("DOMContentLoaded", () => {
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add("visible");
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1
                }
            );

            document.querySelectorAll("[data-anim]").forEach((el) => observer.observe(el));
        });
    </script>
</body>

</html>
