@php
    $assetPath = 'layout_undangan/' . ($wedding->layout->folder_path ?? 'layout7');
    $firstLokasi = $wedding->lokasis->first();
    $countdownTarget = $firstLokasi
        ? \Carbon\Carbon::parse($firstLokasi->tanggal . ' ' . ($firstLokasi->waktu_mulai ?? '08:00:00'))->toIso8601String()
        : \Carbon\Carbon::parse($wedding->tanggal)->startOfDay()->toIso8601String();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
<title>The Wedding of {{ $wedding->nama_pria }} &amp; {{ $wedding->nama_wanita }}</title>
<meta name="description" content="Undangan pernikahan {{ $wedding->nama_pria }} & {{ $wedding->nama_wanita }}" />

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Pinyon+Script&family=Jost:wght@300;400;500&display=swap" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset($assetPath . '/style.css') }}">
<link rel="stylesheet" href="{{ asset($assetPath . '/decor.css') }}">
</head>
<body class="is-locked">

<!-- COVER -->
<section id="cover" class="cover" data-screen-label="Cover">
  <div class="cover__bg" aria-hidden="true"></div>
  <div class="cover__veil" aria-hidden="true"></div>

  <div class="cover__inner">
    <p class="eyebrow">The Wedding Of</p>

    <div class="ornament ornament--top" aria-hidden="true">
      <svg viewBox="0 0 120 40" class="flourish"><use href="#flourish"></use></svg>
    </div>

    <h1 class="cover__names script">
      <span class="cover__name">{{ $wedding->nama_pria }}</span>
      <span class="amp">&amp;</span>
      <span class="cover__name">{{ $wedding->nama_wanita }}</span>
    </h1>

    <p class="cover__date">
      {{ \Carbon\Carbon::parse($wedding->tanggal)->translatedFormat('l, d F Y') }}
    </p>

    <div class="ornament ornament--bottom" aria-hidden="true">
      <svg viewBox="0 0 120 40" class="flourish flip"><use href="#flourish"></use></svg>
    </div>

    <div class="cover__guest">
      <p class="cover__to">Kepada Yth. Bapak/Ibu/Saudara/i</p>
      <p class="cover__guest-name" id="guestName">
        @if(isset($tamu)){{ $tamu->nama_tamu }}@else Tamu Undangan @endif
      </p>
    </div>

    <button class="btn btn--open" id="openBtn" type="button">
      <svg class="btn__icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6.5 12 13l9-6.5M3 6.5A1.5 1.5 0 0 1 4.5 5h15A1.5 1.5 0 0 1 21 6.5v11A1.5 1.5 0 0 1 19.5 19h-15A1.5 1.5 0 0 1 3 17.5z"/></svg>
      <span>Buka Undangan</span>
    </button>
  </div>
</section>


