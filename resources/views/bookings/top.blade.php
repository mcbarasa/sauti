<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400&display=swap');

  * { box-sizing: border-box; margin: 0; padding: 0; }

  #hero {
    min-height: 92vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 8rem 1.5rem 4rem;
    position: relative;
    overflow: hidden;
    font-family: 'DM Sans', sans-serif;
    background: #0a0a0a;
  }

  .slides { position: absolute; inset: 0; z-index: 0; }

  .slide {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 1.2s ease;
  }
  .slide.active { opacity: 1; }

  .slide:nth-child(1) { animation: kb1 8s ease-in-out infinite alternate; }
  .slide:nth-child(2) { animation: kb2 8s ease-in-out infinite alternate; }
  .slide:nth-child(3) { animation: kb3 8s ease-in-out infinite alternate; }
  .slide:nth-child(4) { animation: kb4 8s ease-in-out infinite alternate; }

  @keyframes kb1 { from { transform: scale(1.08) translate(1%,1%); } to { transform: scale(1) translate(-1%,-1%); } }
  @keyframes kb2 { from { transform: scale(1) translate(-1%,-1%); } to { transform: scale(1.08) translate(1%,1%); } }
  @keyframes kb3 { from { transform: scale(1.06) translate(-1%,1%); } to { transform: scale(1) translate(1%,-1%); } }
  @keyframes kb4 { from { transform: scale(1) translate(1%,-1%); } to { transform: scale(1.06) translate(-1%,1%); } }

  .slide::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.25) 40%, rgba(0,0,0,0.55) 100%);
  }

  .overlay-grid {
    position: absolute; inset: 0; z-index: 1; pointer-events: none;
    background-image:
      linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
    background-size: 80px 80px;
  }

  .overlay-glow {
    position: absolute; inset: 0; z-index: 1; pointer-events: none;
    background: radial-gradient(ellipse 70% 50% at 50% 65%, rgba(234,179,8,0.18) 0%, transparent 70%);
  }

  .hero-content { position: relative; z-index: 10; display: flex; flex-direction: column; align-items: center; }

  .hero-eyebrow {
    font-size: 0.72rem; letter-spacing: 5px; text-transform: uppercase;
    color: #EAB308; margin-bottom: 1.5rem; animation: fadeUp 0.9s ease both;
  }

  .hero-h1 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(3.2rem, 10vw, 8.5rem);
    letter-spacing: 4px; line-height: 0.93; color: #f5f5f5;
    animation: fadeUp 0.9s 0.1s ease both;
  }
  .hero-h1 span { color: #EAB308; display: block; }

  .hero-sub {
    font-size: 1rem; color: rgba(255,255,255,0.65); max-width: 500px;
    margin: 1.6rem auto 0; font-weight: 300; line-height: 1.65;
    animation: fadeUp 0.9s 0.2s ease both;
  }

  .hero-buttons {
    display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;
    margin-top: 2.2rem; animation: fadeUp 0.9s 0.3s ease both;
  }

  .btn-primary {
    padding: 0.7rem 2rem; background: #EAB308; color: #0a0a0a;
    font-family: 'DM Sans', sans-serif; font-weight: 500; font-size: 0.85rem;
    letter-spacing: 2px; text-transform: uppercase; text-decoration: none;
    border-radius: 2px; transition: background 0.2s, transform 0.15s;
  }
  .btn-primary:hover { background: #facc15; transform: translateY(-2px); }

  .btn-secondary {
    padding: 0.7rem 2rem; background: transparent; color: #f5f5f5;
    font-family: 'DM Sans', sans-serif; font-weight: 400; font-size: 0.85rem;
    letter-spacing: 2px; text-transform: uppercase; text-decoration: none;
    border: 1px solid rgba(255,255,255,0.3); border-radius: 2px;
    transition: border-color 0.2s, transform 0.15s;
  }
  .btn-secondary:hover { border-color: #EAB308; color: #EAB308; transform: translateY(-2px); }

  .hero-stats {
    display: flex; gap: 2.5rem; flex-wrap: wrap; justify-content: center;
    margin-top: 3rem; animation: fadeUp 0.9s 0.4s ease both;
  }
  .stat-val { font-family: 'Bebas Neue', sans-serif; font-size: 2.4rem; color: #EAB308; display: block; letter-spacing: 2px; }
  .stat-label { font-size: 0.68rem; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,0.4); }

  .slide-dots { position: absolute; bottom: 5.5rem; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; z-index: 20; }
  .dot {
    width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.3);
    cursor: pointer; transition: background 0.3s, transform 0.3s; border: none;
  }
  .dot.active { background: #EAB308; transform: scale(1.35); }

  .arrow-nav {
    position: absolute; top: 50%; transform: translateY(-50%); z-index: 20;
    background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15);
    color: #fff; width: 44px; height: 44px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 18px; transition: background 0.2s, border-color 0.2s;
  }
  .arrow-nav:hover { background: rgba(234,179,8,0.25); border-color: #EAB308; }
  .arrow-left { left: 1.5rem; }
  .arrow-right { right: 1.5rem; }

  .progress-bar { position: absolute; bottom: 0; left: 0; height: 2px; background: #EAB308; z-index: 20; width: 0%; transition: width 0.1s linear; }

  .hero-wave { position: absolute; bottom: -1px; left: 0; right: 0; height: 60px; z-index: 15; pointer-events: none; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @media (max-width: 600px) {
  #sg-hero { padding: 5.5rem 1rem 4.5rem; }
  .sg-arrow { display: none; }
  .sg-stats { gap: 1rem; }
  .sg-divider { height: 28px; }
  .sg-buttons { flex-direction: column; align-items: center; }
  .sg-btn-primary, .sg-btn-secondary { width: 100%; max-width: 260px; text-align: center; }
  .sg-dots { bottom: 3.8rem; }
}
</style>

<section id="hero">
  <div class="slides">
    <!-- Replace these URLs with your own studio photos -->
    <div class="slide active" style="background-image:url('https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?w=1600&q=80');"></div>
    <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=1600&q=80');"></div>
    <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?w=1600&q=80');"></div>
    <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1478737270239-2f02b77fc618?w=1600&q=80');"></div>
  </div>

  <div class="overlay-grid"></div>
  <div class="overlay-glow"></div>

  <button class="arrow-nav arrow-left" onclick="prevSlide()">&#8592;</button>
  <button class="arrow-nav arrow-right" onclick="nextSlide()">&#8594;</button>

  <div class="hero-content">
    <p class="hero-eyebrow">Nairobi's Premier Rehearsal Space</p>
    <h1 class="hero-h1">Where Sound<br><span>Becomes Art</span></h1>
    <p class="hero-sub">Sauti Gang Studio — a creative sanctuary for bands, musicians &amp; artists to rehearse, record, and sharpen their craft.</p>
    <div class="hero-buttons">
      <a href="#booking" class="btn-primary">Book a Session</a>
      <a href="#artists" class="btn-secondary">Artists</a>
    </div>
    <div class="hero-stats">
      <div style="text-align:center;"><span class="stat-val">50+</span><span class="stat-label">Artists</span></div>
      <div style="text-align:center;"><span class="stat-val">2</span><span class="stat-label">Studio Rooms</span></div>
      <div style="text-align:center;"><span class="stat-val">4+</span><span class="stat-label">Years Active</span></div>
      <div style="text-align:center;"><span class="stat-val">12 Hrs</span><span class="stat-label">Daily Access</span></div>
    </div>
  </div>

  <div class="slide-dots">
    <button class="dot active" onclick="goSlide(0)"></button>
    <button class="dot" onclick="goSlide(1)"></button>
    <button class="dot" onclick="goSlide(2)"></button>
    <button class="dot" onclick="goSlide(3)"></button>
  </div>

  <div class="progress-bar" id="progressBar"></div>

  <svg class="hero-wave" viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0 60 L0 30 Q180 0 360 30 Q540 60 720 30 Q900 0 1080 30 Q1260 60 1440 30 L1440 60 Z" fill="var(--wave-fill, #0a0a0a)"/>
  </svg>
</section>

<script>
  const slides = document.querySelectorAll('.slide');
  const dots = document.querySelectorAll('.dot');
  const bar = document.getElementById('progressBar');
  const INTERVAL = 5000;
  let current = 0, timer, progressTimer, elapsed = 0;

  function showSlide(n) {
    slides[current].classList.remove('active');
    dots[current].classList.remove('active');
    current = (n + slides.length) % slides.length;
    slides[current].classList.add('active');
    dots[current].classList.add('active');
    resetProgress();
  }

  function nextSlide() { showSlide(current + 1); }
  function prevSlide() { showSlide(current - 1); }
  function goSlide(n) { showSlide(n); }

  function resetProgress() {
    elapsed = 0; bar.style.width = '0%';
    clearInterval(timer); clearInterval(progressTimer);
    startAutoplay();
  }

  function startAutoplay() {
    progressTimer = setInterval(() => {
      elapsed += 50;
      bar.style.width = Math.min((elapsed / INTERVAL) * 100, 100) + '%';
    }, 50);
    timer = setTimeout(nextSlide, INTERVAL);
  }

  startAutoplay();
</script>