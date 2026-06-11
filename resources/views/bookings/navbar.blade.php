<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/webp" href="{{ asset('img/sauti_logo.WebP') }}">
<title>@yield('title', 'Sauti Gang Studio')</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,700;1,300&display=swap" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
:root {
  --yellow: #F5C518; --yellow-dark: #D4A017; --yellow-deep: #A07800;
  --bg: #0A0A0A; --bg-alt: #111111; --surface: #171717; --surface2: #1F1F1F; --surface3: #2A2A2A;
  --border: rgba(255,255,255,0.07); --border-y: rgba(245,197,24,0.20);
  --yellow-bg: rgba(245,197,24,0.10); --text: #F0F0F0; --text2: #CCCCCC;
  --gray: #888888; --gray-light: #CCCCCC; --nav-bg: rgba(10,10,10,0.92);
  --wave-fill: #111111; --hero-glow: rgba(245,197,24,0.08); --grid-line: rgba(245,197,24,0.04);
  --footer-bg: #0A0A0A; --map-filter: grayscale(80%) invert(90%) contrast(90%);
  --shadow: 0 4px 24px rgba(0,0,0,0.4); --input-bg: #1F1F1F;
  --btn-sec-border: rgba(255,255,255,0.25); --btn-sec-hover: var(--yellow);
  --about-fill: #1A1A1A; --gallery-fill1: #1A1A1A; --gallery-fill2: #161616;
  --gallery-fill3: #131313; --gallery-fill4: #181818;
  --hours-border: rgba(255,255,255,0.06);
  --confirm-bg: rgba(100,200,100,0.10); --confirm-border: rgba(100,200,100,0.30); --confirm-color: #6ECB6E;
  --notice-bg: rgba(245,197,24,0.08); --notice-border: rgba(245,197,24,0.25);
  --auth-overlay-bg: rgba(0,0,0,0.80); --modal-bg: #171717;
  --plan-card-bg: #1F1F1F; --plan-feat-border: var(--yellow);
  --green-bg:var(--confirm-color);
}
[data-theme="light"] {
  --bg: #F5F2ED; --bg-alt: #FFFFFF; --surface: #FFFFFF; --surface2: #F9F7F4; --surface3: #EDE9E2;
  --border: rgba(0,0,0,0.09); --border-y: rgba(160,120,0,0.28); --yellow-bg: rgba(245,197,24,0.12);
  --text: #1A1A1A; --text2: #333333; --gray: #6B6560; --gray-light: #444444;
  --nav-bg: rgba(255,255,255,0.94); --wave-fill: #FFFFFF; --hero-glow: rgba(212,160,23,0.09);
  --grid-line: rgba(160,120,0,0.05); --footer-bg: #F5F2ED;
  --map-filter: grayscale(20%) contrast(95%); --shadow: 0 4px 24px rgba(0,0,0,0.10);
  --input-bg: #F0EDE8; --btn-sec-border: rgba(0,0,0,0.20); --btn-sec-hover: var(--yellow-dark);
  --about-fill: #EDE9E2; --hours-border: rgba(0,0,0,0.06);
  --confirm-bg: rgba(40,160,80,0.08); --confirm-border: rgba(40,160,80,0.30); --confirm-color: #1A8040;
  --notice-bg: rgba(212,160,23,0.08); --notice-border: rgba(160,120,0,0.25);
  --auth-overlay-bg: rgba(0,0,0,0.50); --modal-bg: #FFFFFF;
  --plan-card-bg: #F5F2ED; --plan-feat-border: var(--yellow-dark);
}
* { margin:0; padding:0; box-sizing:border-box; }
html { scroll-behavior:smooth; }
body { background:var(--bg); color:var(--text); font-family:'DM Sans',sans-serif; font-size:16px; line-height:1.6; overflow-x:hidden; transition:background 0.4s ease,color 0.4s ease; }
nav,section,footer,.card,.booking-form,.feature-pill,.hours-list li,.artist-card,.gallery-cell,.contact-icon,.social-btn,.plan-card,.form-group input,.form-group select,.form-group textarea,.cal-day,.cal-nav-btn { transition:background 0.4s ease,border-color 0.4s ease,color 0.35s ease,box-shadow 0.35s ease; }