<!-- MAIN INVITATION -->
<main id="invitation" class="invitation" aria-hidden="true">

  <!-- VERSE / PEMBUKA -->
  <section class="section verse" data-screen-label="Pembuka">
    <div class="reveal">
      <span class="bismillah script">Bismillahirrahmanirrahim</span>
      <p class="verse__text">
        "Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu
        pasangan-pasangan dari jenismu sendiri, supaya kamu cenderung dan merasa
        tenteram kepadanya, dan dijadikan-Nya di antaramu rasa kasih dan sayang."
      </p>
      <p class="verse__ref">— QS. Ar-Rum : 21 —</p>
    </div>
  </section>

  <!-- FOTO UTAMA -->
  @if($wedding->foto_utama)
  <section class="main-photo reveal" data-screen-label="Foto Utama">
    <figure class="main-photo__frame">
      <img src="{{ asset('storage/' . $wedding->foto_utama) }}"
        alt="Foto {{ $wedding->nama_pria }} dan {{ $wedding->nama_wanita }}" id="mainPhotoImage" />
    </figure>
  </section>
  @endif


  <!-- MEMPELAI -->
  <section class="section couple" id="mempelai" data-screen-label="Mempelai">
    <div class="reveal">
      <p class="kicker">Dengan memohon rahmat dan ridho Allah SWT</p>
      <h2 class="section__title">Kedua Mempelai</h2>
    </div>

    <div class="couple__card reveal">
      <div class="photo photo--round" @unless($wedding->foto_suami) data-monogram="{{ strtoupper(substr($wedding->nama_pria, 0, 1)) }}" @endunless>
        @if($wedding->foto_suami)
          <img src="{{ asset('storage/' . $wedding->foto_suami) }}" alt="Foto {{ $wedding->nama_pria }}" />
        @endif
      </div>
      <h3 class="couple__name script">{{ $wedding->nama_lengkap_pria ?: $wedding->nama_pria }}</h3>
      <p class="couple__role">Putra dari</p>
      <p class="couple__parents">{{ $wedding->nama_ayah_suami }}<br />&amp; {{ $wedding->nama_ibu_suami }}</p>
    </div>

    <div class="couple__amp script reveal">&amp;</div>

    <div class="couple__card reveal">
      <div class="photo photo--round" @unless($wedding->foto_istri) data-monogram="{{ strtoupper(substr($wedding->nama_wanita, 0, 1)) }}" @endunless>
        @if($wedding->foto_istri)
          <img src="{{ asset('storage/' . $wedding->foto_istri) }}" alt="Foto {{ $wedding->nama_wanita }}" />
        @endif
      </div>
      <h3 class="couple__name script">{{ $wedding->nama_lengkap_wanita ?: $wedding->nama_wanita }}</h3>
      <p class="couple__role">Putri dari</p>
      <p class="couple__parents">{{ $wedding->nama_ayah_istri }}<br />&amp; {{ $wedding->nama_ibu_istri }}</p>
    </div>
  </section>


  <!-- DETAIL ACARA -->
  <section class="section events" id="acara" data-screen-label="Acara">
    <div class="reveal">
      <h2 class="section__title">Rangkaian Acara</h2>
      <p class="kicker">Insya Allah akan dilaksanakan pada</p>
    </div>

    @foreach($wedding->lokasis as $index => $lokasi)
    <div class="event-card {{ $index % 2 == 1 ? 'event-card--alt' : '' }} reveal">
      <span class="event-card__badge">{{ $lokasi->nama_acara }}</span>
      <div class="event-card__date">
        <span class="event-card__day">{{ \Carbon\Carbon::parse($lokasi->tanggal)->translatedFormat('l') }}</span>
        <span class="event-card__num">{{ \Carbon\Carbon::parse($lokasi->tanggal)->format('d') }}</span>
        <span class="event-card__mon">{{ \Carbon\Carbon::parse($lokasi->tanggal)->translatedFormat('F Y') }}</span>
      </div>
      <p class="event-card__time">
        {{ $lokasi->waktu_mulai ? \Carbon\Carbon::parse($lokasi->waktu_mulai)->format('H.i') : '' }}
        @if($lokasi->waktu_selesai) — {{ \Carbon\Carbon::parse($lokasi->waktu_selesai)->format('H.i') }} @endif
        WIB
      </p>
      <p class="event-card__place">{{ $lokasi->alamat }}</p>
      @if($lokasi->maps_link)
      <a class="btn btn--ghost" href="{{ $lokasi->maps_link }}" target="_blank" rel="noopener" style="margin-top:.8rem;font-size:.8rem;">
        <svg class="btn__icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7-6.5-7-11a7 7 0 0 1 14 0c0 4.5-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
        Lihat Peta
      </a>
      @endif
    </div>
    @endforeach
  </section>


  <!-- COUNTDOWN -->
  <section class="section countdown" data-screen-label="Countdown">
    <div class="reveal">
      <h2 class="section__title section__title--light">Menuju Hari Bahagia</h2>
      <div class="countdown__grid" id="countdown" data-target="{{ $countdownTarget }}">
        <div class="cd"><span class="cd__num" data-unit="days">00</span><span class="cd__lbl">Hari</span></div>
        <div class="cd"><span class="cd__num" data-unit="hours">00</span><span class="cd__lbl">Jam</span></div>
        <div class="cd"><span class="cd__num" data-unit="minutes">00</span><span class="cd__lbl">Menit</span></div>
        <div class="cd"><span class="cd__num" data-unit="seconds">00</span><span class="cd__lbl">Detik</span></div>
      </div>
      <a class="btn btn--ghost" id="calBtn" href="#" target="_blank" rel="noopener">Simpan ke Kalender</a>
    </div>
  </section>


  <!-- GALERI -->
  @if($wedding->galeris->isNotEmpty())
  <section class="section gallery" id="galeri" data-screen-label="Galeri">
    <div class="reveal">
      <h2 class="section__title">Galeri</h2>
      <p class="kicker">Momen-momen berharga kami</p>
    </div>
    <div class="gallery__grid reveal">
      @foreach($wedding->galeris->take(6) as $index => $foto)
        @php
          $galleryPath = ltrim($foto->file_path, '/');
          $galleryUrl = str_starts_with($foto->file_path, '/')
            ? asset($galleryPath)
            : asset('storage/' . $galleryPath);
        @endphp
        <figure class="gal" data-monogram="{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}">
          <img src="{{ $galleryUrl }}" alt="{{ $foto->judul ?? 'Foto ' . ($index + 1) }}" loading="lazy" />
        </figure>
      @endforeach
    </div>
  </section>
  @endif


  <!-- GOOGLE MAPS -->
  @if($firstLokasi)
  <section class="section maps" id="lokasi" data-screen-label="Lokasi">
    <div class="reveal">
      <h2 class="section__title">Lokasi Acara</h2>
      <p class="kicker">{{ $firstLokasi->alamat }}</p>
    </div>
    <div class="maps__frame reveal">
      <iframe
        title="Peta lokasi acara"
        src="https://maps.google.com/maps?q={{ urlencode($firstLokasi->alamat) }}&t=&z=14&ie=UTF8&iwloc=&output=embed"
        loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    @if($firstLokasi->maps_link)
    <a class="btn btn--ghost reveal" href="{{ $firstLokasi->maps_link }}" target="_blank" rel="noopener">
      <svg class="btn__icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7-6.5-7-11a7 7 0 0 1 14 0c0 4.5-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
      <span>Buka di Google Maps</span>
    </a>
    @endif
  </section>
  @endif


  <!-- TURUT MENGUNDANG -->
  @php
    $turutPria   = trim(strip_tags($wedding->turut_mengundang_pria ?? ''));
    $turutWanita = trim(strip_tags($wedding->turut_mengundang_wanita ?? ''));
  @endphp
  @if(!empty($turutPria) || !empty($turutWanita))
  <section class="section" data-screen-label="Mengundang">
    <div class="reveal">
      <h2 class="section__title">Turut Mengundang</h2>
    </div>
    @if(!empty($turutPria))
    <div class="reveal">
      <p class="kicker">Pihak Mempelai Pria</p>
      <div>{!! $wedding->turut_mengundang_pria !!}</div>
    </div>
    @endif
    @if(!empty($turutWanita))
    <div class="reveal">
      <p class="kicker">Pihak Mempelai Wanita</p>
      <div>{!! $wedding->turut_mengundang_wanita !!}</div>
    </div>
    @endif
  </section>
  @endif


  <!-- RSVP / UCAPAN -->
  <section class="section rsvp" id="rsvp" data-screen-label="RSVP">
    <div class="reveal">
      <h2 class="section__title section__title--light">Konfirmasi Kehadiran</h2>
      <p class="kicker kicker--light">Mohon konfirmasi kehadiran Anda</p>
    </div>

    @if(isset($tamu))
      @if(is_null($tamu->status_hadir) || $tamu->status_hadir === 'belum_konfirmasi')
      <form class="rsvp__form reveal" id="commentForm" novalidate>
        <input type="hidden" id="tamuId" value="{{ $tamu->id }}" />

        <label class="field">
          <span class="field__label">Nama</span>
          <input type="text" id="rsvpName" value="{{ $tamu->nama_tamu }}" placeholder="Nama Anda" readonly />
        </label>

        <label class="field">
          <span class="field__label">Jumlah Tamu</span>
          <select id="rsvpCount">
            <option value="1">1 Orang</option>
            <option value="2">2 Orang</option>
            <option value="3">3 Orang</option>
            <option value="4">4 Orang</option>
          </select>
        </label>

        <fieldset class="field field--radio">
          <span class="field__label">Kehadiran</span>
          <div class="radio-row">
            <label class="radio"><input type="radio" name="attend" value="hadir" checked /><span>Hadir</span></label>
            <label class="radio"><input type="radio" name="attend" value="tidak_hadir" /><span>Berhalangan</span></label>
            <label class="radio"><input type="radio" name="attend" value="mungkin" /><span>Mungkin</span></label>
          </div>
        </fieldset>

        <label class="field">
          <span class="field__label">Ucapan &amp; Doa</span>
          <textarea id="rsvpMsg" rows="3" placeholder="Tuliskan ucapan untuk kedua mempelai..."></textarea>
        </label>

        <button class="btn btn--wa" id="rsvpSubmit" type="submit">
          <span>Kirim Ucapan</span>
        </button>
        <p class="rsvp__feedback" id="rsvpFeedback" role="status" aria-live="polite"></p>
      </form>
      @else
      <p class="reveal" style="text-align:center;margin-top:15px;">
        <b>Terima kasih, Anda sudah mengirim konfirmasi &amp; ucapan.</b>
      </p>
      @endif
    @endif

    <!-- Daftar Ucapan -->
    <div class="wishes reveal">
      <h3 class="wishes__title">Ucapan &amp; Doa</h3>
      <div id="commentList" class="wishes__list" data-comments='@json($tamusWithUcapan)'></div>
    </div>
  </section>


  <!-- AMPLOP DIGITAL -->
  @if($wedding->gifts->isNotEmpty())
  <section class="section gift" id="amplop" data-screen-label="Amplop">
    <div class="reveal">
      <h2 class="section__title">Amplop Digital</h2>
      <p class="kicker">Doa restu Anda adalah karunia yang berarti. Bila berkenan memberi tanda kasih, dapat melalui:</p>
    </div>

    @foreach($wedding->gifts as $rekening)
    <div class="gift__card reveal">
      <div class="gift__bank">{{ $rekening->bank_nama }}</div>
      <p class="gift__no" data-no="{{ $rekening->no_rekening }}">{{ $rekening->no_rekening }}</p>
      <p class="gift__owner">a.n. {{ $rekening->atas_nama }}</p>
      @if($rekening->catatan)
        <p style="font-size:.8rem;opacity:.7;">{{ $rekening->catatan }}</p>
      @endif
      <button class="btn btn--copy" data-copy="{{ $rekening->no_rekening }}" type="button">Salin Nomor</button>
    </div>
    @endforeach
  </section>
  @endif


  <!-- PENUTUP -->
  <section class="section closing" data-screen-label="Penutup">
    <div class="closing__bg" aria-hidden="true"></div>
    <div class="closing__inner reveal">
      <p class="closing__text">
        Merupakan suatu kehormatan dan kebahagiaan bagi kami, apabila
        Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu kepada
        kedua mempelai. Atas kehadiran dan doa restunya, kami ucapkan terima kasih.
      </p>
      <p class="closing__sign">Kami yang berbahagia,</p>
      <h2 class="closing__names script">{{ $wedding->nama_pria }} &amp; {{ $wedding->nama_wanita }}</h2>
      <div class="ornament" aria-hidden="true">
        <svg viewBox="0 0 120 40" class="flourish"><use href="#flourish"></use></svg>
      </div>
      <p class="closing__credit">Dibuat Oleh ARCDEV</p>
    </div>
  </section>
