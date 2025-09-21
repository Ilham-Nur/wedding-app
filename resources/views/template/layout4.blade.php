@php
    $assetPath = 'layout_undangan/' . ($wedding->layout->folder_path ?? 'default');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <title>Wedding Invitation</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@400;500&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset($assetPath . '/style.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>

<body style="background-color: #f2efe7">
    <div class="mobile-view">
        <section id="hero-page">
            <div class="hero" style="background-color: #f6ede1">
                <img src="{{ asset('layout_undangan/layout4/gallery/background2.png') }}" alt="Wedding Background"
                    data-aos="fade-in" data-aos-duration="1500" data-aos-delay="300" />
                <!-- <div class="bubbles"></div> -->
                <div class="content">
                    <h2 data-aos="fade-in" data-aos-duration="1000">
                        Undangan Pernikahan
                    </h2>
                    <h1 data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200">
                        @if (isset($tamu))
                            <span style="font-size: 1.2rem; display:block; margin-bottom:10px;">
                                Dear {{ $tamu->nama_tamu }},
                            </span>
                        @endif

                        Panji
                        <br>&
                        <br>Frisca
                    </h1>
                    <p>{{ \Carbon\Carbon::parse($wedding->tanggal)->translatedFormat('l, d F Y') }}</p>
                    <a href="#" class="button-invitation" id="button-inv">
                        Buka Undangan
                    </a>
                </div>
            </div>
        </section>
        <section id="main-content" class="hidden">
            <div class="content-audio">
                <div class="music-button" id="musicButton">
                    <img src="{{ asset('layout_undangan/layout4/gallery/icon-music.png') }}" alt="Music Icon" />
                </div>
                <audio id="mySong">
                    <source src="{{ asset('storage/' . $wedding->file_musik) }}" type="audio/mp3" />
                </audio>
            </div>
            <div class="home">
                <div class="side-text left">Panji & Frisca</div>
                <div class="side-text right">{{ \Carbon\Carbon::parse($wedding->tanggal)->translatedFormat('d F Y') }}
                </div>
                <img src="{{ asset('storage/' . $wedding->foto_utama) }}" class="main-gallery" />
            </div>
            <div class="container-quote animate__animated animate__fadeInUp animate__delay-1s">
                <div class="content-quote">
                    <h3 class="animate__animated animate__bounceIn animate__delay-2s" style="font-style: italic">
                        Pesan berkah dari Allah
                        <span style="font-family: serif">﷽</span>
                    </h3>
                    <p class="animate__animated animate__fadeIn animate__delay-3s"
                        style="font-style: italic; font-family: 'Georgia', serif">
                        Artinya: "Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan
                        untukmu pasangan-pasangan dari jenismu sendiri, agar kamu merasa tenteram
                        dan merasa nyaman dengan mereka, dan Dia menanamkan di antara kalian
                        rasa kasih sayang dan cinta. Sungguh, di dalam itu benar-benar terdapat
                        tanda bagi orang yang berpikir."
                    </p>
                    <p class="animate__animated animate__fadeIn animate__delay-4s"
                        style="font-style: italic; font-family: 'Georgia', serif">
                        (QS. Ar-Rum: 21)
                    </p>
                </div>
            </div>

            <section id="couple">
                <div class="bg-image"></div>
                <div class="title">Mempelai</div>



                <div class="couple-container">
                    <!-- Groom -->
                    <div class="person">
                        <div class="photo-wrapper">
                            <img src="{{ asset('layout_undangan/layout4/gallery/frame_img_couple.png') }}"
                                alt="Frame" class="photo-frame" />
                            <div class="photo">
                                <img src="{{ asset('storage/' . $wedding->foto_suami) }}" alt="Frame"
                                    class="photo-frame" />
                            </div>
                        </div>
                        <div class="name">{{ $wedding->nama_pria }}</div>
                        <div class="relation">Putra Dari</div>
                        <div class="parents">{{ $wedding->nama_ayah_suami }} dan {{ $wedding->nama_ibu_suami }}</div>
                        <!-- <div class="link">@ourwedding.link</div> -->
                    </div>

                    <!-- Bride -->
                    <div class="person">
                        <div class="photo-wrapper">
                            <img src="{{ asset('layout_undangan/layout4/gallery/frame_img_couple.png') }}"
                                alt="Frame" class="photo-frame" />
                            <div class="photo">
                                <img src="{{ asset('storage/' . $wedding->foto_istri) }}" alt="Bride" />
                            </div>
                        </div>
                        <div class="name">{{ $wedding->nama_wanita }}</div>
                        <div class="relation">Putri Dari</div>
                        <div class="parents">{{ $wedding->nama_ayah_istri }} dan {{ $wedding->nama_ibu_istri }} </div>
                        <!-- <div class="link">@ourwedding.link</div> -->
                    </div>
                </div>
            </section>


            <div class="contain section" id="gallery">
                <h1 class="Judul animate__animated animate__fadeInUp">
                    Moment <span class="highlight">Bahagia Kami</span>
                </h1>
                @if ($wedding->galeris->isNotEmpty())
                    <div class="gallery-container">

                        {{-- 2. Loop pertama untuk menampilkan gambar utama (main-image) --}}
                        <div class="main-image">
                            @foreach ($wedding->galeris as $foto)
                                {{-- Ambil path gambar dari database dan gunakan helper asset() --}}
                                <img src="{{ asset('storage/' . $foto->file_path) }}"
                                    alt="{{ $foto->judul ?? 'Foto Galeri' }}">
                            @endforeach
                        </div>

                        {{-- 3. Loop kedua untuk menampilkan gambar kecil (thumbnails) --}}
                        <div class="thumbnails">
                            @foreach ($wedding->galeris as $foto)
                                {{-- Gunakan variabel $loop->index untuk mengisi data-index secara otomatis --}}
                                <img src="{{ asset('storage/' . $foto->file_path) }}"
                                    alt="{{ $foto->judul ?? 'Thumbnail' }}" data-index="{{ $foto->urutan }}">
                            @endforeach
                        </div>

                    </div>
                @else
                    {{-- 4. Tampilkan pesan ini jika tidak ada foto sama sekali --}}
                    <p class="text-center">Galeri foto akan segera ditambahkan.</p>
                @endif
            </div>
            <div class="container-calender section" id="date">
                <h1 class="Judul animate__animated animate__fadeInUp">
                    <span class="highlight">Acara</span> Diselenggarakan
                </h1>
                <div class="simply-countdown"></div>
            </div>
            <div class="container-marriage section" id="location">
                @foreach ($wedding->lokasis as $lokasi)
                    <div class="card-location">
                        <div class="card-header">
                            <h2>{{ $lokasi->nama_acara }}</h2>
                        </div>
                        <div class="card-content">
                            <p class="date">
                                {{ \Carbon\Carbon::parse($lokasi->tanggal)->translatedFormat('l, d F Y') }}</p>
                            <p class="time">
                                <i class="fa fa-clock-o"></i> pukul
                                {{ \Carbon\Carbon::parse($lokasi->waktu_mulai)->format('H:i') }} –
                                {{ $lokasi->waktu_selesai ? \Carbon\Carbon::parse($lokasi->waktu_selesai)->format('H:i') : 'selesai' }}
                            </p>
                            <p class="address">
                                <i class="fa fa-map-marker"></i> {{ $lokasi->alamat }}
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ $lokasi->maps_link }}" target="_blank" class="btn-location">
                                Lihat lokasi
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if (isset($tamu) && $tamu->show_gift)
                <div class="Gifts section animate__animated animate__fadeInUp" id="gift">
                    <!-- Love Gift Section -->
                    <section class="love-gift">
                        <h2 class="section-love animate__animated animate__fadeInLeft">
                            Tanda Kasih
                        </h2>
                        <p>
                            <i>Dengan hormat, bagi Anda yang ingin memberikan tanda kasih
                                kepada kami, dapat melalui:</i>
                        </p>
                        <div class="container-bank">
                            @foreach ($wedding->gifts as $rekening)
                                @php
                                    // buat id unik untuk tombol copy
                                    $copyId = 'rekening-' . $rekening->id;
                                @endphp
                                <div class="card-bank animate__animated animate__fadeInLeft">
                                    <img src="{{ asset('layout_undangan/layout4/gallery/' . $rekening->bank_nama . '.png') }}"
                                        alt="{{ $rekening->bank_nama }} Logo" style="margin-top: 5px" />
                                    <p>No. Rekening: <strong
                                            id="{{ $copyId }}">{{ $rekening->no_rekening }}</strong></p>
                                    <p>a.n {{ $rekening->atas_nama }}</p>
                                    @if ($rekening->catatan)
                                        <p><i>{{ $rekening->catatan }}</i></p>
                                    @endif
                                    <button onclick="copyToClipboard('{{ $copyId }}')">
                                        Salin No. Rekening
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>
            @endif
            @php
                $turutPria = trim(strip_tags($wedding->turut_mengundang_pria));
                $turutWanita = trim(strip_tags($wedding->turut_mengundang_wanita));
            @endphp

            @if (!empty($turutPria))
                <div class="container-mengundang-pria">
                    <h3 class="title-mengundang" style="font-family: 'Great Vibes', cursive;
    font-size: 2em;">
                        Turut megundang pihak Laki-laki</h3>
                    <div class="content-mengundang">
                        {!! $wedding->turut_mengundang_pria !!}
                    </div>
                </div>
            @endif

            @if (!empty($turutWanita))
                <div class="container-mengundang-wanita">
                    <h3 class="title-mengundang" style="font-family: 'Great Vibes', cursive;
    font-size: 2em;">
                        Turut megundang pihak Perempuan</h3>
                    <div class="content-mengundang">
                        {!! $wedding->turut_mengundang_wanita !!}
                    </div>
                </div>
            @endif


            <div class="container-wish section">
                <h2 class="section-wishes animate__animated">Konfirmasi Kehadiran & Ucapan</h2>

                @if (isset($tamu))
                    @if ($tamu->status_hadir === 'belum_konfirmasi')
                        <div class="form-container">
                            <h3>Isi Kehadiran & Ucapan Anda:</h3>

                            <!-- Status Hadir -->
                            <label for="status_hadir">Konfirmasi Kehadiran:</label>
                            <select id="status_hadir" name="status_hadir" class="wish-input" required>
                                <option value="">-- Pilih Kehadiran --</option>
                                <option value="belum_konfirmasi"
                                    {{ $tamu->status_hadir == 'belum_konfirmasi' ? 'selected' : '' }}>Belum Konfirmasi
                                </option>
                                <option value="hadir" {{ $tamu->status_hadir == 'hadir' ? 'selected' : '' }}>Hadir
                                </option>
                                <option value="tidak_hadir"
                                    {{ $tamu->status_hadir == 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                <option value="mungkin" {{ $tamu->status_hadir == 'mungkin' ? 'selected' : '' }}>
                                    Mungkin</option>
                            </select>

                            <!-- Jumlah Orang -->
                            <label for="jumlah_orang">Jumlah Orang:</label>
                            <input type="number" id="jumlah_orang" name="jumlah_orang" class="wish-input"
                                min="1" value="{{ $tamu->jumlah_orang }}" required>

                            <!-- Ucapan -->
                            <label for="ucapan">Ucapan:</label>
                            <textarea id="ucapan" name="ucapan" class="wish-textarea" placeholder="Tulis ucapanmu di sini...">{{ $tamu->ucapan }}</textarea>

                            <!-- Tombol submit -->
                            <button class="submit-button" id="submitWishBtn">Kirim</button>
                        </div>
                    @endif

                    <!-- Daftar ucapan tamu -->
                    <div class="message-box" id="messageBox">
                        @if ($tamusWithUcapan->count())
                            @foreach ($tamusWithUcapan as $wish)
                                <div class="wish-card">
                                    <h4 class="wish-name">{{ $wish->nama_tamu }}
                                    </h4>
                                    <span
                                        class="badge {{ $wish->status_hadir }}">{{ ucfirst($wish->status_hadir) }}</span>
                                    <p class="wish-text">{{ $wish->ucapan }}</p>
                                </div>
                            @endforeach
                        @else
                            <p>Belum ada yang mengirimkan ucapan, jadilah yang pertama</p>
                        @endif
                    </div>
                @endif

            </div>

            <div class="footer">
                <p>powered by <b>Arcdev</b></p>
                <img src="{{ asset('layout_undangan/layout4/gallery/instagram.png') }}" class="footer-img" />

            </div>

            <div class="menu-container">
                <div class="menu-options">
                    <button onclick="scrollToSection('couple', this)" class="menu-button">
                        <i class="fa-solid fa-person-half-dress"></i>
                        <span class="menu-text">Couple</span>
                    </button>
                    <button onclick="scrollToSection('gallery', this)" class="menu-button">
                        <i class="fa-regular fa-images"></i>
                        <span class="menu-text">Gallery</span>
                    </button>
                    <button onclick="scrollToSection('date', this)" class="menu-button">
                        <i class="fa-regular fa-calendar"></i>
                        <span class="menu-text">Date</span>
                    </button>
                    <button onclick="scrollToSection('location', this)" class="menu-button">
                        <i class="fa-solid fa-location-dot"></i>
                        <span class="menu-text">Location</span>
                    </button>
                    <button onclick="scrollToSection('gift', this)" class="menu-button">
                        <i class="fa-solid fa-gift"></i>
                        <span class="menu-text">Gift</span>
                    </button>
                </div>
            </div>
        </section>
    </div>
    <div class="desktop-view">
        <div class="image-container">
            <img src="src=" {{ asset('layout_undangan/layout4/gallery/desktop-image.jpg') }}
                alt="Foto Pernikahan" />
        </div>
        <div class="text-desktop">
            Silahkan akses undangan ini melalui hand phone anda. Terima kasih.
        </div>
    </div>

    <script src="https://kit.fontawesome.com/f89fc2c44e.js" crossorigin="anonymous"></script>
    <script src="countdown/simplyCountdown.min.js"></script>
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('submitWishBtn').addEventListener('click', function(e) {
            e.preventDefault();

            const statusHadir = document.getElementById('status_hadir').value;
            const jumlahOrang = document.getElementById('jumlah_orang').value;
            const ucapan = document.getElementById('ucapan').value;

            if (!statusHadir || !jumlahOrang) {
                Swal.fire('Peringatan', 'Harap isi status kehadiran dan jumlah orang.', 'warning');
                return;
            }

            fetch(`/tamu/{{ $tamu->id }}/update-wish`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status_hadir: statusHadir,
                        jumlah_orang: jumlahOrang,
                        ucapan: ucapan
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil', 'Ucapan dan kehadiran berhasil diperbarui!', 'success');

                        // update message-box tanpa reload
                        const box = document.getElementById('messageBox');
                        box.innerHTML = `
                <div class="wish-card">
        <h4 class="wish-name">{{ $tamu->nama_tamu }}</h4>
        <span class="badge ${statusHadir.toLowerCase()}">${statusHadir.charAt(0).toUpperCase() + statusHadir.slice(1)}</span>
        <p class="wish-text">${ucapan}</p>
    </div>
            `;
                    } else {
                        Swal.fire('Error', 'Terjadi kesalahan, silakan coba lagi.', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Terjadi kesalahan server.', 'error');
                });
        });
    </script>
    <script>
        // for (let i = 0; i < 15; i++) {
        //     let bubble = document.createElement("div");
        //     bubble.classList.add("bubble");
        //     bubble.style.left = Math.random() * 100 + "vw";
        //     bubble.style.animationDuration = Math.random() * 4 + 4 + "s";
        //     bubble.style.animationDelay = Math.random() * 4 + "s";
        //     document.querySelector(".bubbles").appendChild(bubble);
        // }
        document
            .getElementById("button-inv")
            .addEventListener("click", function() {
                const invitationContent = document.getElementById("main-content");
                invitationContent.classList.remove("hidden");
                invitationContent.classList.add("fade-in");

                const pageIntro = document.getElementById("hero-page");
                pageIntro.classList.add("hidden");
            });
        document.addEventListener("DOMContentLoaded", () => {
            const sections = document.querySelectorAll(".section");
            const buttons = document.querySelectorAll(".menu-button");

            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            const id = entry.target.id;

                            buttons.forEach((button) => button.classList.remove("active"));

                            const activeButton = document.querySelector(
                                `.menu-button[onclick*="${id}"]`
                            );
                            if (activeButton) {
                                activeButton.classList.add("active");
                            }
                        }
                    });
                }, {
                    root: null,
                    threshold: 0.6,
                }
            );

            sections.forEach((section) => observer.observe(section));
        });

        function scrollToSection(sectionId, button) {
            const section = document.getElementById(sectionId);
            if (section) {
                section.scrollIntoView({
                    behavior: "smooth"
                });
            }

            const buttons = document.querySelectorAll(".menu-button");
            buttons.forEach((btn) => btn.classList.remove("active"));
            button.classList.add("active");
        }
        const thumbnails = document.querySelectorAll(".thumbnails img");
        const mainImages = document.querySelectorAll(".main-image img");
        let currentIndex = 0;
        let autoSlideInterval;

        // Fungsi untuk mengatur gambar aktif
        function setActiveImage(index) {
            // Hapus kelas aktif dari semua thumbnail dan gambar utama
            thumbnails.forEach((thumb) => thumb.classList.remove("active"));
            mainImages.forEach((img) => img.classList.remove("active"));

            // Tambahkan kelas aktif ke thumbnail dan gambar yang dipilih
            thumbnails[index].classList.add("active");
            mainImages[index].classList.add("active");
        }

        // Fungsi untuk auto-slide
        function startAutoSlide() {
            autoSlideInterval = setInterval(() => {
                currentIndex = (currentIndex + 1) % mainImages.length; // Perpindahan ke gambar berikutnya
                setActiveImage(currentIndex);
            }, 3000); // Interval waktu (3 detik)
        }

        // Inisialisasi awal saat halaman dimuat
        setActiveImage(currentIndex); // Set thumbnail pertama dan gambar utama sebagai aktif

        // Hentikan auto-slide ketika thumbnail di-klik
        thumbnails.forEach((thumbnail, index) => {
            thumbnail.addEventListener("click", () => {
                clearInterval(autoSlideInterval); // Hentikan auto-slide
                currentIndex = index; // Set index ke gambar yang di-klik
                setActiveImage(currentIndex); // Tampilkan gambar yang dipilih
                startAutoSlide(); // Mulai ulang auto-slide
            });
        });

        // Mulai auto-slide saat halaman dimuat
        startAutoSlide();

        // Logika drag untuk thumbnail slider
        const thumbnailContainer = document.querySelector(".thumbnails");
        let isDown = false;
        let startX, scrollLeft;

        thumbnailContainer.addEventListener("mousedown", (e) => {
            isDown = true;
            thumbnailContainer.classList.add("active");
            startX = e.pageX - thumbnailContainer.offsetLeft;
            scrollLeft = thumbnailContainer.scrollLeft;
        });

        thumbnailContainer.addEventListener("mouseleave", () => {
            isDown = false;
        });

        thumbnailContainer.addEventListener("mouseup", () => {
            isDown = false;
        });

        thumbnailContainer.addEventListener("mousemove", (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - thumbnailContainer.offsetLeft;
            const walk = (x - startX) * 2; // Kecepatan scroll (modifikasi sesuai kebutuhan)
            thumbnailContainer.scrollLeft = scrollLeft - walk;
        });
        const musicButton = document.getElementById("musicButton");
        const mySong = document.getElementById("mySong");
        const lihatUndanganBtn = document.getElementById("button-inv");

        mySong.addEventListener("ended", function() {
            mySong.currentTime = 0;
            mySong.play();
        });

        musicButton.addEventListener("click", function() {
            if (mySong.paused) {
                mySong.play();
                musicButton.classList.add("active");
            } else {
                mySong.pause();
                musicButton.classList.remove("active");
            }
        });

        lihatUndanganBtn.addEventListener("click", function() {
            if (mySong.paused) {
                mySong.play();
                musicButton.classList.add("active");
            }
        });

        function copyToClipboard(elementId) {
            var text = document.getElementById(elementId).innerText;
            var textArea = document.createElement("textarea");
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("copy");
            document.body.removeChild(textArea);

            // Membuat pop-up kecil
            var alertBox = document.createElement("div");
            alertBox.innerText = "Nomor rekening telah disalin!";
            alertBox.style.position = "fixed";
            alertBox.style.top = "80%"; // Mengatur posisi sedikit lebih bawah dari tengah
            alertBox.style.left = "50%";
            alertBox.style.transform = "translateX(-50%)"; // Hanya horizontal center
            alertBox.style.padding = "10px";
            alertBox.style.backgroundColor = "#75975e";
            alertBox.style.color = "white";
            alertBox.style.borderRadius = "10px";
            alertBox.style.zIndex = "9999";

            // Menampilkan pop-up dan menghapusnya setelah 2 detik
            document.body.appendChild(alertBox);
            setTimeout(function() {
                document.body.removeChild(alertBox);
            }, 2000);
        }

        simplyCountdown(".simply-countdown", {
            year: 2025,
            month: 7,
            day: 29,
            hours: 0,
            minutes: 0,
            seconds: 0,
            words: {
                days: {
                    singular: " DAYS",
                    plural: " DAYS"
                },
                hours: {
                    singular: " HOURS",
                    plural: " HOURS"
                },
                minutes: {
                    singular: " MINUTES",
                    plural: " MINUTES"
                },
                seconds: {
                    singular: " SECONDS",
                    plural: " SECONDS"
                },
            },
        });

        // Pilih elemen-elemen yang akan dianimasikan
        const elementsToAnimate = document.querySelectorAll(
            ".icon-groom, .desc-bride, .highlights, .Judul, .simply-countdown, .container-marriage .title, .container-marriage .map-iframe, .container-marriage .date, .container-marriage .time, .container-marriage .location, .container-marriage .btn-location, .container-reception .title, .container-reception .map-iframe, .container-reception .date, .container-reception .time, .container-reception .location, .container-reception .btn-location ,.container-section, .Gifts, .card-bank, .section-love, .btn-streaming, .btn-instagram ,.wish-form-input, .wish-form-textarea, .wish-form-button, .footer-img"
        );

        // Konfigurasi observer
        const observerOptions = {
            root: null, // viewport
            rootMargin: "0px",
            threshold: 0.5, // elemen harus terlihat 50% untuk memicu animasi
        };

        // Callback function untuk observer
        const observerCallback = (entries, observer) => {
            entries.forEach((entry) => {
                // Jika elemen masuk ke dalam tampilan
                if (entry.isIntersecting) {
                    // Tentukan animasi berdasarkan kelas elemen
                    let animationClass = "";

                    if (entry.target.classList.contains("container-section")) {
                        animationClass = "animate__zoomIn";
                    } else if (entry.target.classList.contains("footer-img")) {
                        animationClass = "animate__fadeInUp"; // Footer img muncul dengan fadeInUp
                    } else if (entry.target.classList.contains("Gifts")) {
                        animationClass = "animate__fadeInLeft"; // Animasi untuk Gifts
                    } else if (entry.target.classList.contains("btn-streaming")) {
                        animationClass = "animate__fadeInUp"; // Animasi untuk tombol streaming
                    } else {
                        // Default animasi lainnya
                        animationClass = "animate__fadeInUp";
                    }

                    // Menambahkan kelas animasi
                    entry.target.classList.add("animate__animated", animationClass);
                    observer.unobserve(entry.target); // Hentikan pemantauan setelah animasi
                }
            });
        };

        // Membuat observer
        const observer = new IntersectionObserver(
            observerCallback,
            observerOptions
        );

        // Mengamati setiap elemen yang ingin dianimasikan
        elementsToAnimate.forEach((element) => {
            observer.observe(element);
        });
    </script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