/* THEME TOGGLE */
.theme-toggle-btn { display:flex; align-items:center; gap:8px; background:var(--surface2); border:1px solid var(--border); border-radius:30px; padding:5px 10px 5px 8px; cursor:pointer; font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:var(--gray); white-space:nowrap; transition:border-color 0.2s,color 0.2s,background 0.4s !important; }
.theme-toggle-btn:hover { border-color:var(--yellow); color:var(--yellow); }
.tt-track { width:34px; height:18px; border-radius:9px; background:var(--surface3); border:1px solid var(--border); position:relative; flex-shrink:0; transition:background 0.3s !important; }
[data-theme="light"] .tt-track { background:rgba(212,160,23,0.20); border-color:var(--border-y); }
.tt-thumb { position:absolute; top:2px; left:2px; width:12px; height:12px; border-radius:50%; background:var(--gray); transition:transform 0.3s,background 0.3s !important; }
[data-theme="light"] .tt-thumb { transform:translateX(16px); background:var(--yellow-dark); }
.tt-icon::before { content:'🌙'; }
[data-theme="light"] .tt-icon::before { content:'☀️'; }

/* NAV */
nav { position:fixed; top:0; left:0; right:0; z-index:1000; display:flex; align-items:center; justify-content:space-between; padding:1rem 3rem; background:var(--nav-bg); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px); border-bottom:1px solid var(--border); }
.logo-wrap { display:flex; align-items:center; gap:12px; text-decoration:none; }
.logo-icon { width:44px; height:44px; flex-shrink:0; }
.logo-text { display:flex; flex-direction:column; line-height:1; }
.logo-text span:first-child { font-family:'Bebas Neue',sans-serif; font-size:1.4rem; letter-spacing:3px; color:var(--yellow); }
.logo-text span:last-child { font-size:0.65rem; letter-spacing:4px; text-transform:uppercase; color:var(--gray); margin-top:2px; }
.nav-links { display:flex; gap:1.5rem; list-style:none; align-items:center; }
.nav-links a { text-decoration:none; color:var(--gray-light); font-size:0.85rem; letter-spacing:1.5px; text-transform:uppercase; transition:color 0.2s; }
.nav-links a:hover { color:var(--yellow); }
.nav-cta { background:var(--yellow) !important; color:var(--bg) !important; padding:0.5rem 1.2rem !important; border-radius:3px; font-weight:700 !important; transition:background 0.2s !important; }
.nav-cta:hover { background:var(--yellow-dark) !important; }

/* HAMBURGER */
.nav-hamburger { display:none; flex-direction:column; justify-content:center; gap:5px; background:none; border:none; cursor:pointer; padding:4px; z-index:1100; }
.nav-hamburger span { display:block; width:24px; height:2px; background:var(--gray-light); border-radius:2px; transition:transform 0.3s,opacity 0.3s,background 0.2s; }
.nav-hamburger:hover span { background:var(--yellow); }
.nav-hamburger.open span:nth-child(1) { transform:translateY(7px) rotate(45deg); }
.nav-hamburger.open span:nth-child(2) { opacity:0; }
.nav-hamburger.open span:nth-child(3) { transform:translateY(-7px) rotate(-45deg); }

