{{--
Pastikan Controller mengirimkan variabel '$wedding' yang berisi data layout dan galeri.
Contoh di UndanganController:
$wedding = Pernikahan::with(['layout', 'galeris'])->where('slug', $slug)->firstOrFail();
--}}
@php
    // Membuat path aset secara dinamis dan aman.
    // Jika karena suatu hal data layout tidak ada, path tidak akan error.
    $assetPath = 'layout_undangan/' . ($wedding->layout->folder_path ?? 'default');
@endphp

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Undangan Pernikahan {{ $wedding->nama_pria ?? 'Mempelai Pria' }} &
        {{ $wedding->nama_wanita ?? 'Mempelai Wanita' }}</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Birthstone&family=Dancing+Script:wght@400..700&family=Great+Vibes&family=Host+Grotesk:ital,wght@0,300..800;1,300..800&family=Oleo+Script:wght@400;700&family=Pacifico&family=Redressed&display=swap"
        rel="stylesheet">
 <script src="{{ asset($assetPath . '/countdown/simplyCountdown.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    </section>
    {{-- Aset dari CDN (Online) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sacramento&family=Work+Sans&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Aset dari folder /public (Lokal) --}}
    <link rel="stylesheet" href="{{ asset($assetPath . '/countdown/simplyCountdown.theme.default.css') }}" />
    <link rel="stylesheet" href="{{ asset($assetPath . '/style.css') }}">
</head>

