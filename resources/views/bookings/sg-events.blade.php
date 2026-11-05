@php
    // ---- EDIT THESE ----
    $phone      = '+254112935073';   // shown on Call button
    $whatsapp   = '254112935073';    // digits only, no +
    $email      = 'hey@sautigang.com';
    $logo_path  = 'img/sauti_logo.webp';   // inside public/ (lowercase .webp, Linux paths are case sensitive)
    $heroImage  = 'events/hero.jpg';   // optional background
    $gallery = [
        'wedding.jpg' => 'Weddings',
        'dj-set.jpg'            => 'DJ night',
        'graduation.jpg'        => 'Graduation party',
        'gathering.jpg'        => 'Gathering',
        'birthday.jpg'          => 'Birthday party',
        'mixer.jpg'    => 'Events and Concerts',
    ];
    $occasions = [
        ['🎓','Graduation parties','Clear speeches and a dance floor that keeps going.'],
        ['💍','Weddings & receptions','MC mics, music and a smooth program from first dance to last.'],
        ['🥂','Pre-weddings','Introductions, kesha and send-offs with sound that fits the room.'],
        ['🎂','Birthday parties','From small gardens to full halls, with a DJ who reads the crowd.'],
        ['🤝','Club meetings','Wireless mics so everyone is heard, front row to back.'],
        ['🙏','Fellowships','Warm, balanced sound for worship, preaching and choirs.'],
    ];
    $gear = [
        ['🔊','Speakers','Tops and subs sized to your crowd and venue.'],
        ['🎤','Microphones','Wireless handhelds and lapel mics for MCs and speakers.'],
        ['🎛️','Mixer','Multi-channel mixing for bands, DJs and speeches.'],
        ['💿','DJ decks','Pro decks and controllers, ready to play.'],
        ['🎧','DJ','An experienced DJ for any genre or age group.'],
        ['🧑‍🔧','Sound engineer','On-site setup, soundcheck and live mixing.'],
    ];
@endphp
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/webp" href="{{ asset($logo_path) }}">
<title>@yield('title', 'SG Events | Sound, DJ & Engineers for Events | Sauti Gang Studios')</title>
<meta name="description" content="Sauti Gang Studios provides speakers, microphones, mixers, DJs, DJ decks and sound engineers for weddings, graduations, birthdays, club meetings and fellowships.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
<script>
  try { var t = localStorage.getItem('sg-theme'); if (t) document.documentElement.setAttribute('data-theme', t); } catch(e){}
</script>
<style>
:root {
  --yellow:#F5C518; --yellow-dark:#D4A017; --yellow-deep:#A07800;
  --bg:#0A0A0A; --bg-alt:#111111; --surface:#171717; --surface2:#1F1F1F; --surface3:#2A2A2A;
  --border:rgba(255,255,255,0.07); --border-y:rgba(245,197,24,0.20); --yellow-bg:rgba(245,197,24,0.10);
  --text:#F0F0F0; --text2:#CCCCCC; --gray:#888888; --gray-light:#CCCCCC;
  --nav-bg:rgba(10,10,10,0.92); --hero-glow:rgba(245,197,24,0.08); --grid-line:rgba(245,197,24,0.04);
  --footer-bg:#0A0A0A; --shadow:0 4px 24px rgba(0,0,0,0.4); --input-bg:#1F1F1F;
  --btn-sec-border:rgba(255,255,255,0.25); --hero-overlay:rgba(10,10,10,0.72);
  --confirm-bg:rgba(100,200,100,0.10); --confirm-border:rgba(100,200,100,0.30); --confirm-color:#6ECB6E;
}
[data-theme="light"] {
  --bg:#F5F2ED; --bg-alt:#FFFFFF; --surface:#FFFFFF; --surface2:#F9F7F4; --surface3:#EDE9E2;
  --border:rgba(0,0,0,0.09); --border-y:rgba(160,120,0,0.28); --yellow-bg:rgba(245,197,24,0.12);
  --text:#1A1A1A; --text2:#333333; --gray:#6B6560; --gray-light:#444444;
  --nav-bg:rgba(255,255,255,0.94); --hero-glow:rgba(212,160,23,0.09); --grid-line:rgba(160,120,0,0.05);
  --footer-bg:#F5F2ED; --shadow:0 4px 24px rgba(0,0,0,0.10); --input-bg:#F0EDE8;
  --btn-sec-border:rgba(0,0,0,0.20); --hero-overlay:rgba(245,242,237,0.80);
  --confirm-bg:rgba(40,160,80,0.08); --confirm-border:rgba(40,160,80,0.30); --confirm-color:#1A8040;
}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{background:var(--bg);color:var(--text);font-family:'DM Sans',sans-serif;font-size:16px;line-height:1.6;overflow-x:hidden;transition:background .4s,color .35s}
nav,section,footer,.card,.booking-form,.gallery-cell,.form-group input,.form-group select,.form-group textarea{transition:background .4s,border-color .4s,color .35s}
a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible,textarea:focus-visible{outline:2px solid var(--yellow);outline-offset:2px}