/* MOBILE MENU DRAWER */
.mobile-menu { display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:999; background:var(--bg); padding:5.5rem 2rem 2rem; flex-direction:column; gap:0; overflow-y:auto; }
.mobile-menu.open { display:flex; }
.mobile-menu li { list-style:none; border-bottom:1px solid var(--border); }
.mobile-menu li a { display:block; padding:1rem 0; color:var(--text); font-size:1rem; letter-spacing:2px; text-transform:uppercase; text-decoration:none; transition:color 0.2s; }
.mobile-menu li a:hover { color:var(--yellow); }
.mobile-menu .mobile-cta { margin-top:1.5rem; }
.mobile-menu .mobile-cta a { background:var(--yellow); color:#0A0A0A !important; text-align:center; border-radius:3px; padding:0.9rem 0 !important; font-weight:700; }
.mobile-menu .theme-row { margin-top:1rem; display:flex; align-items:center; justify-content:space-between; padding:0.75rem 0; border-bottom:1px solid var(--border); }
.mobile-menu .theme-row label { font-size:0.8rem; letter-spacing:2px; text-transform:uppercase; color:var(--gray); }

/* GLOBAL BUTTONS */
.btn-primary { background:var(--yellow); color:#0A0A0A; padding:0.9rem 2.2rem; font-weight:700; font-size:0.9rem; letter-spacing:1.5px; text-transform:uppercase; border:none; border-radius:3px; cursor:pointer; text-decoration:none; display:inline-block; transition:background 0.2s,transform 0.15s; }
.btn-primary:hover { background:var(--yellow-dark); transform:translateY(-2px); }
[data-theme="light"] .btn-primary { color:#fff; background:var(--yellow-dark); }
[data-theme="light"] .btn-primary:hover { background:var(--yellow-deep); }
.btn-secondary { background:transparent; color:var(--text); padding:0.9rem 2.2rem; font-size:0.9rem; letter-spacing:1.5px; text-transform:uppercase; border:1px solid var(--btn-sec-border); border-radius:3px; cursor:pointer; text-decoration:none; display:inline-block; transition:border-color 0.2s,color 0.2s,transform 0.15s; }
.btn-secondary:hover { border-color:var(--yellow); color:var(--yellow); transform:translateY(-2px); }
.btn-danger { background:rgba(229,90,90,0.15); color:#E55A5A; border:1px solid rgba(229,90,90,0.3); padding:0.4rem 1rem; font-size:0.78rem; letter-spacing:1px; text-transform:uppercase; border-radius:3px; cursor:pointer; text-decoration:none; display:inline-block; transition:background 0.2s; }
.btn-danger:hover { background:rgba(229,90,90,0.3); }

/* SECTIONS */
section { padding:6rem 2rem; }
.container { max-width:1100px; margin:0 auto; }
.section-label { font-size:0.75rem; letter-spacing:5px; text-transform:uppercase; color:var(--yellow); margin-bottom:0.75rem; }
[data-theme="light"] .section-label { color:var(--yellow-deep); }
.section-title { font-family:'Bebas Neue',sans-serif; font-size:clamp(2.5rem,5vw,4rem); letter-spacing:2px; line-height:1; color:var(--text); margin-bottom:1rem; }
.section-sub { color:var(--gray); max-width:550px; font-weight:300; font-size:1.05rem; }

/* FORMS */
.form-group { display:flex; flex-direction:column; gap:0.4rem; margin-bottom:1rem; }
.form-group label { font-size:0.75rem; letter-spacing:2px; text-transform:uppercase; color:var(--gray); }
.form-group input,.form-group select,.form-group textarea { background:var(--input-bg); border:1px solid var(--border-y); border-radius:3px; padding:0.7rem 1rem; color:var(--text); font-family:'DM Sans',sans-serif; font-size:0.95rem; outline:none; width:100%; }
.form-group input:focus,.form-group select:focus,.form-group textarea:focus { border-color:var(--yellow); }
.form-group select option { background:var(--input-bg); }
.form-group textarea { resize:vertical; min-height:80px; }
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:0; }
.input-error { color:#E55A5A; font-size:0.78rem; margin-top:0.2rem; }
.error-banner { background:rgba(229,90,90,0.1); border:1px solid rgba(229,90,90,0.3); color:#E55A5A; border-radius:4px; padding:0.8rem 1rem; font-size:0.85rem; margin-bottom:1rem; }

/* BOOKING SECTION */
#booking { background:var(--bg-alt); }
.booking-wrap { display:grid; grid-template-columns:1fr 1.3fr; gap:4rem; margin-top:3rem; align-items:start; }
.booking-info h3 { font-family:'Bebas Neue',sans-serif; font-size:1.6rem; letter-spacing:2px; color:var(--yellow); margin-bottom:1rem; }
[data-theme="light"] .booking-info h3 { color:var(--yellow-deep); }
.booking-info p { color:var(--gray); font-weight:300; margin-bottom:1.5rem; }
.hours-list { list-style:none; }
.hours-list li { display:flex; justify-content:space-between; padding:0.5rem 0; border-bottom:1px solid var(--hours-border); font-size:0.9rem; color:var(--text2); }
.hours-list li span { color:var(--yellow); }
[data-theme="light"] .hours-list li span { color:var(--yellow-deep); }
.booking-form { background:var(--surface); border:1px solid var(--border-y); border-radius:4px; padding:2rem; box-shadow:var(--shadow); }

/* CALENDAR */
.mini-calendar { margin-bottom:1.2rem; }
.cal-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:0.75rem; }
.cal-header h4 { font-size:0.9rem; font-weight:500; letter-spacing:1px; color:var(--text); }
.cal-nav-btn { background:none; border:1px solid var(--border); border-radius:3px; color:var(--text2); padding:4px 10px; cursor:pointer; font-size:0.9rem; }
.cal-nav-btn:hover { border-color:var(--yellow); color:var(--yellow); }
.cal-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:3px; }
.cal-day-name { text-align:center; font-size:0.7rem; letter-spacing:1px; text-transform:uppercase; color:var(--gray); padding:4px 0; }
.cal-day { text-align:center; font-size:0.82rem; padding:6px 3px; border-radius:3px; cursor:pointer; color:var(--text2); }
.cal-day:hover:not(.empty):not(.past) { background:var(--yellow-bg); color:var(--yellow); }
.cal-day.selected { background:var(--yellow); color:#0A0A0A; font-weight:700; }
[data-theme="light"] .cal-day.selected { background:var(--yellow-dark); color:#fff; }
.cal-day.booked { color:var(--gray); }
.cal-day.booked::after { content:''; display:block; width:4px; height:4px; background:#E55A5A; border-radius:50%; margin:1px auto 0; }
.cal-day.past { opacity:0.3; pointer-events:none; }
.cal-day.empty { pointer-events:none; }
.cal-day.today { color:var(--yellow); font-weight:700; }
[data-theme="light"] .cal-day.today { color:var(--yellow-dark); }

.slot-notice { background:var(--notice-bg); border:1px solid var(--notice-border); border-radius:3px; padding:0.75rem 1rem; font-size:0.82rem; color:var(--yellow); margin-bottom:1rem; display:none; }
[data-theme="light"] .slot-notice { color:var(--yellow-deep); }
.slot-notice.show { display:block; }
.booking-confirm-msg { background:var(--confirm-bg); border:1px solid var(--confirm-border); color:var(--confirm-color); border-radius:3px; padding:1rem; font-size:0.9rem; text-align:center; margin-top:1rem; }

/* FOOTER */
footer { background:var(--footer-bg); border-top:1px solid var(--border); padding:2.5rem 2rem; }
.footer-inner { max-width:1100px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; }
.footer-copy { color:var(--gray); font-size:0.85rem; }

/* REVEAL */
@keyframes fadeUp { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:translateY(0)} }
.reveal { opacity:0; transform:translateY(24px); transition:opacity 0.7s ease,transform 0.7s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }

/* ADMIN TABLE */
.admin-wrap { padding:6rem 2rem 4rem; min-height:100vh; }
.admin-table { width:100%; border-collapse:collapse; font-size:0.88rem; }
.admin-table th { background:var(--surface2); color:var(--gray); font-size:0.7rem; letter-spacing:2px; text-transform:uppercase; padding:0.75rem 1rem; text-align:left; border-bottom:1px solid var(--border-y); }
.admin-table td { padding:0.75rem 1rem; border-bottom:1px solid var(--border); color:var(--text2); vertical-align:middle; }
.admin-table tr:hover td { background:var(--surface2); }
.status-pill { display:inline-block; padding:2px 10px; border-radius:20px; font-size:0.72rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; }
.status-pending   { background:rgba(245,197,24,0.12); color:var(--yellow); }
.status-confirmed { background:var(--confirm-bg); color:var(--confirm-color); }
.status-cancelled { background:rgba(229,90,90,0.1); color:#E55A5A; }

/* CONFIRMATION PAGE */
.confirm-card { max-width:560px; margin:8rem auto 4rem; background:var(--surface); border:1px solid var(--border-y); border-radius:8px; padding:3rem 2.5rem; box-shadow:var(--shadow); text-align:center; }
.confirm-icon { font-size:3rem; display:block; margin-bottom:1rem; }
.confirm-card h1 { font-family:'Bebas Neue',sans-serif; font-size:2.5rem; letter-spacing:3px; color:var(--yellow); margin-bottom:0.5rem; }
.confirm-detail { display:flex; justify-content:space-between; padding:0.6rem 0; border-bottom:1px solid var(--border); font-size:0.9rem; }
.confirm-detail span:first-child { color:var(--gray); text-transform:uppercase; font-size:0.75rem; letter-spacing:2px; }
.confirm-detail span:last-child { color:var(--text); font-weight:500; }

/* Gallery */
.gallery-cell { position:relative; overflow:hidden; background:var(--surface2); border:1px solid var(--border); border-radius:4px; }
.gallery-cell img { width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.5s ease; }
.gallery-cell:hover img { transform:scale(1.07); }
.gallery-cell .caption { position:absolute; bottom:0; left:0; right:0; background:linear-gradient(transparent,rgba(0,0,0,0.80)); padding:1rem; font-size:0.8rem; color:#eee; letter-spacing:1px; transition:padding 0.3s ease; }
.gallery-cell:hover .caption { padding-bottom:1.25rem; }

/* Logo theme switching */
.site-logo {
  height: 38px;
  width: auto;
  display: block;
  filter: invert(1) hue-rotate(180deg) saturate(3) brightness(1.1);
  transition: filter 0.35s ease;
  transform: scale(1.8);
}
[data-theme="dark"] .site-logo { filter: none; }

/* ═══════════════════════════════════════════
   RESPONSIVE BREAKPOINTS
   All functionality preserved; layout adapts
═══════════════════════════════════════════ */

/* ── Large tablets (≤1024px) ── */
@media (max-width:1024px) {
  nav { padding:1rem 2rem; }
  .booking-wrap { gap:2.5rem; }
  .admin-wrap { padding:5rem 1.5rem 3rem; }
}

/* ── Tablets (≤768px) ── */
@media (max-width:768px) {
  /* Nav */
  nav { padding:0.85rem 1.25rem; }
  .nav-links { display:none; }
  .nav-hamburger { display:flex; }

  /* Sections */
  section { padding:4.5rem 1.25rem; }
  .section-title { font-size:clamp(2rem,8vw,3rem); }

  /* Booking */
  .booking-wrap { grid-template-columns:1fr; gap:2rem; }
  .booking-form { padding:1.5rem; }

  /* Form rows collapse to single column */
  .form-row { grid-template-columns:1fr; }

  /* Confirmation card */
  .confirm-card { margin:6rem 1.25rem 3rem; padding:2rem 1.5rem; }

  /* Admin table: enable horizontal scroll */
  .admin-wrap { padding:5rem 1.25rem 3rem; overflow-x:auto; }
  .admin-table { min-width:640px; }

  /* Footer */
  .footer-inner { flex-direction:column; align-items:flex-start; gap:0.75rem; }
}

/* ── Small phones (≤480px) ── */
@media (max-width:480px) {
  nav { padding:0.75rem 1rem; }

  .site-logo { height:30px; transform:scale(1.5); }

  section { padding:4rem 1rem; }

  .btn-primary,
  .btn-secondary { padding:0.8rem 1.5rem; font-size:0.85rem; width:100%; text-align:center; }

  .booking-form { padding:1.25rem 1rem; }

  /* Calendar touch targets: slightly bigger cells */
  .cal-day { padding:8px 2px; font-size:0.78rem; }

  /* Confirm card full-width */
  .confirm-card { margin:5.5rem 0.75rem 2rem; padding:1.75rem 1.25rem; }
  .confirm-detail { flex-direction:column; gap:0.25rem; }
  .confirm-detail span:last-child { font-size:0.95rem; }

  /* Admin table stays scrollable */
  .admin-table th,
  .admin-table td { padding:0.6rem 0.75rem; }
}

/* ── Very small phones (≤360px) ── */
@media (max-width:360px) {
  .section-title { font-size:2rem; }
  .section-sub { font-size:0.95rem; }
}
</style>
</head>
<body>

<!-- NAV -->
<nav>
  <a class="logo-wrap" href="{{ route('home') }}" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
    <img src="{{ asset('img/sauti_logo.webp') }}"
         alt="Sauti Gang Studios"
         class="site-logo"
         style="height:40px;width:auto;display:block;" />
  </a>

  <!-- Desktop nav links -->
  <ul class="nav-links">
    <li><a href="{{ route('home') }}#about">About</a></li>
    <li><a href="{{ route('home') }}#artists">Artists</a></li>
    <li><a href="{{ route('home') }}#contact">Contact</a></li>
    {{-- <li><a href="{{ route('bookings.admin') }}">Admin</a></li> --}}
    <li>
      <button class="theme-toggle-btn" onclick="toggleTheme()" title="Toggle light / dark mode">
        <span class="tt-icon"></span>
        <div class="tt-track"><div class="tt-thumb"></div></div>
      </button>
    </li>
    <li><a href="{{ route('bookings.initiate') }}" class="nav-cta">Book a Session</a></li>
  </ul>

  <!-- Hamburger (mobile only) -->
  <button class="nav-hamburger" id="navHamburger" aria-label="Toggle navigation menu" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
  </button>
</nav>

</body>
</html>