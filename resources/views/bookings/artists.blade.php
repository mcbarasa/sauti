{{-- ════════════════════════════════════════════
     ARTISTS SECTION  —  #artists
════════════════════════════════════════════ --}}

<section id="artists" style="background:var(--bg-alt);padding:6rem 1.5rem;">
  <div class="container">

  <style>
  /* ══════════════════════════════════════════════
     ARTISTS — SPLIT CARD LAYOUT
  ══════════════════════════════════════════════ */

  #artists .artist-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    margin-top: 2.5rem;
  }

  /* ── Featured spans full 3 columns ── */
  #artists .artist-card.featured { grid-column: span 3; }

  /* ══ BASE CARD ══════════════════════════════════ */
  #artists .artist-card {
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    position: relative;
    border: 1px solid var(--border);
    background: var(--surface);
    transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
  }
  #artists .artist-card:hover {
    border-color: var(--yellow);
    box-shadow: 0 16px 48px rgba(0,0,0,0.4);
    transform: translateY(-4px);
  }

  /* ══ SPLIT PANEL WRAPPER ════════════════════════ */
  #artists .split-wrap {
    display: flex;
    width: 100%;
    height: 320px;
    overflow: hidden;
  }
  /* Featured card taller */
  #artists .artist-card.featured .split-wrap { height: 420px; }

  /* ══ EACH PANEL ═════════════════════════════════ */
  #artists .split-panel {
    position: relative;
    overflow: hidden;
    flex: 1;
    transition: flex 0.55s cubic-bezier(0.4, 0, 0.2, 1);
  }
  /* On card hover: hovered panel grows, other shrinks */
  #artists .split-wrap:hover .split-panel { flex: 0.55; }
  #artists .split-wrap:hover .split-panel:hover { flex: 1.45; }

  /* ── Panel image ── */
  #artists .split-panel img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.55s ease, filter 0.45s ease, opacity 0.45s ease;
  }

  /* When sibling panel is hovered: fade this one */
  #artists .split-wrap:hover .split-panel:not(:hover) img {
    filter: brightness(0.4) saturate(0.5);
    opacity: 0.7;
  }
  /* Hovered panel: sharpen & zoom slightly */
  #artists .split-wrap:hover .split-panel:hover img {
    transform: scale(1.08);
    filter: brightness(1.05) saturate(1.1);
  }

  /* ── Divider line between panels ── */
  #artists .split-divider {
    position: absolute;
    top: 0; bottom: 0;
    width: 2px;
    background: var(--yellow);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 5;
    right: 0;
    pointer-events: none;
  }
  #artists .split-panel:first-child .split-divider { right: 0; }
  #artists .split-wrap:hover .split-divider { opacity: 0.7; }

  /* ── Panel labels ── */
  #artists .panel-label {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 2rem 1rem 0.75rem;
    background: linear-gradient(transparent, rgba(10,10,10,0.85));
    z-index: 3;
    transition: opacity 0.35s ease;
  }
  #artists .panel-label .pl-tag {
    font-size: 0.62rem;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: var(--yellow);
    display: block;
    margin-bottom: 2px;
  }
  #artists .panel-label .pl-name {
    font-size: 0.88rem;
    font-weight: 600;
    color: #fff;
    display: block;
  }

  /* Fade label on non-hovered panel */
  #artists .split-wrap:hover .split-panel:not(:hover) .panel-label {
    opacity: 0.3;
  }

  /* ── Instrument badge ── */
  #artists .instrument-badge {
    position: absolute;
    top: 0.75rem; left: 0.75rem;
    background: rgba(10,10,10,0.75);
    backdrop-filter: blur(6px);
    color: #fff;
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 20px;
    padding: 3px 10px;
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    display: flex; align-items: center; gap: 5px;
    z-index: 4;
    transition: background 0.25s, border-color 0.25s, color 0.25s;
  }
  #artists .split-wrap:hover .split-panel:hover .instrument-badge {
    background: var(--yellow);
    color: #0A0A0A;
    border-color: var(--yellow);
  }

  /* ── View profile overlay chip ── */
  #artists .view-chip {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%) scale(0.8);
    background: var(--yellow);
    color: #0A0A0A;
    border-radius: 30px;
    padding: 6px 16px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    opacity: 0;
    z-index: 6;
    pointer-events: none;
    transition: opacity 0.3s ease, transform 0.3s ease;
    white-space: nowrap;
  }
  #artists .split-wrap:hover .split-panel:hover .view-chip {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
  }

  /* ══ INFO STRIP ════════════════════════════════ */
  #artists .artist-info {
    padding: 0.85rem 1rem 1rem;
    border-top: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
  }
  #artists .artist-name {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 2px;
  }
  #artists .artist-genre {
    font-size: 0.68rem;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--gray);
    line-height: 1.4;
  }
  #artists .artist-social {
    display: flex;
    gap: 0.4rem;
    flex-shrink: 0;
  }
  #artists .artist-social a {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: var(--surface2);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--gray);
    font-size: 0.75rem;
    text-decoration: none;
    transition: border-color 0.2s, color 0.2s, background 0.2s;
  }
  #artists .artist-social a:hover {
    border-color: var(--yellow);
    color: var(--yellow);
    background: var(--yellow-bg);
  }

  /* ══ MODAL ════════════════════════════════════ */
  .artist-modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.82);
    backdrop-filter: blur(8px);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
  }
  .artist-modal-overlay.open {
    opacity: 1;
    pointer-events: all;
  }
  .artist-modal {
    background: var(--surface);
    border: 1px solid var(--border-y);
    border-radius: 10px;
    max-width: 580px;
    width: 100%;
    overflow: hidden;
    transform: translateY(20px) scale(0.97);
    transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    max-height: 90vh;
    overflow-y: auto;
  }
  .artist-modal-overlay.open .artist-modal {
    transform: translateY(0) scale(1);
  }
  .modal-split {
    display: grid;
    grid-template-columns: 1fr 1fr;
    height: 280px;
  }
  .modal-split-panel {
    position: relative;
    overflow: hidden;
  }
  .modal-split-panel img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.6s ease;
  }
  .modal-split-panel:hover img { transform: scale(1.06); }
  .modal-split-label {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 1.5rem 0.75rem 0.6rem;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    font-size: 0.6rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--yellow);
  }
  .modal-split-divider {
    position: absolute;
    top: 0; bottom: 0; left: 50%;
    width: 2px;
    background: var(--yellow);
    opacity: 0.5;
    transform: translateX(-50%);
    pointer-events: none;
    z-index: 2;
  }
  .modal-body {
    padding: 1.5rem 1.5rem 1.75rem;
    position: relative;
  }
  .modal-close {
    position: absolute;
    top: 1rem; right: 1rem;
    width: 32px; height: 32px;
    border-radius: 50%;
    background: var(--surface2);
    border: 1px solid var(--border);
    color: var(--gray);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    transition: border-color 0.2s, color 0.2s;
  }
  .modal-close:hover { border-color: var(--yellow); color: var(--yellow); }
  .modal-instrument-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: var(--yellow-bg);
    border: 1px solid var(--border-y);
    border-radius: 20px;
    padding: 3px 12px;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--yellow);
    margin-bottom: 0.75rem;
  }
  .modal-name {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 2rem;
    letter-spacing: 3px;
    color: var(--text);
    line-height: 1;
    margin-bottom: 0.25rem;
  }
  .modal-genre {
    font-size: 0.75rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--gray);
    margin-bottom: 1rem;
  }
  .modal-bio {
    font-size: 0.88rem;
    color: var(--text2);
    line-height: 1.75;
    margin-bottom: 1.25rem;
  }
  .modal-contacts {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
  }
  .modal-contact-item {
    display: flex;
    align-items: center;
    gap: 6px;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 4px;
    padding: 5px 10px;
    font-size: 0.78rem;
    color: var(--text2);
    text-decoration: none;
    transition: border-color 0.2s, color 0.2s;
  }
  .modal-contact-item:hover { border-color: var(--yellow); color: var(--yellow); }
  .modal-contact-item i { color: var(--yellow); font-size: 0.75rem; }
  .modal-book-btn {
    display: inline-block;
    background: var(--yellow);
    color: #0A0A0A;
    font-weight: 700;
    font-size: 0.82rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 0.65rem 1.5rem;
    border-radius: 4px;
    text-decoration: none;
    transition: background 0.2s;
  }
  .modal-book-btn:hover { background: var(--yellow-dark); }

  /* ══ RESPONSIVE ════════════════════════════════ */
  @media (max-width: 900px) {
    #artists .artist-grid { grid-template-columns: 1fr 1fr; }
    #artists .artist-card.featured { grid-column: span 2; }
    #artists .split-wrap { height: 280px; }
    #artists .artist-card.featured .split-wrap { height: 340px; }
  }

  @media (max-width: 600px) {
    #artists .artist-grid {
      grid-template-columns: 1fr;
      gap: 1rem;
    }
    #artists .artist-card.featured { grid-column: span 1; }
    #artists .split-wrap { height: 220px; }
    #artists .artist-card.featured .split-wrap { height: 260px; }
    .modal-split { grid-template-columns: 1fr 1fr; height: 200px; }
    .modal-name  { font-size: 1.6rem; }
  }
  </style>

    {{-- Section header --}}
    <p class="section-label">Artists & Acts</p>
    <h2 class="section-title">Through<br><span>These Walls</span></h2>
    <p class="section-sub reveal">Some of the artists who have visited and used out studios, Come rehearse with us and let the family keep on growing.</p>

    {{-- ── Artist Grid ── --}}
    <div class="artist-grid">

      {{-- DATA: each artist --}}
      @php
      $artists = [
        [
          'featured'     => true,
          'name'         => 'garvillomuziqq',
          'genre'        => 'Gospel · Lead Guitar',
          'instrument'   => 'Guitar',
          'icon'         => 'fa-guitar',
          'artist_img'   => asset('art/garvillo.WebP'),
          'instrument_img'=> asset('img/photo7.WebP'),
          'initials'     => 'GM',
          'color'        => 'rgba(245,197,24,0.15)',
          'text_color'   => 'var(--yellow)',
          'bio'          => 'Nairobi\'s most versatile lead musician Piano,Guitarist(Acoustic), Vocalist, Song Writer and music arranger, Watumishi podcast host __ A podcast for musicians too where by they talk about their journey.', 
          'instagram'    => 'https://instagram.com/garvillomuziqq',
          'phone'        => '+254 707 030 935',
        ],
        [
          'featured'     => false,
          'name'         => 'walters_music',
          'genre'        => 'Drums · Pencil Artist & Guitarist',
          'instrument'   => 'Drums',
          'icon'         => 'fa-drum',
          'artist_img'   => asset('art/walter.WebP'),
          'instrument_img'=> asset('img/drum_set.WebP'),
          'initials'     => 'WM',
          'color'        => 'rgba(100,100,255,0.12)',
          'text_color'   => '#9090FF',
          'bio'          => 'A multi-disciplinary creative — drummer, graphic designer, Video Editor, Producer, Sound Engineer and guitarist. Walter brings rhythmic precision and visual artistry to every session at the studio.',
          'instagram'    => 'https://instagram.com/walters_music',
          'phone'        => '+254 112 935 073',
        ],
        [
          'featured'     => false,
          'name'         => 'brokenbassman',
          'genre'        => 'Gospel · Bass Guitar',
          'instrument'   => 'Bass',
          'icon'         => 'fa-music',
          'artist_img'   => asset('art/bass.WebP'),
          'instrument_img'=> asset('img/photo4.WebP'),
          'initials'     => 'BB',
          'color'        => 'rgba(30,180,120,0.15)',
          'text_color'   => '#30C080',
          'bio'          => 'The backbone of every band he touches. Known for warm low-end grooves that lock perfectly with the rhythm section, on top of that a Gospel Bassist.',
          'instagram'    => 'https://instagram.com/brokenbassman',
          'phone'        => '+254 733 590 438',
        ],
        [
          'featured'     => false,
          'name'         => 'Mike',
          'genre'        => 'Gospel · Piano',
          'instrument'   => 'Lead Keys',
          'icon'         => 'fa-music',
          'artist_img'   => asset('art/lead.WebP'),
          'instrument_img'=> asset('img/photo9.WebP'),
          'initials'     => 'MK',
          'color'        => 'rgba(229,120,90,0.15)',
          'text_color'   => '#E5785A',
          'bio'          => 'Mike leads sessions with an instinctive command of keys and melody. His soul influences run deep — from classic Motown to contemporary Kenyan neo-soul.',
          'instagram'    => 'https://instagram.com/',
          'phone'        => '+254 700 000 004',
        ],
        [
          'featured'     => false,
          'name'         => '_simiyu_j',
          'genre'        => 'Gospel · Piano',
          'instrument'   => 'Piano',
          'icon'         => 'fa-music',
          'artist_img'   => asset('art/junior.WebP'),
          'instrument_img'=> asset('img/photo3.WebP'),
          'initials'     => 'SJ',
          'color'        => 'rgba(90,158,229,0.15)',
          'text_color'   => '#5A9EE5',
          'bio'          => 'Simiyu a gifted piano player who initially started as a drummer but the love of music made him gravitate towards piano playing. A studio favourite for any keys-driven session.',
          'instagram'    => 'https://instagram.com/_simiyu_j',
          'phone'        => '+254 743 761 144',
        ],
        [
          'featured'     => false,
          'name'         => 'robercick',
          'genre'        => 'Gospel · Piano . Bass',
          'instrument'   => 'Piano',
          'icon'         => 'fa-music',
          'artist_img'   => asset('art/keys1.WebP'),
          'instrument_img'=> asset('img/photo8.WebP'),
          'initials'     => 'RC',
          'color'        => 'rgba(100,200,80,0.15)',
          'text_color'   => '#60C840',
          'bio'          => 'A Gospel purist with an ear for nuance. Robercick\'s playing brings sophisticated harmonic texture, perfect for studio recordings that demand depth and restraint.',
          'instagram'    => 'https://instagram.com/robercick',
          'phone'        => '+254 717 803 383',
        ],
        [
          'featured'     => false,
          'name'         => 'sarakeyz_legrande_',
          'genre'        => 'Gospel · Professional Pianist & MD',
          'instrument'   => 'Piano',
          'icon'         => 'fa-music',
          'artist_img'   => asset('art/saraki.WebP'),
          'instrument_img'=> asset('img/photo2.WebP'),
          'initials'     => 'SL',
          'color'        => 'rgba(200,90,150,0.15)',
          'text_color'   => '#C05A90',
          'bio'          => 'Gospel pianist and Music Director with a ministry that stretches from church altars to professional stages. Sarah\'s technical mastery and spiritual depth make every performance transformative.',
          'instagram'    => 'https://instagram.com/sarakeyz_legrande_',
          'phone'        => '+254 112 065 043',
        ],
      ];
      @endphp

      @foreach($artists as $i => $artist)
      <div class="artist-card reveal {{ $artist['featured'] ? 'featured' : '' }}"
           onclick="openArtistModal({{ $i }})">

        {{-- Split panels --}}
        <div class="split-wrap">

          {{-- Left: Artist --}}
          <div class="split-panel">
            <img src="{{ $artist['artist_img'] }}" alt="{{ $artist['name'] }}"
                 onerror="this.style.display='none'" />

            {{-- Fallback placeholder if no image --}}
            <div style="position:absolute;inset:0;display:flex;align-items:center;
                        justify-content:center;background:var(--surface2);z-index:-1;">
              <div style="width:64px;height:64px;border-radius:50%;
                          display:flex;align-items:center;justify-content:center;
                          font-family:'Bebas Neue',sans-serif;font-size:1.4rem;
                          letter-spacing:2px;
                          background:{{ $artist['color'] }};
                          color:{{ $artist['text_color'] }};">
                {{ $artist['initials'] }}
              </div>
            </div>

            <div class="view-chip">View Artist</div>
            <div class="split-divider"></div>
            <div class="instrument-badge">
              <i class="fas {{ $artist['icon'] }} fa-xs"></i>
              <!-- {{ $artist['instrument'] }} -->
            </div>
            <div class="panel-label">
              <span class="pl-tag">Artist</span>
            </div>
          </div>

          {{-- Right: Instrument --}}
          <div class="split-panel">
            <img src="{{ $artist['instrument_img'] }}" alt="{{ $artist['instrument'] }}" />
            <div class="view-chip">Instrument</div>
            <div class="panel-label">
              <span class="pl-tag">Instrument</span>
            </div>
          </div>

        </div>{{-- /split-wrap --}}

        {{-- Info strip --}}
        <div class="artist-info">
          <div>
            <p class="artist-name">{{ $artist['name'] }}</p>
            <p class="artist-genre">{{ $artist['genre'] }}</p>
          </div>
          <div class="artist-social" onclick="event.stopPropagation()">
            <a href="{{ $artist['instagram'] }}" target="_blank" title="Instagram">
              <i class="fa-brands fa-instagram"></i>
            </a>
          </div>
        </div>

      </div>
      @endforeach

    </div>{{-- /artist-grid --}}
  </div>