/* Theme toggle */
.theme-toggle-btn{display:flex;align-items:center;gap:8px;background:var(--surface2);border:1px solid var(--border);border-radius:30px;padding:5px 10px 5px 8px;cursor:pointer;font:600 .75rem 'DM Sans',sans-serif;letter-spacing:1px;text-transform:uppercase;color:var(--gray);white-space:nowrap}
.theme-toggle-btn:hover{border-color:var(--yellow);color:var(--yellow)}
.tt-track{width:34px;height:18px;border-radius:9px;background:var(--surface3);border:1px solid var(--border);position:relative;flex-shrink:0}
.tt-thumb{position:absolute;top:2px;left:2px;width:12px;height:12px;border-radius:50%;background:var(--gray);transition:transform .3s,background .3s}
[data-theme="light"] .tt-track{background:rgba(212,160,23,.2);border-color:var(--border-y)}
[data-theme="light"] .tt-thumb{transform:translateX(16px);background:var(--yellow-dark)}
.tt-icon::before{content:'🌙'}
[data-theme="light"] .tt-icon::before{content:'☀️'}

/* Nav */
nav{position:fixed;top:0;left:0;right:0;z-index:1000;display:flex;align-items:center;justify-content:space-between;padding:1rem 3rem;background:var(--nav-bg);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);border-bottom:1px solid var(--border)}
.logo-wrap{display:flex;align-items:center;gap:12px;text-decoration:none}
.logo-text{display:flex;flex-direction:column;line-height:1}
.logo-text span:first-child{font-family:'Bebas Neue',sans-serif;font-size:1.4rem;letter-spacing:3px;color:var(--yellow)}
.logo-text span:last-child{font-size:.65rem;letter-spacing:4px;text-transform:uppercase;color:var(--gray);margin-top:2px}
/* Logo (same treatment as the Learn page: sized, and recoloured for the light theme) */
.site-logo{height:38px;width:auto;display:block;filter:invert(1) hue-rotate(180deg) saturate(3) brightness(1.1);transition:filter .35s ease;transform:scale(1.8)}
[data-theme="dark"] .site-logo{filter:none}
.nav-links{display:flex;gap:1.5rem;list-style:none;align-items:center}
.nav-links a{text-decoration:none;color:var(--gray-light);font-size:.85rem;letter-spacing:1.5px;text-transform:uppercase;transition:color .2s}
.nav-links a:hover{color:var(--yellow)}
.nav-links a.nav-cta{background:var(--yellow);color:#0A0A0A;padding:.5rem 1.2rem;border-radius:3px;font-weight:700}
.nav-links a.nav-cta:hover{background:var(--yellow-dark);color:#0A0A0A}
.nav-hamburger{display:none;flex-direction:column;justify-content:center;gap:5px;background:none;border:none;cursor:pointer;padding:4px;z-index:1100}
.nav-hamburger span{display:block;width:24px;height:2px;background:var(--gray-light);border-radius:2px;transition:transform .3s,opacity .3s}
.nav-hamburger.open span:nth-child(1){transform:translateY(7px) rotate(45deg)}
.nav-hamburger.open span:nth-child(2){opacity:0}
.nav-hamburger.open span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}
.mobile-menu{display:none;position:fixed;inset:0;z-index:999;background:var(--bg);padding:5.5rem 2rem 2rem;flex-direction:column;overflow-y:auto;list-style:none}
.mobile-menu.open{display:flex}
.mobile-menu li{list-style:none;border-bottom:1px solid var(--border)}
.mobile-menu li a{display:block;padding:1rem 0;color:var(--text);font-size:1rem;letter-spacing:2px;text-transform:uppercase;text-decoration:none}
.mobile-menu li a:hover{color:var(--yellow)}
.mobile-menu li.m-cta{margin-top:1.5rem;border:0}
.mobile-menu li.m-cta a{background:var(--yellow);color:#0A0A0A;text-align:center;border-radius:3px;font-weight:700}
.mobile-menu li.m-theme{display:flex;justify-content:space-between;align-items:center;padding:.75rem 0}

/* Buttons */
.btn-primary,.btn-secondary{padding:.9rem 2.2rem;font-size:.9rem;letter-spacing:1.5px;text-transform:uppercase;border-radius:3px;cursor:pointer;text-decoration:none;display:inline-block;font-family:inherit;transition:background .2s,border-color .2s,color .2s,transform .15s}
.btn-primary{background:var(--yellow);color:#0A0A0A;font-weight:700;border:none}
.btn-primary:hover{background:var(--yellow-dark);transform:translateY(-2px)}
[data-theme="light"] .btn-primary{color:#fff;background:var(--yellow-dark)}
[data-theme="light"] .btn-primary:hover{background:var(--yellow-deep)}
.btn-secondary{background:transparent;color:var(--text);border:1px solid var(--btn-sec-border)}
.btn-secondary:hover{border-color:var(--yellow);color:var(--yellow);transform:translateY(-2px)}

/* Sections */
section{padding:6rem 2rem}
.container{max-width:1100px;margin:0 auto}
.section-label{font-size:.75rem;letter-spacing:5px;text-transform:uppercase;color:var(--yellow);margin-bottom:.75rem}
[data-theme="light"] .section-label{color:var(--yellow-deep)}
.section-title{font-family:'Bebas Neue',sans-serif;font-size:clamp(2.5rem,5vw,4rem);letter-spacing:2px;line-height:1;color:var(--text);margin-bottom:1rem}
.section-sub{color:var(--gray);max-width:550px;font-weight:300;font-size:1.05rem}

/* Hero */
.hero{min-height:100vh;display:flex;align-items:center;padding-top:7rem;position:relative;overflow:hidden;
  background:radial-gradient(ellipse at 70% 30%,var(--hero-glow),transparent 60%),
  linear-gradient(var(--grid-line) 1px,transparent 1px) 0 0/48px 48px,
  linear-gradient(90deg,var(--grid-line) 1px,transparent 1px) 0 0/48px 48px,var(--bg)}
.hero-bg{position:absolute;inset:0;background-size:cover;background-position:center}
.hero-bg::after{content:'';position:absolute;inset:0;background:var(--hero-overlay)}
.hero .container{position:relative;z-index:1;width:100%}
.hero h1{font-family:'Bebas Neue',sans-serif;font-size:clamp(3.2rem,11vw,8rem);line-height:.92;letter-spacing:3px;margin:.5rem 0 1.5rem}
.hero h1 em{font-style:normal;color:var(--yellow)}
[data-theme="light"] .hero h1 em{color:var(--yellow-deep)}
.hero p{color:var(--text2);font-weight:300;font-size:1.15rem;max-width:560px;margin-bottom:2rem}
.hero-actions{display:flex;gap:1rem;flex-wrap:wrap}
.eq{display:flex;align-items:flex-end;gap:5px;height:56px;margin-top:3rem}
.eq i{display:block;width:8px;background:var(--yellow);border-radius:2px;height:20%;animation:eq 1.1s ease-in-out infinite}
.eq i:nth-child(2n){animation-duration:.8s}.eq i:nth-child(3n){animation-duration:1.4s}.eq i:nth-child(5n){animation-duration:.65s}
.eq i:nth-child(odd){animation-delay:-.4s}
@keyframes eq{0%,100%{height:15%}50%{height:100%}}
@media (prefers-reduced-motion:reduce){.eq i{animation:none;height:50%}html{scroll-behavior:auto}}

/* Cards */
.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;margin-top:3rem}
.card{background:var(--surface);border:1px solid var(--border);border-radius:4px;padding:1.75rem}
.card:hover{border-color:var(--border-y)}
.card .ico{font-size:1.8rem;display:block;margin-bottom:.75rem}
.card h3{font-family:'Bebas Neue',sans-serif;font-size:1.5rem;letter-spacing:2px;color:var(--yellow);margin-bottom:.25rem}
[data-theme="light"] .card h3{color:var(--yellow-deep)}
.card p{color:var(--gray);font-size:.93rem;font-weight:300}
#gear,#gallery{background:var(--bg-alt)}

/* Gallery */
.gallery-grid{display:grid;grid-template-columns:repeat(3,1fr);grid-auto-rows:240px;gap:1rem;margin-top:3rem}
.gallery-cell{position:relative;overflow:hidden;background:var(--surface2);border:1px solid var(--border);border-radius:4px}
.gallery-cell:nth-child(1),.gallery-cell:nth-child(4){grid-row:span 2}
.gallery-cell img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s}
.gallery-cell:hover img{transform:scale(1.07)}
.gallery-cell .caption{position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(0,0,0,.8));padding:1rem;font-size:.8rem;color:#eee;letter-spacing:1px}
.gallery-cell.empty{display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:var(--gray)}
.gallery-cell.empty .caption{background:none;color:var(--gray)}

/* ═══ IMAGE LIGHTBOX ═══ */
.zoomable{cursor:zoom-in}
.zoom-hint{position:absolute;top:.7rem;right:.7rem;z-index:3;width:34px;height:34px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;background:rgba(10,10,10,.72);color:var(--yellow);
  border:1px solid var(--border-y);-webkit-backdrop-filter:blur(4px);backdrop-filter:blur(4px);
  opacity:0;transform:scale(.8);transition:opacity .2s,transform .2s;pointer-events:none}
.zoom-hint svg{width:16px;height:16px}
.zoomable:hover .zoom-hint,.zoomable:focus-visible .zoom-hint{opacity:1;transform:scale(1)}
@media (hover:none){.zoom-hint{opacity:.9;transform:none}}

.lb{position:fixed;inset:0;z-index:3000;display:none;align-items:center;justify-content:center;padding:4.5rem 1rem 5rem}
.lb.open{display:flex}
.lb-bg{position:absolute;inset:0;background:rgba(5,5,5,.93);-webkit-backdrop-filter:blur(8px);backdrop-filter:blur(8px);opacity:0;transition:opacity .3s ease}
.lb.show .lb-bg{opacity:1}
.lb-fig{position:relative;margin:0;max-width:min(1100px,94vw);max-height:100%;display:flex;flex-direction:column;align-items:center}
.lb-img{display:block;max-width:100%;max-height:calc(100vh - 12rem);object-fit:contain;background:#000;
  border:1px solid var(--border-y);border-radius:4px;will-change:transform;
  box-shadow:0 0 0 6px rgba(245,197,24,.06),0 30px 80px rgba(0,0,0,.65),0 0 70px rgba(245,197,24,.14)}
.lb-cap{margin-top:1rem;display:flex;gap:1rem;align-items:baseline;justify-content:center;flex-wrap:wrap;
  font-size:.9rem;color:#ddd;text-align:center;opacity:0;transition:opacity .3s ease .15s}
.lb.show .lb-cap{opacity:1}
.lb-count{font-family:'Bebas Neue',sans-serif;font-size:1.15rem;letter-spacing:2px;color:var(--yellow)}

.lb-btn{position:fixed;z-index:2;width:46px;height:46px;border-radius:50%;display:flex;align-items:center;justify-content:center;
  background:rgba(23,23,23,.85);color:#fff;border:1px solid var(--border-y);cursor:pointer;
  opacity:0;transition:opacity .3s ease,background .2s,color .2s,border-color .2s,transform .15s}
.lb.show .lb-btn{opacity:1}
.lb-btn:hover{background:var(--yellow);color:#0A0A0A;border-color:var(--yellow);transform:scale(1.08)}
.lb-btn svg{width:20px;height:20px}
.lb-close{top:1rem;right:1rem}
.lb-prev{left:1rem;top:50%;margin-top:-23px}
.lb-next{right:1rem;top:50%;margin-top:-23px}
@media (max-width:700px){
  .lb{padding:4rem .75rem 6rem}
  .lb-prev,.lb-next{top:auto;bottom:1.25rem;margin-top:0}
  .lb-prev{left:calc(50% - 58px)}
  .lb-next{right:calc(50% - 58px)}
}
@media (prefers-reduced-motion:reduce){
  .lb-bg,.lb-cap,.lb-btn,.zoom-hint{transition:none}
}

/* Booking */
.booking-wrap{display:grid;grid-template-columns:1fr 1.3fr;gap:4rem;margin-top:3rem;align-items:start}
.booking-info h3{font-family:'Bebas Neue',sans-serif;font-size:1.6rem;letter-spacing:2px;color:var(--yellow);margin-bottom:1rem}
[data-theme="light"] .booking-info h3{color:var(--yellow-deep)}
.booking-info p{color:var(--gray);font-weight:300;margin-bottom:1.5rem}
.contact-list{list-style:none}
.contact-list li{display:flex;justify-content:space-between;gap:1rem;padding:.6rem 0;border-bottom:1px solid var(--border);font-size:.9rem;color:var(--text2)}
.contact-list a{color:var(--yellow);text-decoration:none}
[data-theme="light"] .contact-list a{color:var(--yellow-deep)}
.booking-form{background:var(--surface);border:1px solid var(--border-y);border-radius:4px;padding:2rem;box-shadow:var(--shadow)}
.form-group{display:flex;flex-direction:column;gap:.4rem;margin-bottom:1rem}
.form-group label{font-size:.75rem;letter-spacing:2px;text-transform:uppercase;color:var(--gray)}
.form-group input,.form-group select,.form-group textarea{background:var(--input-bg);border:1px solid var(--border-y);border-radius:3px;padding:.7rem 1rem;color:var(--text);font-family:inherit;font-size:.95rem;width:100%}
.form-group textarea{resize:vertical;min-height:80px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.form-actions{display:flex;gap:1rem;flex-wrap:wrap}
.form-actions button{flex:1}
.msg{background:var(--confirm-bg);border:1px solid var(--confirm-border);color:var(--confirm-color);border-radius:3px;padding:.8rem 1rem;font-size:.9rem;text-align:center;margin-top:1rem;display:none}
.msg.show{display:block}

footer{background:var(--footer-bg);border-top:1px solid var(--border);padding:2.5rem 2rem}
.footer-inner{max-width:1100px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem}
.footer-copy{color:var(--gray);font-size:.85rem}
.footer-inner a{color:var(--gray-light);font-size:.85rem;text-decoration:none;margin-left:1rem}
.footer-inner a:hover{color:var(--yellow)}

@media (max-width:1024px){nav{padding:1rem 2rem}.booking-wrap{gap:2.5rem}}
@media (max-width:768px){
  nav{padding:.85rem 1.25rem}.nav-links{display:none}.nav-hamburger{display:flex}
  section{padding:4.5rem 1.25rem}
  .grid{grid-template-columns:1fr 1fr}
  .gallery-grid{grid-template-columns:1fr 1fr;grid-auto-rows:200px}
  .gallery-cell:nth-child(1),.gallery-cell:nth-child(4){grid-row:auto}
  .booking-wrap{grid-template-columns:1fr;gap:2rem}.booking-form{padding:1.5rem}
  .form-row{grid-template-columns:1fr}
  .footer-inner{flex-direction:column;align-items:flex-start}.footer-inner a{margin:0 1rem 0 0}
}
@media (max-width:480px){
  nav{padding:.75rem 1rem}section{padding:4rem 1rem}
  .site-logo{height:30px;transform:scale(1.5)}
  .grid,.gallery-grid{grid-template-columns:1fr}
  .btn-primary,.btn-secondary{width:100%;text-align:center;padding:.8rem 1.5rem}
  .booking-form{padding:1.25rem 1rem}
}
.wa-float{position:fixed;right:1.25rem;bottom:1.25rem;z-index:900;display:flex;align-items:center;gap:.6rem;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:.9rem;padding:.8rem 1.1rem;border-radius:40px;box-shadow:0 4px 18px rgba(0,0,0,.3);transition:transform .15s}
.wa-float:hover{transform:translateY(-2px)}
.wa-float svg{width:22px;height:22px;fill:#fff}
@media (max-width:480px){.wa-float span{display:none}.wa-float{padding:.9rem}}
</style>
</head>
<body>

<!-- Floating WhatsApp button (now inside <body>) -->
<a class="wa-float" href="https://wa.me/{{ $whatsapp }}?text={{ urlencode('Hi Sauti Gang, I would like to Inquire about event sound.') }}" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
  <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16 3C9 3 3.4 8.6 3.4 15.5c0 2.3.6 4.4 1.7 6.3L3 29l7.4-2c1.8 1 3.800 1.500 5.800 1.500 7 0 12.600-5.600 12.600-12.500S23 3 16 3zm0 22.800c-1.800 0-3.600-.5-5.100-1.400l-.4-.2-4.400 1.200 1.200-4.300-.3-.4a10.200 10.200 0 0 1-1.600-5.500C5.400 9.800 10.200 5.200 16 5.200s10.600 4.600 10.600 10.300S21.800 25.800 16 25.800zm5.800-7.600c-.3-.2-1.900-.9-2.200-1-.3-.1-.5-.2-.7.200-.2.300-.8 1-1 1.200-.2.200-.4.200-.7.100-.3-.2-1.400-.5-2.600-1.600-1-.9-1.600-1.900-1.800-2.200-.2-.3 0-.5.100-.6l.5-.6c.1-.2.200-.3.300-.5.100-.2.100-.4 0-.6-.1-.2-.7-1.700-1-2.300-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.100-.9.400-.3.300-1.200 1.200-1.200 2.900s1.200 3.400 1.400 3.600c.2.200 2.400 3.800 5.900 5.200 3.500 1.400 3.500.9 4.100.9.600-.1 1.900-.8 2.200-1.600.3-.8.300-1.400.2-1.600-.1-.1-.3-.2-.6-.4z"/></svg>
  <span>Chat with us</span>
</a>

<nav>
  <a href="/" class="logo-wrap" aria-label="Sauti Gang home">
    <img class="site-logo" src="{{ asset($logo_path) }}" alt="" onerror="this.style.display='none'">
    <span class="logo-text"><span>Sauti Gang</span><span>SG Events</span></span>
  </a>
  <ul class="nav-links">
    <li><a href="#occasions">Occasions</a></li>
    <li><a href="#gear">What we bring</a></li>
    <li><a href="#gallery">Gallery</a></li>
    <li><a href="/learn">Learn</a></li>
    <li><a href="/">Rehearsal studio</a></li>
    <li><button class="theme-toggle-btn" type="button" data-theme-toggle aria-label="Toggle light and dark theme"><span class="tt-icon"></span><span class="tt-track"><span class="tt-thumb"></span></span></button></li>
    <li><a href="#book" class="nav-cta">Book sound</a></li>
  </ul>
  <button class="nav-hamburger" id="burger" type="button" aria-label="Menu" aria-expanded="false"><span></span><span></span><span></span></button>
</nav>

<ul class="mobile-menu" id="mobileMenu">
  <li><a href="#occasions">Occasions</a></li>
  <li><a href="#gear">What we bring</a></li>
  <li><a href="#gallery">Gallery</a></li>
  <li><a href="/learn">Learn</a></li>
  <li><a href="/">Rehearsal studio</a></li>
  <li class="m-theme"><span style="font-size:.8rem;letter-spacing:2px;text-transform:uppercase;color:var(--gray)">Theme</span>
    <button class="theme-toggle-btn" type="button" data-theme-toggle aria-label="Toggle theme"><span class="tt-icon"></span><span class="tt-track"><span class="tt-thumb"></span></span></button></li>
  <li class="m-cta"><a href="#book">Book sound</a></li>
</ul>

<header class="hero">
  @if(file_exists(public_path($heroImage)))
    <div class="hero-bg" style="background-image:url('{{ asset($heroImage) }}')"></div>
  @endif
  <div class="container">
    <div class="section-label">SG Events by Sauti Gang Studios</div>
    <h1>The Ultimate Sound Enginneering <br> <em>Comapnay</em></h1>
    <p>Speakers, microphones, mixer, DJ decks, a DJ and a sound engineer, brought to your venue and set up properly. Weddings, graduations, birthdays, meetings and fellowships.</p>
    <div class="hero-actions">
      <a href="#book" class="btn-primary">Book your event</a>
      <a href="tel:{{ $phone }}" class="btn-secondary">Call {{ $phone }}</a>
    </div>
    <div class="eq" aria-hidden="true">@for($i=0;$i<24;$i++)<i></i>@endfor</div>
  </div>
</header>

<section id="occasions">
  <div class="container">
    <div class="section-label">Who we play for</div>
    <h2 class="section-title">Events we cover</h2>
    <p class="section-sub">Whatever the crowd size, we match the sound to your venue and your program.</p>
    <div class="grid">
      @foreach($occasions as [$i,$t,$d])
        <div class="card"><span class="ico">{{ $i }}</span><h3>{{ $t }}</h3><p>{{ $d }}</p></div>
      @endforeach
    </div>
  </div>
</section>

<section id="gear">
  <div class="container">
    <div class="section-label">What we bring</div>
    <h2 class="section-title">Full sound, one team</h2>
    <p class="section-sub">Hire the whole setup or just the pieces you need. Tell us what you have and we fill the gaps.</p>
    <div class="grid">
      @foreach($gear as [$i,$t,$d])
        <div class="card"><span class="ico">{{ $i }}</span><h3>{{ $t }}</h3><p>{{ $d }}</p></div>
      @endforeach
    </div>
  </div>
</section>

<section id="gallery">
  <div class="container">
    <div class="section-label">Gallery</div>
    <h2 class="section-title">From our events</h2>
    <p class="section-sub">A look at the sound, the crowd and the crew at work.</p>
    <div class="gallery-grid">
      @foreach($gallery as $file => $caption)
        @php $path = 'events/'.$file; @endphp
        @if(file_exists(public_path($path)))
          <div class="gallery-cell"><img src="{{ asset($path) }}" alt="{{ $caption }}" loading="lazy"><div class="caption">{{ $caption }}</div></div>
        @else
          <div class="gallery-cell empty" title="Add public/{{ $path }}">🎶<div class="caption">{{ $caption }}</div></div>
        @endif
      @endforeach
    </div>
  </div>
</section>

<section id="book">
  <div class="container">
    <div class="section-label">Book or call</div>
    <h2 class="section-title">Plan your sound</h2>
    <div class="booking-wrap">
      <div class="booking-info">
        <h3>Talk to us</h3>
        <p>Send the details of your event and we will reply with availability and a quote. Prefer to talk? Call or message us directly.</p>
        <ul class="contact-list">
          <li>Call <a href="tel:{{ $phone }}">{{ $phone }}</a></li>
          <li>Email <a href="mailto:{{ $email }}">{{ $email }}</a></li>
        </ul>
      </div>
      <form class="booking-form" id="eventForm" novalidate>
        <div class="form-row">
          <div class="form-group"><label for="name">Your name</label><input id="name" required autocomplete="name"></div>
          <div class="form-group"><label for="tel">Phone</label><input id="tel" type="tel" required autocomplete="tel"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label for="type">Event type</label>
            <select id="type">
              <option>Wedding reception</option><option>Pre-wedding</option><option>Graduation party</option>
              <option>Birthday party</option><option>Club meeting</option><option>Fellowship</option><option>Other</option>
            </select></div>
          <div class="form-group"><label for="date">Event date</label><input id="date" type="date"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label for="venue">Venue / location</label><input id="venue"></div>
          <div class="form-group"><label for="guests">Expected guests</label><input id="guests" type="number" min="1"></div>
        </div>
        <div class="form-group"><label>What do you need?</label>
          <div style="display:flex;flex-wrap:wrap;gap:.5rem 1.25rem;font-size:.9rem;color:var(--text2)">
            @foreach(['Speakers','Microphones','Mixer','DJ','DJ decks','Sound engineer'] as $n)
              <label style="display:flex;gap:.4rem;align-items:center;letter-spacing:0;text-transform:none;font-size:.9rem;color:var(--text2)"><input type="checkbox" name="need" value="{{ $n }}" style="width:auto"> {{ $n }}</label>
            @endforeach
          </div></div>
        <div class="form-group"><label for="notes">Anything else?</label><textarea id="notes"></textarea></div>
        <div class="form-actions">
          <button type="submit" class="btn-primary">Send on WhatsApp</button>
          <a class="btn-secondary" href="tel:{{ $phone }}" style="text-align:center">Call instead</a>
        </div>
        <div class="msg" id="formMsg" role="status"></div>
      </form>
    </div>
  </div>
</section>

<footer>
  <div class="footer-inner">
    <div class="footer-copy">&copy; {{ date('Y') }} Sauti Gang Studios. Event sound hire.</div>
    <div><a href="/">Rehearsal studio</a><a href="#book">Book sound</a></div>
  </div>
</footer>

<script>
// Theme
document.querySelectorAll('[data-theme-toggle]').forEach(function(b){
  b.addEventListener('click',function(){
    var next = document.documentElement.getAttribute('data-theme')==='light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme',next);
    try{localStorage.setItem('sg-theme',next)}catch(e){}
  });
});
// Mobile menu
var burger=document.getElementById('burger'), menu=document.getElementById('mobileMenu');
function setMenu(o){menu.classList.toggle('open',o);burger.classList.toggle('open',o);burger.setAttribute('aria-expanded',o);document.body.style.overflow=o?'hidden':''}
burger.addEventListener('click',function(){setMenu(!menu.classList.contains('open'))});
menu.querySelectorAll('a').forEach(function(a){a.addEventListener('click',function(){setMenu(false)})});
// Booking form -> WhatsApp
var WA=@json($whatsapp);
document.getElementById('eventForm').addEventListener('submit',function(e){
  e.preventDefault();
  var v=function(id){return document.getElementById(id).value.trim()};
  var msg=document.getElementById('formMsg');
  if(!v('name')||!v('tel')){msg.textContent='Please add your name and phone number.';msg.classList.add('show');return}
  var needs=[].map.call(document.querySelectorAll('input[name=need]:checked'),function(c){return c.value}).join(', ')||'Not specified';
  var text=['SG Events booking request','Name: '+v('name'),'Phone: '+v('tel'),'Event: '+v('type'),
    'Date: '+(v('date')||'TBC'),'Venue: '+(v('venue')||'TBC'),'Guests: '+(v('guests')||'TBC'),
    'Needs: '+needs,'Notes: '+(v('notes')||'-')].join('\n');
  var url='https://wa.me/'+WA+'?text='+encodeURIComponent(text);
  var w=window.open(url,'_blank');
  if(w){ try{w.opener=null}catch(err){} }
  else { window.location.href=url; }   // popup blocked: open in the same tab instead
  msg.textContent='Opening WhatsApp with your details. Send the message to complete your request.';
  msg.classList.add('show');
});
</script>

<!-- IMAGE LIGHTBOX (click any gallery photo to expand) -->
<script>
(function () {
  var SEL = '.gallery-cell';
  var dur = window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 380;
  var ICON = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>';
  var CHEV_L = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>';
  var CHEV_R = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>';
  var X_ICON = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>';

  // Only real photos become clickable (placeholders have no <img>)
  var hosts = [].slice.call(document.querySelectorAll(SEL)).filter(function (h) { return h.querySelector('img'); });
  if (!hosts.length) return;

  // Build the viewer
  var lb = document.createElement('div');
  lb.className = 'lb';
  lb.setAttribute('role', 'dialog');
  lb.setAttribute('aria-modal', 'true');
  lb.setAttribute('aria-label', 'Photo viewer');
  lb.innerHTML =
    '<div class="lb-bg"></div>' +
    '<button type="button" class="lb-btn lb-close" aria-label="Close photo">' + X_ICON + '</button>' +
    '<button type="button" class="lb-btn lb-prev" aria-label="Previous photo">' + CHEV_L + '</button>' +
    '<button type="button" class="lb-btn lb-next" aria-label="Next photo">' + CHEV_R + '</button>' +
    '<figure class="lb-fig"><img class="lb-img" alt="">' +
    '<figcaption class="lb-cap"><span class="lb-count"></span><span class="lb-text"></span></figcaption></figure>';
  document.body.appendChild(lb);

  var big = lb.querySelector('.lb-img'), capText = lb.querySelector('.lb-text'), count = lb.querySelector('.lb-count');
  var btnClose = lb.querySelector('.lb-close'), btnPrev = lb.querySelector('.lb-prev'), btnNext = lb.querySelector('.lb-next');
  var list = [], idx = 0, isOpen = false, closing = false;

  // Make photos clickable
  hosts.forEach(function (h) {
    var im = h.querySelector('img');
    h.classList.add('zoomable');
    h.setAttribute('tabindex', '0');
    h.setAttribute('role', 'button');
    h.setAttribute('aria-label', 'Enlarge photo: ' + (im.alt || ''));
    h.insertAdjacentHTML('beforeend', '<span class="zoom-hint" aria-hidden="true">' + ICON + '</span>');
    h.addEventListener('click', function () { open(h); });
    h.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); open(h); }
    });
  });

  function visibleHosts() {
    return hosts.filter(function (h) { return !h.closest('[hidden]') && h.offsetParent !== null; });
  }
  function pad(n) { return (n < 10 ? '0' : '') + n; }
  function srcOf(h) { var im = h.querySelector('img'); return im.currentSrc || im.src; }

  function open(h) {
    list = visibleHosts();
    idx = Math.max(0, list.indexOf(h));
    isOpen = true; closing = false;
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
    show(true);
    requestAnimationFrame(function () { lb.classList.add('show'); });
    btnClose.focus({ preventScroll: true });
  }

  function whenLoaded(fn) {
    big.onload = function () { big.onload = null; fn(); };
    big.src = srcOf(list[idx]);
    if (big.complete && big.naturalWidth && big.onload) big.onload();
  }

  function show(first) {
    var h = list[idx], im = h.querySelector('img');
    capText.textContent = im.alt || '';
    count.textContent = pad(idx + 1) + ' / ' + pad(list.length);
    btnPrev.style.display = btnNext.style.display = list.length < 2 ? 'none' : '';
    big.alt = im.alt || '';
    big.style.transition = 'none';
    big.style.transform = 'none';
    big.style.opacity = first ? '1' : '0';

    whenLoaded(function () {
      if (first) { flipIn(h); }
      else {
        big.offsetWidth;
        big.style.transition = 'opacity .25s ease';
        big.style.opacity = '1';
      }
    });
  }

  // Fly out from the clicked thumbnail
  function flipIn(h) {
    var s = h.querySelector('img').getBoundingClientRect();
    var f = big.getBoundingClientRect();
    if (!dur || !s.width || !f.width) return;
    var sc = s.width / f.width;
    var dx = (s.left + s.width / 2) - (f.left + f.width / 2);
    var dy = (s.top + s.height / 2) - (f.top + f.height / 2);
    big.style.transform = 'translate(' + dx + 'px,' + dy + 'px) scale(' + sc + ')';
    big.offsetWidth;
    big.style.transition = 'transform ' + dur + 'ms cubic-bezier(.2,.8,.2,1)';
    big.style.transform = 'none';
  }

  function go(d) {
    if (list.length < 2) return;
    idx = (idx + d + list.length) % list.length;
    show(false);
  }

  function close() {
    if (!isOpen || closing) return;
    closing = true;
    var h = list[idx];
    var s = h.querySelector('img').getBoundingClientRect();
    var inView = s.width && s.bottom > 0 && s.top < innerHeight && s.right > 0 && s.left < innerWidth;
    lb.classList.remove('show');

    if (dur && inView) {
      var f = big.getBoundingClientRect();
      var sc = s.width / f.width;
      var dx = (s.left + s.width / 2) - (f.left + f.width / 2);
      var dy = (s.top + s.height / 2) - (f.top + f.height / 2);
      big.style.transition = 'transform ' + dur + 'ms cubic-bezier(.4,0,.2,1)';
      big.style.transform = 'translate(' + dx + 'px,' + dy + 'px) scale(' + sc + ')';
    } else {
      big.style.transition = 'opacity ' + (dur || 0) + 'ms ease';
      big.style.opacity = '0';
    }
    setTimeout(function () {
      lb.classList.remove('open');
      document.body.style.overflow = '';
      big.removeAttribute('src');
      isOpen = false; closing = false;
      h.focus({ preventScroll: true });
    }, dur);
  }

  btnClose.addEventListener('click', close);
  btnPrev.addEventListener('click', function () { go(-1); });
  btnNext.addEventListener('click', function () { go(1); });
  lb.addEventListener('click', function (e) {
    if (e.target === lb || e.target.classList.contains('lb-bg')) close();
  });

  document.addEventListener('keydown', function (e) {
    if (!isOpen) return;
    if (e.key === 'Escape') { close(); }
    else if (e.key === 'ArrowLeft') { go(-1); }
    else if (e.key === 'ArrowRight') { go(1); }
    else if (e.key === 'Tab') {            // keep focus inside the viewer
      var f = [btnClose, btnPrev, btnNext].filter(function (b) { return b.style.display !== 'none'; });
      var i = f.indexOf(document.activeElement);
      e.preventDefault();
      f[(i + (e.shiftKey ? -1 : 1) + f.length) % f.length].focus();
    }
  });

  // Swipe: left/right to browse, down to close
  var tx = 0, ty = 0;
  lb.addEventListener('touchstart', function (e) { tx = e.touches[0].clientX; ty = e.touches[0].clientY; }, { passive: true });
  lb.addEventListener('touchend', function (e) {
    var dx = e.changedTouches[0].clientX - tx, dy = e.changedTouches[0].clientY - ty;
    if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy)) go(dx < 0 ? 1 : -1);
    else if (dy > 90 && Math.abs(dy) > Math.abs(dx)) close();
  }, { passive: true });
})();
</script>
</body>
</html>