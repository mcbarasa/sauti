{{--
  resources/views/bookings/partners.blade.php
  Include on the home page with:  @include('bookings.partners')

  EDIT THE LINKS in the $partners array below ('url' => '#' means "no link yet").
  Uses $whatsapp from the parent page for the bottom call-to-action.
--}}
@php
    $partners = [
        [
            'name'  => 'LKC Academy',
            'tag'   => 'Learning',
            'icon'  => '🎓',
            'color' => '#4DA3FF',
            'wide'  => true,
            'desc'  => 'Where kids learn music, chess, computing and more. Hands-on lessons that turn curiosity into real skill.',
            'chips' => ['Music', 'Chess', 'Computing'],
            'url'   => '#',
        ],
        [
            'name'  => 'BV Labs',
            'tag'   => 'Tech',
            'icon'  => '💻',
            'color' => '#8B6CFF',
            'wide'  => false,
            'desc'  => 'A technology company building software and digital solutions.',
            'chips' => [],
            'url'   => '#',
        ],
        [
            'name'  => 'SG Events',
            'tag'   => 'Events',
            'icon'  => '🎤',
            'color' => '#FF5C8A',
            'wide'  => false,
            'desc'  => 'Sound, DJs and engineers for weddings, graduations, birthdays and fellowships.',
            'chips' => [],
            'url'   => route('sg-events'),
        ],
        [
            'name'  => 'SG Bible Study',
            'tag'   => 'Faith',
            'icon'  => '📖',
            'color' => '#E8B04A',
            'wide'  => false,
            'desc'  => 'A community gathering to study the Word, grow together and encourage each other.',
            'chips' => [],
            'url'   => '#',
        ],
        [
            'name'  => 'LKC Chess Club',
            'tag'   => 'Community',
            'icon'  => '♟️',
            'color' => '#2FC4B2',
            'wide'  => false,
            'desc'  => 'Sharpen your game, meet fellow players and play for the love of chess.',
            'chips' => [],
            'url'   => '#',
        ],
        [
            'name'  => 'Karen Village',
            'tag'   => 'Our host',
            'icon'  => '🏡',
            'color' => '#3FBF7F',
            'wide'  => true,
            'desc'  => 'Our home base. Karen Village hosts the studio and gives the gang a space to create, learn and gather.',
            'chips' => ['Host venue', 'Nairobi'],
            'url'   => '#contact',
        ],
        [
            'name'  => 'Tukutane Rest',
            'tag'   => 'Hangout',
            'icon'  => '☕',
            'color' => '#FF8A3D',
            'wide'  => false,
            'desc'  => 'A place to meet, relax and unwind after the session.',
            'chips' => [],
            'url'   => '#',
        ],
    ];
@endphp

<style>
/* ───────── PARTNERS ───────── */
#partners { background:var(--bg); position:relative; overflow:hidden; }
#partners::before {
  content:''; position:absolute; inset:0; pointer-events:none;
  background:radial-gradient(ellipse at 15% 0%, var(--hero-glow), transparent 55%),
             radial-gradient(ellipse at 90% 100%, var(--hero-glow), transparent 55%);
}
#partners .container { position:relative; }