</main>


<!-- FLOATING MUSIC CONTROL -->
@if($wedding->file_musik)
<button class="music-btn" id="musicBtn" type="button" aria-label="Putar / hentikan musik">
  <svg class="music-btn__icon" viewBox="0 0 24 24" aria-hidden="true">
    <path d="M9 17.5V6.8L19 4.5v10.8" />
    <path d="M9 9.2 19 7" />
    <circle cx="6.5" cy="17.5" r="2.5" />
    <circle cx="16.5" cy="15.3" r="2.5" />
  </svg>
</button>
<audio id="bgm" loop preload="none">
  <source src="{{ asset('storage/' . $wedding->file_musik) }}" type="audio/mpeg" />
</audio>
@else
<button class="music-btn" id="musicBtn" type="button" aria-label="Putar / hentikan musik" hidden>
  <svg class="music-btn__icon" viewBox="0 0 24 24" aria-hidden="true">
    <path d="M9 17.5V6.8L19 4.5v10.8" />
    <path d="M9 9.2 19 7" />
    <circle cx="6.5" cy="17.5" r="2.5" />
    <circle cx="16.5" cy="15.3" r="2.5" />
  </svg>
</button>
<audio id="bgm" loop preload="none"></audio>
@endif


<!-- PETALS CANVAS -->
<canvas id="petals" class="petals" aria-hidden="true"></canvas>


