{{-- ════════════════════════════════════════════
     LESSONS SECTION  —  #lessons
════════════════════════════════════════════ --}}
<section id="lessons" style="background:var(--bg-alt);padding:6rem 1.5rem;">
<div class="container">

<style>
.ls-grid {
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:1px;
  border:1px solid var(--border);
  border-radius:10px;
  overflow:hidden;
  margin-top:3rem;
  margin-bottom:2.5rem;
}
.ls-card {
  background:var(--surface);
  padding:1.6rem 1.4rem;
  display:flex; flex-direction:column;
  gap:0.9rem;
  position:relative;
  cursor:pointer;
  border-right:1px solid var(--border);
  border-bottom:1px solid var(--border);
  transition:background 0.25s;
}
.ls-card:hover { background:var(--yellow-bg); }
.ls-card-icon {
  width:44px; height:44px;
  background:var(--yellow-bg);
  border:1px solid var(--border-y);
  border-radius:8px;
  display:flex; align-items:center; justify-content:center;
  color:var(--yellow); font-size:20px;
  transition:background 0.25s;
}
.ls-card:hover .ls-card-icon { background:rgba(245,197,24,0.22); }
.ls-card-name {
  font-family:'Bebas Neue',sans-serif;
  font-size:1.25rem; letter-spacing:2px;
  color:var(--text); line-height:1;
}
.ls-card-desc {
  font-size:0.8rem; color:var(--gray);
  line-height:1.65; flex:1;
}
.ls-card-level {
  display:inline-flex; align-items:center; gap:5px;
  font-size:0.62rem; letter-spacing:2px;
  text-transform:uppercase; color:var(--yellow);
  background:var(--yellow-bg);
  border:1px solid var(--border-y);
  border-radius:20px; padding:3px 10px;
  width:fit-content;
}
.ls-card-arr {
  position:absolute; top:1.1rem; right:1.1rem;
  font-size:13px; color:var(--gray);
  transition:color 0.2s, transform 0.2s;
}
.ls-card:hover .ls-card-arr { color:var(--yellow); transform:translate(2px,-2px); }

.ls-featured {
  background:var(--surface2);
  border:1px solid var(--border-y);
  border-radius:10px;
  padding:2rem;
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:2rem;
  align-items:center;
  margin-bottom:2.5rem;
}
.ls-featured-tag {
  font-size:0.62rem; letter-spacing:3px;
  text-transform:uppercase; color:var(--yellow);
  margin-bottom:0.6rem; display:block;
}
.ls-featured-title {
  font-family:'Bebas Neue',sans-serif;
  font-size:1.8rem; letter-spacing:2px;
  color:var(--text); line-height:1;
  margin-bottom:0.75rem;
}
.ls-featured-body {
  font-size:0.85rem; color:var(--gray-light);
  line-height:1.75; margin-bottom:1.25rem;
}
.ls-featured-perks { display:flex; flex-direction:column; gap:0.55rem; }
.ls-perk {
  display:flex; align-items:center; gap:8px;
  font-size:0.82rem; color:var(--text2);
}
.ls-perk i { color:var(--yellow); font-size:15px; flex-shrink:0; }

.ls-stats {
  display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;
}
.ls-stat {
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:8px; padding:1rem;
}
.ls-stat-val {
  font-family:'Bebas Neue',sans-serif;
  font-size:1.9rem; letter-spacing:1px;
  color:var(--yellow); display:block;
  line-height:1.1; margin-bottom:3px;
}
.ls-stat-label {
  font-size:0.65rem; letter-spacing:2px;
  text-transform:uppercase; color:var(--gray);
}

.ls-trust {
  display:flex; gap:2rem; flex-wrap:wrap; margin-bottom:3rem;
}
.ls-trust-item {
  display:flex; align-items:center; gap:7px;
  font-size:0.78rem; color:var(--gray);
}
.ls-trust-item i { color:var(--yellow); font-size:15px; }

.ls-cta {
  display:flex; gap:0.85rem;
  flex-wrap:wrap; align-items:center;
}