/* Ticker */
.pt-ticker {
  margin:2.5rem -2rem 0; padding:1rem 0; overflow:hidden;
  border-top:1px solid var(--border-y); border-bottom:1px solid var(--border-y);
  background:var(--yellow-bg);
  -webkit-mask-image:linear-gradient(90deg,transparent,#000 8%,#000 92%,transparent);
          mask-image:linear-gradient(90deg,transparent,#000 8%,#000 92%,transparent);
}
.pt-track { display:flex; width:max-content; animation:ptScroll 32s linear infinite; }
.pt-ticker:hover .pt-track { animation-play-state:paused; }
.pt-item {
  display:flex; align-items:center; gap:0.7rem; padding:0 2rem; white-space:nowrap;
  font-family:'Bebas Neue',sans-serif; font-size:1.7rem; letter-spacing:3px; color:var(--text);
}
.pt-item i { font-style:normal; font-size:1.3rem; }
.pt-item::after { content:'✦'; margin-left:2rem; color:var(--yellow); font-size:1rem; }
[data-theme="light"] .pt-item::after { color:var(--yellow-deep); }
@keyframes ptScroll { from{transform:translateX(0)} to{transform:translateX(-50%)} }

/* Cards */
.pt-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1.25rem; margin-top:3rem; }
.pt-card {
  --accent:var(--yellow);
  position:relative; display:flex; flex-direction:column; gap:0.9rem; overflow:hidden;
  background:var(--surface); border:1px solid var(--border); border-radius:6px;
  padding:1.75rem; text-decoration:none; color:inherit;
  transition:transform .25s ease, border-color .25s ease, box-shadow .25s ease;
}
.pt-card.wide { grid-column:span 2; }
.pt-card::before { /* accent bar */
  content:''; position:absolute; left:0; top:0; right:0; height:4px; background:var(--accent);
}
.pt-card::after { /* soft glow */
  content:''; position:absolute; right:-60px; top:-60px; width:180px; height:180px; border-radius:50%;
  background:var(--accent); opacity:.10; filter:blur(30px); transition:opacity .25s;
  pointer-events:none;
}
.pt-card:hover, .pt-card:focus-visible {
  transform:translateY(-6px); border-color:var(--accent);
  box-shadow:0 14px 34px rgba(0,0,0,.28), 0 0 0 1px var(--accent);
}
.pt-card:hover::after { opacity:.28; }
.pt-card:focus-visible { outline:2px solid var(--accent); outline-offset:3px; }

.pt-top { display:flex; align-items:center; justify-content:space-between; gap:1rem; }
.pt-badge {
  width:54px; height:54px; border-radius:12px; display:flex; align-items:center; justify-content:center;
  font-size:1.7rem; background:color-mix(in srgb, var(--accent) 16%, transparent);
  border:1px solid color-mix(in srgb, var(--accent) 45%, transparent);
  transition:transform .25s ease;
}
.pt-card:hover .pt-badge { transform:rotate(-8deg) scale(1.08); }
.pt-tag {
  font-size:.68rem; font-weight:700; letter-spacing:2px; text-transform:uppercase;
  padding:.3rem .75rem; border-radius:20px; color:var(--accent);
  border:1px solid color-mix(in srgb, var(--accent) 50%, transparent);
  background:color-mix(in srgb, var(--accent) 10%, transparent);
}
.pt-name {
  font-family:'Bebas Neue',sans-serif; font-size:1.9rem; letter-spacing:2px; line-height:1; color:var(--text);
}
.pt-desc { color:var(--gray); font-size:.95rem; font-weight:300; max-width:46ch; }
.pt-chips { display:flex; flex-wrap:wrap; gap:.5rem; }
.pt-chips span {
  font-size:.75rem; padding:.25rem .7rem; border-radius:3px; color:var(--text2);
  background:var(--surface2); border:1px solid var(--border);
}
.pt-link {
  margin-top:auto; padding-top:.4rem; display:inline-flex; align-items:center; gap:.5rem;
  font-size:.8rem; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:var(--accent);
}
.pt-link i { font-size:.7rem; transition:transform .2s; }
.pt-card:hover .pt-link i { transform:translate(3px,-3px); }

/* CTA strip */
.pt-cta {
  margin-top:2.5rem; padding:1.5rem 1.75rem; display:flex; align-items:center; justify-content:space-between;
  gap:1rem; flex-wrap:wrap; background:var(--surface); border:1px dashed var(--border-y); border-radius:6px;
}
.pt-cta p { color:var(--text2); font-size:1rem; }
.pt-cta strong { color:var(--text); }

@media (max-width:900px) {
  .pt-grid { grid-template-columns:1fr 1fr; }
  .pt-card.wide { grid-column:span 2; }
  .pt-ticker { margin-left:-1.25rem; margin-right:-1.25rem; }
}
@media (max-width:600px) {
  .pt-grid { grid-template-columns:1fr; }
  .pt-card.wide { grid-column:span 1; }
  .pt-item { font-size:1.4rem; padding:0 1.25rem; }
  .pt-item::after { margin-left:1.25rem; }
  .pt-cta { flex-direction:column; align-items:stretch; text-align:center; }
}
@media (prefers-reduced-motion:reduce) {
  .pt-track { animation:none; flex-wrap:wrap; width:auto; justify-content:center; row-gap:.5rem; }
  .pt-card, .pt-badge, .pt-link i { transition:none; }
}
</style>

<section id="partners">
  <div class="container">

    <div class="reveal">
      <p class="section-label">The Gang Family</p>
      <h2 class="section-title">Our Partners<br>&amp; Sister Brands</h2>
      <p class="section-sub">Sauti Gang Studios is part of a bigger circle of teachers, builders, hosts and gatherers. Meet the brands we create with.</p>
    </div>

    {{-- Scrolling ticker (list repeated twice for a seamless loop) --}}
    <div class="pt-ticker reveal" aria-hidden="true">
      <div class="pt-track">
        @for($loop_i = 0; $loop_i < 2; $loop_i++)
          @foreach($partners as $p)
            <div class="pt-item"><i>{{ $p['icon'] }}</i>{{ $p['name'] }}</div>
          @endforeach
        @endfor
      </div>
    </div>

    <div class="pt-grid reveal">
      @foreach($partners as $p)
        @php
            $url      = $p['url'];
            $external = str_starts_with($url, 'http');
            $hasLink  = $url !== '#';
        @endphp
        <a class="pt-card {{ $p['wide'] ? 'wide' : '' }}"
           style="--accent:{{ $p['color'] }};"
           href="{{ $url }}"
           @if($external) target="_blank" rel="noopener" @endif
           @unless($hasLink) onclick="return false;" aria-disabled="true" @endunless>
          <div class="pt-top">
            <div class="pt-badge" aria-hidden="true">{{ $p['icon'] }}</div>
            <span class="pt-tag">{{ $p['tag'] }}</span>
          </div>
          <h3 class="pt-name">{{ $p['name'] }}</h3>
          <p class="pt-desc">{{ $p['desc'] }}</p>
          @if(!empty($p['chips']))
            <div class="pt-chips">
              @foreach($p['chips'] as $chip)<span>{{ $chip }}</span>@endforeach
            </div>
          @endif
          <span class="pt-link">
            {{ $hasLink ? ($external ? 'Visit' : 'Open') : 'Coming soon' }}
            @if($hasLink)<i class="fa-solid fa-arrow-up-right-from-square"></i>@endif
          </span>
        </a>
      @endforeach
    </div>

    <div class="pt-cta reveal">
      <p><strong>Run a brand that fits the gang?</strong> Let's talk about working together.</p>
      <a class="btn-primary"
         href="https://wa.me/{{ $whatsapp }}?text={{ urlencode('Hi Sauti Gang, I would like to talk about a partnership.') }}"
         target="_blank" rel="noopener">Partner with us</a>
    </div>

  </div>
</section>