</section>

{{-- ══════════════════════════════════════════════
     ARTIST MODAL
══════════════════════════════════════════════ --}}
<div class="artist-modal-overlay" id="artistModalOverlay" onclick="closeArtistModal(event)">
  <div class="artist-modal" id="artistModal">

    {{-- Split image header --}}
    <div class="modal-split" style="position:relative;">
      <div class="modal-split-panel" id="modalArtistPanel">
        <img id="modalArtistImg" src="" alt="Artist" />
        <div class="modal-split-label">Artist</div>
      </div>
      <div class="modal-split-divider"></div>
      <div class="modal-split-panel" id="modalInstrumentPanel">
        <img id="modalInstrumentImg" src="" alt="Instrument" />
        <div class="modal-split-label">Instrument</div>
      </div>
    </div>

    {{-- Body --}}
    <div class="modal-body">
      <button class="modal-close" onclick="closeArtistModal()">✕</button>

      <div class="modal-instrument-badge" id="modalBadge">
        <i class="fas fa-music fa-xs" id="modalBadgeIcon"></i>
        <span id="modalInstrumentName"></span>
      </div>

      <h3 class="modal-name"  id="modalName"></h3>
      <p class="modal-genre"  id="modalGenre"></p>
      <p class="modal-bio"    id="modalBio"></p>

      <div class="modal-contacts" id="modalContacts"></div>
    </div>
  </div>