<!-- SVG SPRITE -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <defs>
    <symbol id="flourish" viewBox="0 0 120 40">
      <g fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round">
        <path d="M60 20h-26c-10 0-16-6-22-6"/>
        <path d="M60 20h26c10 0 16-6 22-6"/>
        <path d="M12 14c4 0 6 3 6 6s-2 6-6 6"/>
        <path d="M108 14c-4 0-6 3-6 6s2 6 6 6"/>
        <path d="M34 14c3-3 7-4 10-2-3 4-7 5-10 2zM34 26c3 3 7 4 10 2-3-4-7-5-10-2z"/>
        <path d="M86 14c-3-3-7-4-10-2 3 4 7 5 10 2zM86 26c-3 3-7 4-10 2 3-4 7-5 10-2z"/>
      </g>
      <circle cx="60" cy="20" r="2.4" fill="currentColor"/>
    </symbol>
    <symbol id="ig" viewBox="0 0 24 24">
      <g fill="none" stroke="currentColor" stroke-width="1.6">
        <rect x="3.5" y="3.5" width="17" height="17" rx="5"/>
        <circle cx="12" cy="12" r="4"/>
        <circle cx="17" cy="7" r="1" fill="currentColor" stroke="none"/>
      </g>
    </symbol>
    <symbol id="wa" viewBox="0 0 24 24">
      <path fill="currentColor" d="M12 2a10 10 0 0 0-8.7 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2zm5.5 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7s-3.8-3.3-3.9-3.5-1-1.3-1-2.5.6-1.8.9-2c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5s.8 1.9.8 2 .1.3 0 .5l-.4.5-.3.4c-.1.1-.3.3-.1.6s.6 1 1.3 1.7c.9.8 1.6 1 1.9 1.2s.5.1.6-.1.7-.8.9-1.1.4-.2.6-.1l1.8.9c.2.1.4.2.5.3.1.2.1.7-.1 1.3z"/>
    </symbol>
    <symbol id="note" viewBox="0 0 24 24">
      <path fill="currentColor" d="M9 18V6l10-2v11"/>
      <circle cx="6.5" cy="18" r="2.6" fill="currentColor"/>
      <circle cx="16.5" cy="15" r="2.6" fill="currentColor"/>
    </symbol>
    <symbol id="branch" viewBox="0 0 140 140">
      <path d="M12 130 C 40 102 60 80 78 50 C 90 30 102 18 122 10" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
      <g fill="currentColor">
        <ellipse cx="30" cy="104" rx="4.4" ry="9" transform="rotate(42 30 104)"/>
        <ellipse cx="47" cy="86" rx="4.4" ry="9" transform="rotate(55 47 86)"/>
        <ellipse cx="63" cy="66" rx="4.6" ry="9.5" transform="rotate(62 63 66)"/>
        <ellipse cx="80" cy="46" rx="4.6" ry="9.5" transform="rotate(72 80 46)"/>
        <ellipse cx="96" cy="30" rx="4" ry="8.5" transform="rotate(80 96 30)"/>
        <ellipse cx="44" cy="98" rx="3.8" ry="8" transform="rotate(-18 44 98)"/>
        <ellipse cx="60" cy="78" rx="3.8" ry="8" transform="rotate(-8 60 78)"/>
        <ellipse cx="77" cy="58" rx="3.8" ry="8" transform="rotate(2 77 58)"/>
        <ellipse cx="93" cy="40" rx="3.6" ry="7.5" transform="rotate(10 93 40)"/>
      </g>
      <circle cx="122" cy="10" r="3.4" fill="currentColor"/>
    </symbol>
    <symbol id="bloom" viewBox="0 0 60 60">
      <g fill="currentColor">
        <ellipse cx="30" cy="15" rx="5.4" ry="11"/>
        <ellipse cx="30" cy="15" rx="5.4" ry="11" transform="rotate(72 30 30)"/>
        <ellipse cx="30" cy="15" rx="5.4" ry="11" transform="rotate(144 30 30)"/>
        <ellipse cx="30" cy="15" rx="5.4" ry="11" transform="rotate(216 30 30)"/>
        <ellipse cx="30" cy="15" rx="5.4" ry="11" transform="rotate(288 30 30)"/>
      </g>
      <circle cx="30" cy="30" r="5.2" fill="#e9d8a6"/>
    </symbol>
  </defs>