@media(max-width:900px) {
  .ls-grid { grid-template-columns:1fr 1fr; }
  .ls-featured { grid-template-columns:1fr; gap:1.5rem; }
}
@media(max-width:600px) {
  .ls-grid { grid-template-columns:1fr 1fr; }
  .ls-featured { padding:1.4rem; }
  .ls-stats { grid-template-columns:1fr 1fr; }
  .ls-trust { gap:0.85rem; }
  .ls-cta { flex-direction:column; align-items:stretch; }
  .ls-cta a { text-align:center; }
}
@media(max-width:400px) {
  .ls-grid { grid-template-columns:1fr; }
}
</style>

  {{-- Section header --}}
  <div class="reveal">
    <p class="section-label">Learn With Us</p>
    <h2 class="section-title">Music Lessons<br><span>At Sauti Gang</span></h2>
    <p class="section-sub">Learn from seasoned Nairobi musicians. Beginner to advanced — our teachers meet you where you are.</p>
  </div>

  {{-- Trust bar --}}
  <div class="ls-trust reveal">
    <div class="ls-trust-item"><i class="fas fa-users"></i><span>Teachers always available</span></div>
    <div class="ls-trust-item"><i class="fas fa-clock"></i><span>Flexible scheduling</span></div>
    <div class="ls-trust-item"><i class="fas fa-certificate"></i><span>All levels welcome</span></div>
  </div>

  {{-- Instrument cards --}}
  <div class="ls-grid reveal">

    @foreach([
      ['fa-guitar',       'Guitar',   'Electric & lead guitar — scales, riffs, solos and genre techniques from gospel to Afropop.'],
      ['fa-music',        'Acoustic', 'Fingerpicking, chord progressions and strumming patterns on acoustic guitar.'],
      ['fa-wave-square',  'Bass',     'Groove, timing and low-end theory. Lock in with drums and hold down any band.'],
      ['fa-piano-keys',   'Keys',     'Piano & keyboard — basic chords to gospel runs, jazz voicings and worship styles.'],
      ['fa-drum',         'Drums',    'Stick technique, rudiments, groove and fills — playing in a full band context.'],
      ['fa-microphone',   'Vocals',   'Breath control, pitch, tone and performance. Develop your unique singing voice.'],
    ] as $lesson)
    <div class="ls-card">
      <i class="fas fa-arrow-up-right-from-square ls-card-arr" aria-hidden="true"></i>
      <div class="ls-card-icon"><i class="fas {{ $lesson[0] }}"></i></div>
      <div class="ls-card-name">{{ $lesson[1] }}</div>
      <div class="ls-card-desc">{{ $lesson[2] }}</div>
      <span class="ls-card-level"><i class="fas fa-star" style="font-size:9px;"></i> All levels</span>
    </div>
    @endforeach

  </div>

  {{-- Featured info block --}}
  <div class="ls-featured reveal">
    <div>
      <span class="ls-featured-tag">Why learn here</span>
      <div class="ls-featured-title">Real Musicians,<br>Real Teaching</div>
      <p class="ls-featured-body">Every teacher at Sauti Gang is an active performing musician — not just an instructor. You learn from people who live the craft daily.</p>
      <div class="ls-featured-perks">
        @foreach([
          'One-on-one & group sessions available',
          'All instruments & gear provided in-house',
          'Custom lesson plans tailored to your goals',
          'Book by the hour or take a monthly package',
        ] as $perk)
        <div class="ls-perk">
          <i class="fas fa-check"></i>
          <span>{{ $perk }}</span>
        </div>
        @endforeach
      </div>
    </div>
    <div class="ls-stats">
      @foreach([
        ['6+',    'Instruments taught'],
        ['50+',   'Students trained'],
        ['KES 1K','Starting per hour'],
        ['12 Hrs','Daily access'],
      ] as $stat)
      <div class="ls-stat">
        <span class="ls-stat-val">{{ $stat[0] }}</span>
        <span class="ls-stat-label">{{ $stat[1] }}</span>
      </div>
      @endforeach
    </div>
  </div>

  {{-- CTA --}}
  <div class="ls-cta reveal">
    <a href="#booking" class="btn-primary">Book a Lesson Now</a>
    <a href="#artists" class="btn-secondary">Talk to a Teacher</a>
  </div>

</div>
</section>