<body style="background-color: #F8F5E8;">
    <section id="hero-page">
        <div
            class="hero w-100 h-100 mx-auto p-3 text-center d-flex justify-content-center align-items-center text-white section">
            <main>
                <h4 data-aos="fade-in" data-aos-delay="200">Kepada Bapak/Ibu/Saudara/i,</h4>
                <h1 data-aos="zoom-in" data-aos-delay="400">Tandrio & Pengantin</h1>
                <p data-aos="fade-up" data-aos-delay="600">Akan melangsungkan resepsi pernikahan dalam:</p>
                <div class="simply-countdown" data-aos="fade-up" data-aos-delay="800"></div>
                <button id="button-inv" class="btn btn-lg mt-4" data-aos="fade-in" data-aos-delay="1000">
                    <i class="fa-regular fa-envelope-open"></i> Buka Undangan
                </button>
            </main>
        </div>
    </section>
    <section id="undanganSection" class="undangan-section text-center hidden">
        <div id="hero"
            class="hero w-100 h-100 mx-auto p-3 text-center d-flex justify-content-center align-items-center text-white section">
            <main>
                <h4>Kepada Bapak/Ibu/Saudara/i,</h4>
                <h1>Tandrio & Pengantin</h1>
                <p>Akan melangsungkan resepsi pernikahan dalam:</p>
                <div class="simply-countdown"></div>
            </main>
        </div>
        <div id="page">
            <div id="fh5co-couple">
                <div class="container section" id="married">
                    <div class="row">
                        <div class="text-center fh5co-heading animate__animated animate__fadeIn">
                            <h2 data-aos="zoom-in" data-aos-duration="1000">Assalamu'alaikum Wr. Wb.</h2>
                            <p style="color: #666666;" data-aos="fade-up" data-aos-duration="600">
                                Tanpa mengurangi rasa hormat. Kami mengundang Bapak/Ibu/Saudara/i serta Kerabat sekalian
                                untuk menghadiri acara pernikahan kami:
                            </p>
                        </div>
                    </div>
                    <div class="couple-wrap">
                        <div class="couple-half">
                            <div class="bride" data-aos="zoom-in" data-aos-duration="1000">
                                <img src="image/Wedding.jpg" alt="groom" class="img-responsive">
                            </div>
                            <div class="desc-bride" data-aos="fade-up" data-aos-duration="1000">
                                <h3>Maulidan Nashuha</h3>
                                <p>
                                    <span style="color: #bf9b73">Putra Kedua dari</span><br>
                                    <span class="parents-font" style="font-family:Dancing Script, serif;">Bapak Asri
                                        Abdurrahman</span><br>
                                    <span class="parents-font" style="font-family:Dancing Script, serif;">Ibu
                                        Marliana</span>
                                <div id="social-media-molid">
                                    <ul class="fh5co-social-icons">
                                        <li><a target="_blank" href="https://github.com/maulidandev"><i
                                                    class="fa-brands fa-github"></i></a></li>
                                        <li><a target="_blank" href="https://www.linkedin.com/in/maulidandev/"><i
                                                    class="fa-brands fa-linkedin"></i></a></li>
                                        <li><a target="_blank" href="https://www.instagram.com/maulidannashuha/"><i
                                                    class="fa-brands fa-instagram"></i></a></li>
                                        <li><a target="_blank" href="https://www.facebook.com/maulidannashuha"><i
                                                    class="fa-brands fa-facebook"></i></a></li>
                                        <li><a target="_blank" href="https://twitter.com/ngodingsolusi"><i
                                                    class="fa-brands fa-twitter"></i></a></li>
                                    </ul>
                                </div>
                                </p>
                            </div>
                        </div>

                        <h2 class="icon-groom" data-aos="zoom-in" data-aos-duration="1000">&</h2>

                        <div class="couple-half">
                            <div class="desc-bride" data-aos="fade-up" data-aos-duration="1200">
                                <h3>Aisyah Humaira</h3>
                                <p>
                                    <span style="color: #bf9b73">Putri Pertama dari</span><br>
                                    <span class="parents-font" style="font-family:Dancing Script, serif;">Bapak Ahmad
                                        Fauzi</span><br>
                                    <span class="parents-font" style="font-family:Dancing Script, serif;">Ibu Siti
                                        Khadijah</span>
                                <div id="social-media-aisyah">
                                    <ul class="fh5co-social-icons">
                                        <li><a target="_blank" href="https://www.instagram.com/aisyahhumaira/"><i
                                                    class="fa-brands fa-instagram"></i></a></li>
                                        <li><a target="_blank" href="https://www.facebook.com/aisyahhumaira"><i
                                                    class="fa-brands fa-facebook"></i></a></li>
                                    </ul>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="quote-section">
            <p class="quote-text" data-aos="fade-up" data-aos-duration="1200">
                "Mereka akan menjadi suami istri yang berlimpah berkah keberuntungan Apabila keduanya
                memiliki: Keyakinan, kedermawanan, keterampilan, Ucapan saling mencintai satu sama lain dan hidup sesuai
                dengan Dhamma."
            </p>
            <p class="quote-source" data-aos="fade-up" data-aos-duration="1400">
                (Angutara Nikaya Bab VI.3; Sutta ke 53)
            </p>
        </div>

        <div class="containers section" id="calender">
            <h1 style="color: #bf9b73;" data-aos="zoom-in" data-aos-duration="1000">Tempat dan Waktu</h1>

            <div class="event-container">
                <div class="event-card">
                    <h2 data-aos="zoom-in" data-aos-duration="1400">AKAD</h2>
                    <p data-aos="fade-up" data-aos-duration="1600">
                        Minggu, 23 Juni 2024<br>08.00 WIB - Selesai
                    </p>
                    <div class="map" data-aos="fade-up" data-aos-duration="1700">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24987.523941708336!2d104.03009248498188!3d1.1173941644051053!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d9896b04a72593%3A0x6f022eb0aedf5969!2sKedai%20Kopi%20Aroma!5e1!3m2!1sid!2sid!4v1736496936969!5m2!1sid!2sid"
                            width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <p class="address" data-aos="fade-up" data-aos-duration="2000">
                        <i>NoLimit Indonesia<br>Jl. Setra Indah Utara II No. 1A, Sukagalih, Kec. Sukajadi,
                            Kota Bandung, Jawa Barat 40163</i>
                    </p>
                    <a href="https://www.google.com/maps/place/Kedai+Kopi+Aroma/@1.1241777,104.0258839,1075m/data=!3m2!1e3!4b1!4m6!3m5!1s0x31d9896b04a72593:0x6f022eb0aedf5969!8m2!3d1.1241723!4d104.0284642!16s%2Fg%2F11g7zv12q5?entry=ttu&g_ep=EgoyMDI1MDExNS4wIKXMDSoASAFQAw%3D%3D"
                        class="location-btn button" data-aos="zoom-in" data-aos-duration="2200" target="_blank">
                        <i class="fa-solid fa-location-arrow"></i> Petunjuk Lokasi
                    </a>
                </div>

                <div class="event-card">
                    <h2 data-aos="zoom-in" data-aos-duration="1400">RESEPSI</h2>
                    <p data-aos="fade-up" data-aos-duration="1600">
                        Minggu, 23 Juni 2024<br>10.00 WIB - Selesai
                    </p>
                    <div class="map" data-aos="fade-up" data-aos-duration="1800">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4679.842876092189!2d104.02277998319468!3d1.1363410031593042!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d98976f612502f%3A0x785768fdf2df3d7c!2sIndah%20Industrial%20Park!5e1!3m2!1sid!2sid!4v1736497149271!5m2!1sid!2sid"
                            width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <p class="address" data-aos="fade-up" data-aos-duration="2000">
                        <i>NoLimit Indonesia<br>Jl. Setra Indah Utara II No. 1A, Sukagalih, Kec. Sukajadi,
                            Kota Bandung, Jawa Barat 40163</i>
                    </p>
                    <a href="https://www.google.com/maps/place/Indah+Industrial+Park/@1.1363464,104.0201997,1075m/data=!3m2!1e3!4b1!4m6!3m5!1s0x31d98976f612502f:0x785768fdf2df3d7c!8m2!3d1.136341!4d104.02278!16s%2Fg%2F11c3hw6_8y?entry=ttu&g_ep=EgoyMDI1MDExNS4wIKXMDSoASAFQAw%3D%3D"
                        class="location-btn button" data-aos="zoom-in" data-aos-duration="2200" target="_blank">
                        <i class="fa-solid fa-location-arrow"></i> Petunjuk Lokasi
                    </a>
                </div>
            </div>
        </div>
        <div class="contain section" id="gallery" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="Judul" data-aos="zoom-in" data-aos-duration="1200"><span class="highlight">Moment</span> Bahagia
                Kami</h1>
            <p class="quote" data-aos="fade-up" data-aos-duration="1400">
                <i>"Aku tidak tahu dimana ujung perjalanan ini, aku tidak bisa menjanjikan apapun. Tapi,
                    selama aku mampu, mimpi-mimpi kita adalah prioritas."</i>
            </p>
            <!-- Box khusus untuk galeri -->
            <div class="gallery-container" data-aos="fade-up" data-aos-duration="1100">
                <!-- Main Image -->
                <div class="main-image">
                    <img src="image/image1.jpg" alt="Main Image" class="active">
                    <img src="image/image2.jpg" alt="Main Image">
                    <img src="image/image4.jpg" alt="Main Image">
                    <img src="image/image2.jpg" alt="Main Image">
                    <img src="image/image4.jpg" alt="Main Image">
                    <img src="image/image2.jpg" alt="Main Image">
                    <img src="image/image4.jpg" alt="Main Image">
                    <img src="image/image4.jpg" alt="Main Image">
                    <img src="image/image2.jpg" alt="Main Image">
                    <img src="image/image4.jpg" alt="Main Image">

                </div>

                <!-- Thumbnails -->
                <div class="thumbnails">
                    <img src="image/image1.jpg" alt="Thumbnail 1" data-index="0">
                    <img src="image/image2.jpg" alt="Thumbnail 2" data-index="1">
                    <img src="image/image4.jpg" alt="Thumbnail 4" data-index="2">
                    <img src="image/image2.jpg" alt="Thumbnail 2" data-index="3">
                    <img src="image/image4.jpg" alt="Thumbnail 4" data-index="4">
                    <img src="image/image2.jpg" alt="Thumbnail 2" data-index="5">
                    <img src="image/image4.jpg" alt="Thumbnail 4" data-index="6">
                    <img src="image/image4.jpg" alt="Thumbnail 4" data-index="7">
                    <img src="image/image2.jpg" alt="Thumbnail 2" data-index="8">
                    <img src="image/image4.jpg" alt="Thumbnail 4" data-index="9">
                </div>
            </div>
        </div>

        <div class="Gifts" data-aos="fade-up" data-aos-duration="1000">
            <!-- Love Gift Section -->
            <section class="love-gift">
                <h2 data-aos="zoom-in" data-aos-duration="1200">Love Gift</h2>
                <p data-aos="fade-up" data-aos-duration="1400"><i>Dengan hormat, bagi Anda yang ingin memberikan tanda
                        kasih kepada kami, dapat melalui:</i></p>
                <div class="container-bank">
                    <!-- BCA Card -->
                    <div class="card-bank" data-aos="fade-up" data-aos-duration="1000">
                        <img src="image/BCA.png" alt="BCA Logo">
                        <p>No. Rekening: <strong id="bca-number">2820297663</strong></p>
                        <p>a.n Tandrio</p>
                        <button onclick="copyToClipboard('bca-number')">Salin No. Rekening</button>
                    </div>

                    <!-- DANA Card -->
                    <div class="card-bank" data-aos="fade-up" data-aos-duration="1000">
                        <img src="image/BNI.png" alt="BNI Logo" style="margin-top: 5px;">
                        <p>No. Rekening: <strong id="bni-number">28202973424</strong></p>
                        <p>a.n Tandrio</p>
                        <button onclick="copyToClipboard('bni-number')">Salin No. Rekening</button>
                    </div>
                </div>
            </section>


            <!-- Ucapan & Doa Section -->
            <section class="ucapan-doa section" id="comment" data-aos="fade-up" data-aos-duration="1000">
                <h2 style="color:  #bf9b73;" data-aos="zoom-in" data-aos-duration="1200">Ucapan & Doa</h2>
                <form action="#" method="post" data-aos="fade-up" data-aos-duration="1400">
                    <div class="form-group" data-aos="fade-up" data-aos-duration="1600">
                        <label for="name">Nama</label>
                        <input type="text" id="name" name="name" placeholder="Masukkan nama Anda">
                    </div>
                    <div class="form-group" data-aos="fade-up" data-aos-duration="1800">
                        <label for="presensi">Presensi</label>
                        <select id="presensi" name="presensi">
                            <option value="" selected disabled>Pilih Presensi</option>
                            <option value="hadir">Hadir</option>
                            <option value="tidak_hadir">Tidak Hadir</option>
                        </select>
                    </div>
                    <div class="form-group" data-aos="fade-up" data-aos-duration="2000">
                        <label for="komentar">Komentar</label>
                        <textarea id="komentar" name="komentar" placeholder="Tulis komentar Anda"></textarea>
                    </div>
                    <div class="form-group" data-aos="fade-up" data-aos-duration="2200">
                        <label for="doa">Ucapan & Doa</label>
                        <textarea id="doa" name="doa" placeholder="Tulis Ucapan dan Doa"></textarea>
                    </div>
                    <button type="submit" class="send-button" data-aos="zoom-in" data-aos-duration="2400"><i
                            class="fa-regular fa-paper-plane" style="margin:5px;"></i>
                        Send</button>
                    <hr style="color: #ffffff;">
                    <div class="messages-container" data-aos="zoom-in" data-aos-duration="1000">
                        <div class="message-card">
                            <h3>Tandrio</h3>
                            <p>dwdawdwa</p>
                            <span>08/01/2025 16:56:39</span>
                        </div>
                        <div class="message-card">
                            <h3>Magician Smanda</h3>
                            <p>Happy Wedding buat bang Fahmi dan kakak Fahira.</p>
                            <span>10/10/2024 14:08:00</span>
                        </div>
                        <div class="message-card">
                            <h3>Bidan Witri</h3>
                            <p>Selamat menempuh hidup baru, semoga jadi keluarga sakinah, mawaddah, warohmah.</p>
                            <span>05/10/2024 22:16:46</span>
                        </div>
                    </div>
                </form>
            </section>
        </div>
        <div class="thank-you" data-aos="fade-down" data-aos-duration="1000">
            TERIMA KASIH<br>
            ATAS KEHADIRAN DAN DOA RESTUNYA<br>
            KAMI YANG BERBAHAGIA
        </div>

        <div class="couple-name" data-aos="zoom-in" data-aos-delay="500" data-aos-duration="1200">
            Ramdani & Yuli
        </div>

        <footer class="footer">
            <div class="copyright">
                Tandrio Digital<br>
                SmartApps Care &copy; 2025. All Rights Reserved
            </div>
            <div class="social-icons">
                <a href="#" target="_blank"><i class="fa-brands fa-instagram fa-lg"></i> </a>
                <a href="#" target="_blank"><i class="fa-brands fa-facebook"></i> </a>
                <a href="#" target="_blank"><i class="fa-solid fa-phone-volume"></i> </a>
            </div>
        </footer>
        <section id="menu">
            <div class="menu-container">
                <div class="fadein">
                    <div class="menu-options">
                        <button onclick="scrollToSection('hero', this)" class="menu-button"><i
                                class="fa-regular fa-clock"></i></button>
                        <button onclick="scrollToSection('married', this)" class="menu-button"><i
                                class="fa-solid fa-person-half-dress"></i></button>
                        <button onclick="scrollToSection('calender', this)" class="menu-button"><i
                                class="fa-regular fa-calendar"></i></button>
                        <button onclick="scrollToSection('gallery', this)" class="menu-button"><i
                                class="fa-regular fa-images"></i></button>
                        <button onclick="scrollToSection('comment', this)" class="menu-button"><i
                                class="fa-regular fa-comment"></i></button>
                    </div>
                </div>
                <div class="content-audio">
                    <div class="music-button" id="musicButton">
                        <img src="{{ asset('layout_undangan/layout1/image/icon-music.png') }}" alt="Music Icon">
                    </div>  
                    <audio id="mySong">
                        <source src="media/song.mp3" type="audio/mp3">
                    </audio>
                </div>

        </section>

    </section>


    <script>
        simplyCountdown('.simply-countdown', {
            year: 2025,
            month: 4,
            day: 29,
            hours: 0,
            minutes: 0,
            seconds: 0,
            words: {
                days: { singular: 'hari', plural: 'hari' },
                hours: { singular: 'jam', plural: 'jam' },
                minutes: { singular: 'menit', plural: 'menit' },
                seconds: { singular: 'detik', plural: 'detik' }
            }
        });
        document
            .getElementById("button-inv")
            .addEventListener("click", function () {
                const invitationContent =
                    document.getElementById("undanganSection");
                invitationContent.classList.remove("hidden");
                invitationContent.classList.add("fadein");

                const pageIntro = document.getElementById("hero-page");
                pageIntro.classList.add("hidden");
            });
        const musicButton = document.getElementById("musicButton");
        const mySong = document.getElementById("mySong");
        const lihatUndanganBtn = document.getElementById("button-inv");

        mySong.addEventListener("ended", function () {
            mySong.currentTime = 0;
            mySong.play();
        });

        musicButton.addEventListener("click", function () {
            if (mySong.paused) {
                mySong.play();
                musicButton.classList.add("active");
            } else {
                mySong.pause();
                musicButton.classList.remove("active");
            }
        });

        lihatUndanganBtn.addEventListener("click", function () {
            if (mySong.paused) {
                mySong.play();
                musicButton.classList.add("active");
            }
        });
        document.getElementById("button-inv").addEventListener("click", function (event) {
            event.preventDefault();

            document.getElementById("undanganSection").style.display = "block";

            AOS.refresh();
        });
    </script>

    <script src="{{ asset($assetPath . '/script.js') }}"></script>
    <script src="https://kit.fontawesome.com/f89fc2c44e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script> AOS.init();</script>
</body>

</html>