</svg>

<script src="{{ asset($assetPath . '/script.js') }}"></script>

<script>
(function () {
  /* Override calendar link dengan data dinamis */
  var calBtn = document.getElementById('calBtn');
  if (calBtn) {
    var target  = new Date('{{ $countdownTarget }}');
    var end     = new Date(target.getTime() + 3 * 3600 * 1000);
    var fmt     = function(d) { return d.toISOString().replace(/[-:]|\.\d{3}/g, ''); };
    var couples = '{{ $wedding->nama_pria }} & {{ $wedding->nama_wanita }}';
    var loc     = '{{ $firstLokasi ? addslashes($firstLokasi->alamat) : '' }}';
    calBtn.href = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
      + '&text=' + encodeURIComponent('Pernikahan ' + couples)
      + '&dates=' + fmt(target) + '/' + fmt(end)
      + '&details=' + encodeURIComponent('Dengan senang hati mengundang Anda.')
      + '&location=' + encodeURIComponent(loc);
  }

  /* RSVP — kirim ke database */
  var form = document.getElementById('commentForm');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var tamuId     = document.getElementById('tamuId').value;
      var attendance = (form.querySelector('input[name="attend"]:checked') || {}).value || 'hadir';
      var guestCount = parseInt(document.getElementById('rsvpCount').value) || 1;
      var message    = document.getElementById('rsvpMsg').value.trim();
      var submitBtn  = document.getElementById('rsvpSubmit');
      var feedback   = document.getElementById('rsvpFeedback');

      if (!message) {
        feedback.textContent = 'Mohon tuliskan ucapan terlebih dahulu.';
        feedback.className = 'rsvp__feedback is-error';
        document.getElementById('rsvpMsg').focus();
        return;
      }

      submitBtn.disabled = true;
      submitBtn.querySelector('span').textContent = 'Mengirim...';
      feedback.textContent = '';
      feedback.className = 'rsvp__feedback';

      fetch('/tamu/' + tamuId + '/update-wish', {
        method : 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          status_hadir : attendance,
          jumlah_orang : guestCount,
          ucapan       : message
        })
      })
      .then(function(r) {
        return r.json().then(function(data) {
          if (!r.ok) {
            var validation = data.errors ? Object.values(data.errors).flat()[0] : null;
            throw new Error(validation || data.message || 'Ucapan gagal dikirim.');
          }
          return data;
        });
      })
      .then(function(data) {
        if (data.success) {
          var newComment = data.data;
          var list = document.getElementById('commentList');
          if (list) {
            try {
              var comments = JSON.parse(list.dataset.comments || '[]');
              comments.unshift(newComment);
              list.dataset.comments = JSON.stringify(comments);
              renderComments(list, comments);
            } catch(err) {}
          }

          form.innerHTML = '<p class="rsvp__success"><b>Terima kasih.</b><br>Konfirmasi kehadiran dan ucapan Anda sudah tersimpan.</p>';
        }
      })
      .catch(function(err) {
        feedback.textContent = err.message || 'Ucapan gagal dikirim. Silakan coba lagi.';
        feedback.className = 'rsvp__feedback is-error';
      })
      .finally(function() {
        if (submitBtn && submitBtn.isConnected) {
          submitBtn.disabled = false;
          submitBtn.querySelector('span').textContent = 'Kirim Ucapan';
        }
      });
    });
  }

  /* Render daftar ucapan */
  function esc(s) {
    return (s || '').toString()
      .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  function renderComments(el, comments) {
    if (!comments.length) {
      el.innerHTML = '<p class="wishes__empty">Belum ada ucapan. Jadilah yang pertama memberi doa.</p>';
      setupWishAutoScroll(el);
      return;
    }
    el.innerHTML = comments.map(function(c) {
      var badge = c.status_hadir === 'hadir' ? 'Hadir'
                : c.status_hadir === 'tidak_hadir' ? 'Tidak Hadir'
                : c.status_hadir === 'mungkin' ? 'Mungkin'
                : 'Belum Konfirmasi';
      return '<article class="wish-card">'
        + '<div class="wish-card__meta">'
        + '<strong class="wish-card__name">' + esc(c.nama_tamu) + '</strong>'
        + '<span class="wish-card__badge wish-card__badge--' + esc(c.status_hadir) + '">' + esc(badge) + ' · ' + esc(c.jumlah_orang) + ' orang</span>'
        + '</div>'
        + '<p class="wish-card__message">' + esc(c.ucapan) + '</p>'
        + '</article>';
    }).join('');
    setupWishAutoScroll(el);
  }

  function setupWishAutoScroll(el) {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      return;
    }

    if (el.dataset.autoScrollReady) {
      el.dispatchEvent(new Event('wishes:updated'));
      return;
    }

    el.dataset.autoScrollReady = 'true';
    var timer = null;
    var resumeTimer = null;
    var resetTimer = null;
    var releaseTimer = null;
    var bottomPause = false;

    function canScroll() {
      return el.scrollHeight > el.clientHeight + 2;
    }

    function start() {
      clearInterval(timer);
      if (!canScroll()) return;

      timer = setInterval(function() {
        if (bottomPause) return;

        if (el.scrollTop + el.clientHeight >= el.scrollHeight - 2) {
          bottomPause = true;
          resetTimer = setTimeout(function() {
            el.scrollTo({ top: 0, behavior: 'smooth' });
            releaseTimer = setTimeout(function() { bottomPause = false; }, 1800);
          }, 2600);
          return;
        }

        el.scrollTop += 1;
      }, 70);
    }

    function pauseThenResume() {
      clearInterval(timer);
      clearTimeout(resumeTimer);
      clearTimeout(resetTimer);
      clearTimeout(releaseTimer);
      bottomPause = false;
      resumeTimer = setTimeout(start, 5000);
    }

    ['touchstart', 'pointerdown', 'wheel', 'focusin'].forEach(function(eventName) {
      el.addEventListener(eventName, pauseThenResume, { passive: true });
    });
    el.addEventListener('mouseenter', function() { clearInterval(timer); });
    el.addEventListener('mouseleave', start);
    el.addEventListener('wishes:updated', function() {
      clearInterval(timer);
      clearTimeout(resetTimer);
      clearTimeout(releaseTimer);
      bottomPause = false;
      setTimeout(start, 800);
    });

    setTimeout(start, 1800);
  }

  var commentList = document.getElementById('commentList');
  if (commentList) {
    try {
      var initialComments = JSON.parse(commentList.dataset.comments || '[]');
      renderComments(commentList, initialComments);
    } catch(err) {}
  }
})();
</script>
</body>
</html>