</div>

<script>
const artistData = @json($artists ?? []);

function openArtistModal(index) {
  const a       = artistData[index];
  const overlay = document.getElementById('artistModalOverlay');

  document.getElementById('modalArtistImg').src      = a.artist_img;
  document.getElementById('modalInstrumentImg').src  = a.instrument_img;
  document.getElementById('modalName').textContent   = a.name;
  document.getElementById('modalGenre').textContent  = a.genre;
  document.getElementById('modalBio').textContent    = a.bio;
  document.getElementById('modalInstrumentName').textContent = a.instrument;
  document.getElementById('modalBadgeIcon').className = `fas ${a.icon} fa-xs`;

  // Contacts
  const contacts = document.getElementById('modalContacts');
  contacts.innerHTML = `
    <a href="${a.instagram}" target="_blank" class="modal-contact-item">
      <i class="fa-brands fa-instagram"></i> Instagram
    </a>
    <a href="tel:${a.phone}" class="modal-contact-item">
      <i class="fas fa-phone"></i> ${a.phone}
    </a>`;

  overlay.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeArtistModal(event) {
  // Only close if clicking backdrop or close button
  if (event && event.target !== document.getElementById('artistModalOverlay')) return;
  document.getElementById('artistModalOverlay').classList.remove('open');
  document.body.style.overflow = '';
}

// Close on Escape key
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    document.getElementById('artistModalOverlay').classList.remove('open');
    document.body.style.overflow = '';
  }
});
</script>