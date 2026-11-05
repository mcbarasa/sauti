@php
    // ---- EDIT THESE ----
    $phone      = '+254112935073';   // shown on Call button
    $whatsapp   = '254112935073';    // digits only, no +
    $email      = 'hey@sautigang.com';
@endphp
<?php
/**
 * learn.php — Sauti Gang Studios | Music Lessons
 * Karen Village, Nairobi
 *
 * FULLY SELF-CONTAINED: all CSS (your theme + page styles) and JS are inside this file.
 * Images live in public/learn/ (filenames + prompts are in $images below).
 */
session_start();

/* ───────── CONFIG ───────── */
$studio_name  = 'Sauti Gang Studios';
$studio_email = 'hey@sautigang.com';      // TODO: your real email
$studio_phone = '+254112935073';         // TODO: your real number
$studio_loc   = 'Karen Village, Nairobi';
$logo_path    = 'img/sauti_logo.webp';          // optional; hidden automatically if missing

// WhatsApp number used by the booking notice (falls back if the Blade variable is missing)
$wa_number = isset($whatsapp) ? preg_replace('/\D+/', '', (string)$whatsapp) : '254112935073';

/* ───────── AI IMAGES ─────────
   Generate each image with its prompt, save in public/learn/ with the filename.
   Missing files fall back to a styled placeholder. */
$img_dir = 'lessons/';   // FIX: relative to Laravel's public/ folder (public/lessons/)
$images = [
  'hero'    => ['file'=>'enroll.png','alt'=>'A teacher guiding a student on guitar in a warm studio',
                'prompt'=>'Cinematic photo, music teacher guiding a teenage student on electric guitar in a dark rehearsal studio, warm golden stage light, acoustic foam panels, shallow depth of field, moody, portrait 4:5'],
  'vocals'  => ['file'=>'vocals.jpg','alt'=>'Singer at a studio microphone',
                'prompt'=>'Young African woman singing into a condenser mic with pop filter, golden rim light, dark studio, cinematic, 4:3'],
  'drums'   => ['file'=>'drums.jpg','alt'=>'Drum kit in a rehearsal room',
                'prompt'=>'Close-up of a drum kit in a dark studio, drummer mid-hit, motion blur on sticks, golden cymbal highlights, 4:3'],
  'bass'    => ['file'=>'bass.jpg','alt'=>'Bass guitar close-up',
                'prompt'=>'Close-up of hands playing a bass guitar, warm amber lighting, dark background, shallow depth of field, 4:3'],
  'guitar'  => ['file'=>'guitar.jpg','alt'=>'Lead guitar being played',
                'prompt'=>'Lead guitarist bending a string on an electric guitar, amp glowing in background, golden haze, cinematic, 4:3'],
  'keys'    => ['file'=>'keyboard.jpg','alt'=>'Keyboard keys under studio light',
                'prompt'=>'Hands on a synth keyboard in a dim studio, golden light across the keys, soft bokeh, cinematic, 4:3'],
  'trumpet' => ['file'=>'trumpet.jpg','alt'=>'Trumpet player',
                'prompt'=>'Trumpet player in profile, brass reflecting warm golden light, dark moody background, cinematic, 4:3'],
  'piano'   => ['file'=>'piano.jpg','alt'=>'Piano lesson',
                'prompt'=>'Child and teacher playing a piano together, warm studio light, joyful, documentary photo style, 4:3'],
  'kids'    => ['file'=>'kids.jpg','alt'=>'Children learning music',
                'prompt'=>'Group of Kenyan children with small percussion and keyboards in a bright music room, smiling, warm light, 3:4'],
  'adults'  => ['file'=>'adults.jpg','alt'=>'Adult beginner at a lesson',
                'prompt'=>'Adult beginner learning guitar with an instructor in a cosy studio, relaxed mood, warm golden light, 3:4'],
  'band'    => ['file'=>'band.jpg','alt'=>'Students performing as a band',
                'prompt'=>'Young band performing in a small studio showcase, golden stage lights, energetic, cinematic, 3:4'],
];

// FIX: checks the file inside Laravel's public/ folder and builds the URL with asset()
if (!function_exists('img_html')) {
  function img_html(array $i, string $dir, string $class = ''): string {
    $path = $dir . $i['file'];                       // e.g. learn/hero-lesson.jpg
    $disk = function_exists('public_path') ? public_path($path) : __DIR__ . '/' . $path;
    $url  = function_exists('asset') ? asset($path) : $path;

    if (is_file($disk)) {
      return '<img src="' . htmlspecialchars($url) . '" alt="' . htmlspecialchars($i['alt']) . '" loading="lazy" class="' . $class . '">';
    }
    return '<div class="img-ph ' . $class . '" role="img" aria-label="' . htmlspecialchars($i['alt']) . '"><span>Photo coming soon</span></div>';
  }
}

/* ───────── DATA ───────── */
$instruments = [
  ['key'=>'vocals', 'name'=>'Vocals',      'img'=>'vocals',  'group'=>'voice',          'desc'=>'Breath control, pitch, range and stage confidence. Pop, gospel, RnB, benga and more.', 'levels'=>'Beginner to advanced'],
  ['key'=>'drums',  'name'=>'Drums',       'img'=>'drums',   'group'=>'rhythm',         'desc'=>'Grip, rudiments, groove and fills, then playing along to real tracks.',               'levels'=>'Beginner to advanced'],
  ['key'=>'bass',   'name'=>'Bass guitar', 'img'=>'bass',    'group'=>'strings rhythm', 'desc'=>'Lock in with the drummer: timing, walking lines, slap and finger style.',             'levels'=>'Beginner to advanced'],
  ['key'=>'guitar', 'name'=>'Lead guitar', 'img'=>'guitar',  'group'=>'strings',        'desc'=>'Scales, solos, bends, tone and reading chord charts. Acoustic or electric.',          'levels'=>'Beginner to advanced'],
  ['key'=>'keys',   'name'=>'Keyboard',    'img'=>'keys',    'group'=>'keys',           'desc'=>'Chords, sound basics and accompaniment for church, studio and stage.',                'levels'=>'Beginner to advanced'],
  ['key'=>'trumpet','name'=>'Trumpet',     'img'=>'trumpet', 'group'=>'brass',          'desc'=>'Embouchure, tone, scales and brass section playing.',                                 'levels'=>'Beginner to intermediate'],
  ['key'=>'piano',  'name'=>'Piano',       'img'=>'piano',   'group'=>'keys',           'desc'=>'Classical foundations and contemporary styles, with or without reading notation.',    'levels'=>'Beginner to advanced'],
];
$others = ['Saxophone','Violin','Ukulele','Songwriting','Music theory','Music production'];

$audiences = [
  ['img'=>'kids',   'title'=>'Kids (5 to 12)',   'text'=>'Short, playful sessions that build rhythm, listening and confidence.'],
  ['img'=>'adults', 'title'=>'Teens and adults', 'text'=>'Start from zero or sharpen what you already play, at your own pace.'],
  ['img'=>'band',   'title'=>'Bands and groups', 'text'=>'Book lessons together and use our rehearsal room to put it all into practice.'],
];

$steps = [
  ['Tell us what you want to play', 'Send an enquiry with your instrument, age and experience.'],
  ['We match you with a teacher',   'We confirm a trial lesson time that works for you.'],
  ['Learn at the studio',           'Lessons happen in our Karen Village space, one-on-one or in small groups.'],
  ['Play it for real',              'Rehearse in our room and perform at student showcases.'],
];

/* ───────── FORM HANDLING ─────────
   Online booking is temporarily disabled (work in progress).
   Any POST (e.g. JavaScript turned off) is NOT emailed or stored; the visitor
   sees the "work in progress" notice and is pointed to WhatsApp instead.
   When the feature is ready, restore the validation + mail() block. */
if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
$errors = []; $sent = false; $wip = false;
$old = ['name'=>'','email'=>'','phone'=>'','instrument'=>'','age_group'=>'','level'=>'','message'=>''];

$valid_instruments = array_merge(array_column($instruments, 'name'), $others, ['Not sure yet']);
$valid_ages   = ['Child (5 to 12)','Teen (13 to 17)','Adult (18+)','Group / band'];
$valid_levels = ['Complete beginner','Some experience','Intermediate','Advanced'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($old as $k => $_) $old[$k] = trim((string)($_POST[$k] ?? ''));   // keep what they typed
  $wip = true;
}
$e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');

$wa_default_text = 'Hi Sauti Gang, I would like to book a trial lesson.';
$wa_link = 'https://wa.me/' . $wa_number . '?text=' . rawurlencode($wa_default_text);
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/webp" href="{{ asset('img/sauti_logo.WebP') }}">
<title>@yield('title', 'Music Lessons in Karen | ' . $e($studio_name))</title>
<meta name="description" content="Music lessons for all ages in Karen Village, Nairobi: vocals, drums, bass, lead guitar, keyboard, piano, trumpet and more.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
<script>
  // Apply saved theme before first paint (no flash)
  try { var t = localStorage.getItem('sg-theme'); if (t) document.documentElement.setAttribute('data-theme', t); } catch(e){}
</script>

<style>
/* ═══════════════════════════════════════════
   1. SAUTI GANG THEME (your base stylesheet)
═══════════════════════════════════════════ */
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
.booking-confirm-msg { background:var(--confirm-bg); border:1px solid var(--confirm-border); color:var(--confirm-color); border-radius:3px; padding:1rem; font-size:0.9rem; text-align:center; margin-top:1rem; }

/* FOOTER */
footer { background:var(--footer-bg); border-top:1px solid var(--border); padding:2.5rem 2rem; }
.footer-inner { max-width:1100px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; }
.footer-copy { color:var(--gray); font-size:0.85rem; }

/* REVEAL */
.reveal { opacity:0; transform:translateY(24px); transition:opacity 0.7s ease,transform 0.7s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }

/* Logo theme switching */
.site-logo { height:38px; width:auto; display:block; filter:invert(1) hue-rotate(180deg) saturate(3) brightness(1.1); transition:filter 0.35s ease; transform:scale(1.8); }
[data-theme="dark"] .site-logo { filter:none; }

/* ═══════════════════════════════════════════
   2. LEARN PAGE STYLES
═══════════════════════════════════════════ */

/* Placeholder for missing AI images */
.img-ph { display:flex; align-items:center; justify-content:center; width:100%; height:100%; min-height:160px;
  background:repeating-linear-gradient(135deg,var(--surface2) 0 14px,var(--surface3) 14px 28px);
  color:var(--gray); font-size:.78rem; letter-spacing:2px; text-transform:uppercase; }

/* HERO */
.learn-hero { position:relative; min-height:100vh; display:flex; align-items:center; padding:8rem 2rem 5rem; overflow:hidden;
  background:
    radial-gradient(ellipse 55% 55% at 78% 38%, var(--hero-glow), transparent 70%),
    linear-gradient(var(--grid-line) 1px, transparent 1px) 0 0/48px 48px,
    linear-gradient(90deg, var(--grid-line) 1px, transparent 1px) 0 0/48px 48px,
    var(--bg); }
.learn-hero .container { display:grid; grid-template-columns:1.15fr 1fr; gap:4rem; align-items:center; width:100%; }
.learn-hero h1 { font-family:'Bebas Neue',sans-serif; font-size:clamp(3.4rem,9vw,7.2rem); line-height:.9; letter-spacing:2px; color:var(--text); margin-bottom:1.5rem; }
.learn-hero h1 span { display:block; color:transparent; -webkit-text-stroke:2px var(--yellow); }
[data-theme="light"] .learn-hero h1 span { -webkit-text-stroke-color:var(--yellow-deep); }
.learn-hero p.lead { color:var(--gray-light); font-size:1.12rem; font-weight:300; max-width:500px; margin-bottom:2.2rem; }
.hero-actions { display:flex; gap:1rem; flex-wrap:wrap; }
.hero-note { margin-top:2rem; display:flex; gap:1.75rem; flex-wrap:wrap; color:var(--gray); font-size:.85rem; }
.hero-note b { display:block; font-family:'Bebas Neue',sans-serif; font-size:1.6rem; letter-spacing:2px; color:var(--yellow); font-weight:400; line-height:1.1; }
[data-theme="light"] .hero-note b { color:var(--yellow-deep); }

.hero-img { position:relative; aspect-ratio:4/5; border:1px solid var(--border-y); border-radius:4px; overflow:hidden; box-shadow:var(--shadow); }
.hero-img::before { content:''; position:absolute; inset:14px -14px -14px 14px; border:1px solid var(--border-y); border-radius:4px; z-index:-1; }
.hero-img img { width:100%; height:100%; object-fit:cover; display:block; }
.hero-img::after { content:''; position:absolute; inset:0; background:linear-gradient(transparent 55%, rgba(0,0,0,.55)); pointer-events:none; }
.hero-badge { position:absolute; left:1rem; bottom:1rem; z-index:2; background:var(--yellow); color:#0A0A0A; padding:.45rem .9rem; border-radius:3px; font-size:.72rem; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; }
[data-theme="light"] .hero-badge { background:var(--yellow-dark); color:#fff; }

/* Equaliser: the page's one signature motion */
.eq { display:flex; align-items:flex-end; gap:4px; height:34px; margin-bottom:1.25rem; }
.eq i { display:block; width:5px; height:100%; background:var(--yellow); border-radius:1px; transform-origin:bottom; animation:eq 1.1s ease-in-out infinite; }
.eq i:nth-child(1){animation-delay:-.9s} .eq i:nth-child(2){animation-delay:-.6s} .eq i:nth-child(3){animation-delay:-.3s}
.eq i:nth-child(4){animation-delay:-.75s} .eq i:nth-child(5){animation-delay:-.45s} .eq i:nth-child(6){animation-delay:-.15s}
@keyframes eq { 0%,100%{transform:scaleY(.25)} 50%{transform:scaleY(1)} }

/* INSTRUMENT TICKER */
.ticker { background:var(--yellow); color:#0A0A0A; overflow:hidden; white-space:nowrap; padding:.85rem 0; border-top:1px solid var(--yellow-dark); border-bottom:1px solid var(--yellow-dark); }
[data-theme="light"] .ticker { background:var(--yellow-dark); color:#fff; }
.ticker-track { display:inline-flex; animation:tick 38s linear infinite; }
.ticker span { font-family:'Bebas Neue',sans-serif; font-size:1.4rem; letter-spacing:3px; padding:0 1.6rem; }
.ticker span::after { content:'/'; margin-left:3.2rem; opacity:.45; }
@keyframes tick { to { transform:translateX(-50%); } }

/* STUDIO STRIP */
.studio-strip { background:var(--bg-alt); padding:3rem 2rem; border-bottom:1px solid var(--border); }
.studio-strip .container { display:grid; grid-template-columns:repeat(3,1fr); gap:2rem; }
.strip-item { padding-left:1.1rem; border-left:2px solid var(--yellow); }
[data-theme="light"] .strip-item { border-left-color:var(--yellow-dark); }
.strip-item h3 { font-family:'Bebas Neue',sans-serif; font-size:1.4rem; letter-spacing:2px; color:var(--text); margin-bottom:.25rem; }
.strip-item p { color:var(--gray); font-size:.9rem; font-weight:300; }

/* INSTRUMENTS */
#instruments { background:var(--bg); }
.filter-bar { display:flex; gap:.6rem; flex-wrap:wrap; margin:2rem 0 2.5rem; }
.chip { background:var(--surface2); border:1px solid var(--border); color:var(--text2); padding:.5rem 1.1rem; border-radius:30px; font-family:inherit; font-size:.8rem; letter-spacing:1px; cursor:pointer; transition:border-color .2s,color .2s,background .2s !important; }
.chip:hover { border-color:var(--yellow); color:var(--yellow); }
.chip[aria-pressed="true"] { background:var(--yellow); color:#0A0A0A; border-color:var(--yellow); font-weight:700; }
[data-theme="light"] .chip[aria-pressed="true"] { background:var(--yellow-dark); border-color:var(--yellow-dark); color:#fff; }
.inst-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); gap:1.4rem; }
.inst-card { background:var(--surface); border:1px solid var(--border); border-radius:4px; overflow:hidden; display:flex; flex-direction:column; transition:border-color .25s, transform .25s, box-shadow .25s, background .4s !important; }
.inst-card:hover { border-color:var(--border-y); transform:translateY(-4px); box-shadow:var(--shadow); }
.inst-card .thumb { aspect-ratio:4/3; overflow:hidden; background:var(--surface2); }
.inst-card .thumb img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .5s ease; }
.inst-card:hover .thumb img { transform:scale(1.06); }
.inst-card .body { padding:1.25rem 1.3rem 1.5rem; display:flex; flex-direction:column; gap:.5rem; flex:1; }
.inst-card h3 { font-family:'Bebas Neue',sans-serif; font-size:1.8rem; letter-spacing:2px; color:var(--text); line-height:1; }
.inst-card p { color:var(--gray); font-size:.9rem; font-weight:300; flex:1; }
.inst-card .meta { align-self:flex-start; font-size:.68rem; letter-spacing:1.5px; text-transform:uppercase; color:var(--yellow); background:var(--yellow-bg); border:1px solid var(--border-y); padding:2px 10px; border-radius:20px; }
[data-theme="light"] .inst-card .meta { color:var(--yellow-deep); }
.inst-card .pick { margin-top:.6rem; align-self:flex-start; background:none; border:none; color:var(--text); font-family:inherit; font-size:.78rem; letter-spacing:1.5px; text-transform:uppercase; cursor:pointer; border-bottom:1px solid var(--yellow); padding:0 0 2px; transition:color .2s; }
.inst-card .pick:hover { color:var(--yellow); }
.inst-card[hidden] { display:none; }
.more-line { margin-top:2.2rem; padding:1.1rem 1.3rem; border:1px dashed var(--border-y); border-radius:4px; color:var(--gray); font-size:.95rem; }
.more-line strong { color:var(--text); font-weight:500; }

/* WHO IT'S FOR */
#who { background:var(--bg-alt); }
.who-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem; margin-top:3rem; }
.who-card { position:relative; aspect-ratio:3/4; border:1px solid var(--border); border-radius:4px; overflow:hidden; background:var(--surface2); }
.who-card img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .5s ease; }
.who-card:hover img { transform:scale(1.05); }
.who-card .cap { position:absolute; inset:auto 0 0 0; padding:3.5rem 1.4rem 1.4rem; background:linear-gradient(transparent, rgba(0,0,0,.9)); color:#eee; }
.who-card .cap h3 { font-family:'Bebas Neue',sans-serif; font-size:1.8rem; letter-spacing:2px; color:var(--yellow); line-height:1.05; }
.who-card .cap p { font-size:.88rem; font-weight:300; color:#ddd; }

/* HOW IT WORKS (a real sequence, so numbered) */
#how { background:var(--bg); }
.steps { list-style:none; counter-reset:s; display:grid; grid-template-columns:repeat(4,1fr); gap:1.75rem; margin-top:3rem; }
.steps li { counter-increment:s; position:relative; padding-top:3.4rem; border-top:1px solid var(--border-y); }
.steps li::before { content:counter(s); position:absolute; top:.7rem; left:0; font-family:'Bebas Neue',sans-serif; font-size:2.6rem; line-height:1; color:var(--yellow); }
[data-theme="light"] .steps li::before { color:var(--yellow-deep); }
.steps h3 { font-size:1rem; font-weight:700; color:var(--text); margin-bottom:.35rem; }
.steps p { color:var(--gray); font-size:.9rem; font-weight:300; }

/* SERVICES BAND */
.services-band { background:var(--surface); border-top:1px solid var(--border); border-bottom:1px solid var(--border); padding:4.5rem 2rem; }
.services-band .container { display:grid; grid-template-columns:repeat(3,1fr); gap:2.5rem; }
.svc h3 { font-family:'Bebas Neue',sans-serif; font-size:1.7rem; letter-spacing:2px; color:var(--text); margin-bottom:.4rem; }
.svc p { color:var(--gray); font-size:.92rem; font-weight:300; margin-bottom:.9rem; }
.svc a { color:var(--yellow); text-decoration:none; font-size:.78rem; letter-spacing:1.5px; text-transform:uppercase; border-bottom:1px solid var(--border-y); padding-bottom:2px; }
.svc a:hover { border-bottom-color:var(--yellow); }
[data-theme="light"] .svc a { color:var(--yellow-deep); }

/* ENQUIRY */
.contact-lines { list-style:none; margin-top:1.5rem; }
.contact-lines li { padding:.6rem 0; border-bottom:1px solid var(--hours-border); font-size:.92rem; color:var(--text2); display:flex; justify-content:space-between; gap:1rem; }
.contact-lines li span:first-child { color:var(--gray); font-size:.75rem; letter-spacing:2px; text-transform:uppercase; align-self:center; }
.contact-lines a { color:var(--text); text-decoration:none; }
.contact-lines a:hover { color:var(--yellow); }
.hp { position:absolute; left:-9999px; width:1px; height:1px; overflow:hidden; }
.booking-form .btn-primary { width:100%; margin-top:.5rem; }

/* ═══ BOOKING "WORK IN PROGRESS" NOTICE ═══ */
.wip-notice { background:var(--notice-bg); border:1px solid var(--notice-border); border-radius:4px; padding:1.25rem 1.35rem; margin-bottom:1.5rem; }
.wip-notice[hidden] { display:none; }
.wip-notice h4 { font-family:'Bebas Neue',sans-serif; font-size:1.5rem; letter-spacing:2px; color:var(--yellow); line-height:1.1; margin-bottom:.35rem; }
[data-theme="light"] .wip-notice h4 { color:var(--yellow-deep); }
.wip-notice p { color:var(--text2); font-size:.92rem; font-weight:300; margin-bottom:1rem; }
.wip-wa { display:inline-flex; align-items:center; gap:.6rem; background:#25D366; color:#fff; text-decoration:none; font-weight:700; font-size:.85rem; letter-spacing:1.2px; text-transform:uppercase; padding:.75rem 1.3rem; border-radius:3px; transition:transform .15s, filter .2s; }
.wip-wa:hover { transform:translateY(-2px); filter:brightness(1.05); }
.wip-wa svg { width:20px; height:20px; fill:#fff; flex-shrink:0; }
@media (max-width:480px) { .wip-wa { width:100%; justify-content:center; } }

/* ═══ IMAGE LIGHTBOX ═══ */
.zoomable { cursor:zoom-in; }
.inst-card .thumb { position:relative; }
.zoom-hint { position:absolute; top:.7rem; right:.7rem; z-index:3; width:34px; height:34px; border-radius:50%;
  display:flex; align-items:center; justify-content:center; background:rgba(10,10,10,.72); color:var(--yellow);
  border:1px solid var(--border-y); -webkit-backdrop-filter:blur(4px); backdrop-filter:blur(4px);
  opacity:0; transform:scale(.8); transition:opacity .2s, transform .2s; pointer-events:none; }
.zoom-hint svg { width:16px; height:16px; }
.zoomable:hover .zoom-hint, .zoomable:focus-visible .zoom-hint { opacity:1; transform:scale(1); }
@media (hover:none) { .zoom-hint { opacity:.9; transform:none; } }

.lb { position:fixed; inset:0; z-index:3000; display:none; align-items:center; justify-content:center; padding:4.5rem 1rem 5rem; }
.lb.open { display:flex; }
.lb-bg { position:absolute; inset:0; background:rgba(5,5,5,.93); -webkit-backdrop-filter:blur(8px); backdrop-filter:blur(8px); opacity:0; transition:opacity .3s ease; }
.lb.show .lb-bg { opacity:1; }
.lb-fig { position:relative; margin:0; max-width:min(1100px,94vw); max-height:100%; display:flex; flex-direction:column; align-items:center; }
.lb-img { display:block; max-width:100%; max-height:calc(100vh - 12rem); object-fit:contain; background:#000;
  border:1px solid var(--border-y); border-radius:4px; will-change:transform;
  box-shadow:0 0 0 6px rgba(245,197,24,.06), 0 30px 80px rgba(0,0,0,.65), 0 0 70px rgba(245,197,24,.14); }
.lb-cap { margin-top:1rem; display:flex; gap:1rem; align-items:baseline; justify-content:center; flex-wrap:wrap;
  font-size:.9rem; color:#ddd; text-align:center; opacity:0; transition:opacity .3s ease .15s; }
.lb.show .lb-cap { opacity:1; }
.lb-count { font-family:'Bebas Neue',sans-serif; font-size:1.15rem; letter-spacing:2px; color:var(--yellow); }

.lb-btn { position:fixed; z-index:2; width:46px; height:46px; border-radius:50%; display:flex; align-items:center; justify-content:center;
  background:rgba(23,23,23,.85); color:#fff; border:1px solid var(--border-y); cursor:pointer;
  opacity:0; transition:opacity .3s ease, background .2s, color .2s, border-color .2s, transform .15s; }
.lb.show .lb-btn { opacity:1; }
.lb-btn:hover { background:var(--yellow); color:#0A0A0A; border-color:var(--yellow); transform:scale(1.08); }
.lb-btn svg { width:20px; height:20px; }
.lb-close { top:1rem; right:1rem; }
.lb-prev  { left:1rem;  top:50%; margin-top:-23px; }
.lb-next  { right:1rem; top:50%; margin-top:-23px; }
@media (max-width:700px) {
  .lb { padding:4rem .75rem 6rem; }
  .lb-prev, .lb-next { top:auto; bottom:1.25rem; margin-top:0; }
  .lb-prev { left:calc(50% - 58px); }
  .lb-next { right:calc(50% - 58px); }
}
@media (prefers-reduced-motion:reduce) {
  .lb-bg, .lb-cap, .lb-btn, .zoom-hint { transition:none; }
}

/* Keyboard focus */
a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible { outline:2px solid var(--yellow); outline-offset:2px; }

/* ═══════════════════════════════════════════
   3. RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width:1024px) {
  nav { padding:1rem 2rem; }
  .booking-wrap { gap:2.5rem; }
  .steps { grid-template-columns:repeat(2,1fr); }
}
@media (max-width:768px) {
  nav { padding:.85rem 1.25rem; }
  .nav-links { display:none; }
  .nav-hamburger { display:flex; }
  section { padding:4.5rem 1.25rem; }
  .section-title { font-size:clamp(2rem,8vw,3rem); }
  .booking-wrap { grid-template-columns:1fr; gap:2rem; }
  .booking-form { padding:1.5rem; }
  .form-row { grid-template-columns:1fr; }
  .footer-inner { flex-direction:column; align-items:flex-start; gap:.75rem; }

  .learn-hero { padding:6.5rem 1.25rem 3.5rem; min-height:auto; }
  .learn-hero .container { grid-template-columns:1fr; gap:2.5rem; }
  .hero-img { aspect-ratio:16/11; order:-1; }
  .hero-img::before { display:none; }
  .studio-strip { padding:2.5rem 1.25rem; }
  .studio-strip .container, .services-band .container, .who-grid { grid-template-columns:1fr; }
  .services-band { padding:3.5rem 1.25rem; }
  .who-card { aspect-ratio:16/10; }
}
@media (max-width:480px) {
  nav { padding:.75rem 1rem; }
  .site-logo { height:30px; transform:scale(1.5); }
  section { padding:4rem 1rem; }
  .btn-primary, .btn-secondary { padding:.8rem 1.5rem; font-size:.85rem; width:100%; text-align:center; }
  .booking-form { padding:1.25rem 1rem; }
  .steps { grid-template-columns:1fr; }
  .learn-hero h1 span { -webkit-text-stroke-width:1.5px; }
}
@media (max-width:360px) {
  .section-title { font-size:2rem; }
  .section-sub { font-size:.95rem; }
}
@media (prefers-reduced-motion:reduce) {
  html { scroll-behavior:auto; }
  .eq i { animation:none; transform:scaleY(.7); }
  .ticker-track { animation:none; }
  .reveal { transition:none; opacity:1; transform:none; }
}
.wa-float{position:fixed;right:1.25rem;bottom:1.25rem;z-index:900;display:flex;align-items:center;gap:.6rem;background:#25D366;color:#fff;text-decoration:none;font-weight:700;font-size:.9rem;padding:.8rem 1.1rem;border-radius:40px;box-shadow:0 4px 18px rgba(0,0,0,.3);transition:transform .15s}
.wa-float:hover{transform:translateY(-2px)}
.wa-float svg{width:22px;height:22px;fill:#fff}
@media (max-width:480px){.wa-float span{display:none}.wa-float{padding:.9rem}}
</style>
</head>
<a class="wa-float" href="https://wa.me/{{ $whatsapp }}?text={{ urlencode('Hi Sauti Gang, I would like to know more about the lessons available and days so I can plan accordingly.') }}" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
  <svg viewBox="0 0 32 32"><path d="M16 3C9 3 3.4 8.6 3.4 15.5c0 2.3.6 4.4 1.7 6.3L3 29l7.4-2c1.8 1 3.800 1.500 5.800 1.500 7 0 12.600-5.600 12.600-12.500S23 3 16 3zm0 22.800c-1.800 0-3.600-.5-5.100-1.400l-.4-.2-4.400 1.200 1.200-4.300-.3-.4a10.200 10.200 0 0 1-1.600-5.500C5.400 9.800 10.200 5.200 16 5.200s10.600 4.600 10.600 10.300S21.800 25.800 16 25.800zm5.800-7.600c-.3-.2-1.900-.9-2.200-1-.3-.1-.5-.2-.7.200-.2.300-.8 1-1 1.200-.2.200-.4.200-.7.100-.3-.2-1.400-.5-2.600-1.600-1-.9-1.600-1.900-1.800-2.200-.2-.3 0-.5.100-.6l.5-.6c.1-.2.200-.3.300-.5.100-.2.100-.4 0-.6-.1-.2-.7-1.700-1-2.300-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.100-.9.400-.3.300-1.200 1.200-1.200 2.900s1.200 3.400 1.400 3.600c.2.200 2.400 3.800 5.900 5.200 3.500 1.400 3.500.9 4.100.9.600-.1 1.900-.8 2.200-1.600.3-.8.300-1.400.2-1.600-.1-.1-.3-.2-.6-.4z"/></svg>
  <span>Chat with us</span>
</a>
<body>

<!-- NAV -->
<nav>
  <a class="logo-wrap" href="index.php" aria-label="<?= $e($studio_name) ?> home">
    <img class="site-logo" src="<?= $e($logo_path) ?>" alt="" onerror="this.style.display='none'">
    <span class="logo-text"><span>SAUTI GANG</span><span>Studios</span></span>
  </a>
  <ul class="nav-links">
    <li><a href="/">Home</a></li>
    <li><a href="/learn" style="color:var(--yellow)">Learn</a></li>
    <li><a href="/sg-events">SG Events</a></li>
    <li><button type="button" class="theme-toggle-btn" id="themeBtn" aria-label="Toggle light and dark theme"><span class="tt-icon"></span><span class="tt-track"><span class="tt-thumb"></span></span></button></li>
    <li><a href="#booking" class="nav-cta">Book a lesson</a></li>
  </ul>
  <button class="nav-hamburger" id="burger" aria-label="Open menu" aria-expanded="false"><span></span><span></span><span></span></button>
</nav>

<ul class="mobile-menu" id="mobileMenu">
  <li><a href="index.php">Home</a></li>
  <li><a href="learn.php">Learn</a></li>
  <li><a href="index.php#rehearsal">Rehearsal</a></li>
  <li><a href="index.php#sound">Event sound</a></li>
  <li class="theme-row"><label>Theme</label>
    <button type="button" class="theme-toggle-btn" id="themeBtnM" aria-label="Toggle theme"><span class="tt-icon"></span><span class="tt-track"><span class="tt-thumb"></span></span></button></li>
  <li class="mobile-cta"><a href="#booking">Book a lesson</a></li>
</ul>

<main>
<!-- HERO -->
<header class="learn-hero">
  <div class="container">
    <div>
      <div class="eq" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i><i></i></div>
      <p class="section-label">Music lessons in Karen Village</p>
      <h1>Learn to play.<span>Then play loud.</span></h1>
      <p class="lead">One-on-one and group lessons for every age, taught inside a working studio. Pick up an instrument here, then take it next door to our rehearsal room.</p>
      <div class="hero-actions">
        <a href="#booking" class="btn-primary">Book a trial lesson</a>
        <a href="#instruments" class="btn-secondary">Browse instruments</a>
      </div>
      <div class="hero-note">
        <div><b>All ages</b>Kids to adults</div>
        <div><b>7+ instruments</b>Plus theory and production</div>
        <div><b>On-site</b>Rehearse after class</div>
      </div>
    </div>
    <div class="hero-img">
      <?= img_html($images['hero'], $img_dir) ?>
      <span class="hero-badge">Now enrolling</span>
    </div>
  </div>
</header>

<!-- TICKER -->
<div class="ticker" aria-hidden="true">
  <div class="ticker-track">
    <?php
      $tick = array_merge(array_column($instruments, 'name'), ['Songwriting','Music theory','Production']);
      for ($r = 0; $r < 2; $r++) foreach ($tick as $t) echo '<span>' . $e($t) . '</span>';
    ?>
  </div>
</div>

<!-- STUDIO STRIP -->
<div class="studio-strip">
  <div class="container">
    <div class="strip-item"><h3>All ages</h3><p>From five-year-olds on their first drum pad to adults finally picking up the guitar.</p></div>
    <div class="strip-item"><h3>Real studio setting</h3><p>Lessons run in the same space where artists rehearse and record.</p></div>
    <div class="strip-item"><h3>Karen Village</h3><p>Easy to reach, with room to bring your own instrument or use ours.</p></div>
  </div>
</div>

<!-- INSTRUMENTS -->
<section id="instruments">
  <div class="container">
    <p class="section-label">What you can learn</p>
    <h2 class="section-title">Pick your instrument</h2>
    <p class="section-sub">Every lesson is built around songs you actually want to play.</p>

    <div class="filter-bar" role="group" aria-label="Filter instruments">
      <button class="chip" data-filter="all" aria-pressed="true">All</button>
      <button class="chip" data-filter="voice" aria-pressed="false">Voice</button>
      <button class="chip" data-filter="strings" aria-pressed="false">Strings</button>
      <button class="chip" data-filter="keys" aria-pressed="false">Keys</button>
      <button class="chip" data-filter="rhythm" aria-pressed="false">Rhythm</button>
      <button class="chip" data-filter="brass" aria-pressed="false">Brass</button>
    </div>

    <div class="inst-grid" id="instGrid">
      <?php foreach ($instruments as $i): ?>
        <article class="inst-card reveal" data-group="<?= $e($i['group']) ?>">
          <div class="thumb"><?= img_html($images[$i['img']], $img_dir) ?></div>
          <div class="body">
            <span class="meta"><?= $e($i['levels']) ?></span>
            <h3><?= $e($i['name']) ?></h3>
            <p><?= $e($i['desc']) ?></p>
            <button type="button" class="pick" data-instrument="<?= $e($i['name']) ?>">Enquire about <?= $e(strtolower($i['name'])) ?></button>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <p class="more-line"><strong>Also available:</strong> <?= $e(implode(', ', $others)) ?>. Don't see yours? Ask us.</p>
  </div>
</section>

<!-- WHO IT'S FOR -->
<section id="who">
  <div class="container">
    <p class="section-label">Who it's for</p>
    <h2 class="section-title">Lessons for every stage</h2>
    <p class="section-sub">Lesson length, pace and songs are tuned to the learner.</p>
    <div class="who-grid">
      <?php foreach ($audiences as $a): ?>
        <figure class="who-card reveal">
          <?= img_html($images[$a['img']], $img_dir) ?>
          <figcaption class="cap"><h3><?= $e($a['title']) ?></h3><p><?= $e($a['text']) ?></p></figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section id="how">
  <div class="container">
    <p class="section-label">How it works</p>
    <h2 class="section-title">From enquiry to first lesson</h2>
    <ol class="steps">
      <?php foreach ($steps as $s): ?>
        <li class="reveal"><h3><?= $e($s[0]) ?></h3><p><?= $e($s[1]) ?></p></li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<!-- OTHER SERVICES -->
<div class="services-band">
  <div class="container">
    <div class="svc"><h3>Rehearsal space</h3><p>A room for bands, solo musicians and visual artists. Practise what you learned.</p><a href="index.php#rehearsal">See the space</a></div>
    <div class="svc"><h3>Event and function sound</h3><p>PA, mixing and technicians for weddings, concerts, church and corporate events.</p><a href="index.php#sound">Hire our sound</a></div>
    <div class="svc"><h3>Student showcases</h3><p>Perform what you have learned with a live band and a proper sound system.</p><a href="#booking">Ask about the next one</a></div>
  </div>
</div>

<!-- ENQUIRY -->
<section id="booking">
  <div class="container">
    <p class="section-label">Start here</p>
    <h2 class="section-title">Book a trial lesson</h2>
    <div class="booking-wrap">
      <div class="booking-info">
        <h3>We will get back to you</h3>
        <p>Share a few details and we will reply with teacher availability and a trial lesson time.</p>
        <ul class="contact-lines">
          <li><span>Location</span><span><?= $e($studio_loc) ?></span></li>
          <li><span>Phone</span><span><a href="tel:<?= $e(preg_replace('/\s+/', '', $studio_phone)) ?>"><?= $e($studio_phone) ?></a></span></li>
          <li><span>Email</span><span><a href="mailto:<?= $e($studio_email) ?>"><?= $e($studio_email) ?></a></span></li>
        </ul>
      </div>

      <div class="booking-form">
        <!-- Shown when someone tries to submit the form (booking is not live yet) -->
        <div class="wip-notice" id="wipNotice" role="alert" <?= $wip ? '' : 'hidden' ?>>
          <h4>Feature work in progress</h4>
          <p>Online booking isn't ready yet, so your enquiry has not been sent. Please send it to us via WhatsApp instead and we will reply with teacher availability and a trial lesson time.</p>
          <a class="wip-wa" id="wipWa" href="<?= $e($wa_link) ?>" target="_blank" rel="noopener">
            <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16 3C9 3 3.4 8.6 3.4 15.5c0 2.3.6 4.4 1.7 6.3L3 29l7.4-2c1.8 1 3.800 1.500 5.800 1.500 7 0 12.600-5.600 12.600-12.500S23 3 16 3zm0 22.800c-1.800 0-3.600-.5-5.100-1.400l-.4-.2-4.400 1.200 1.200-4.300-.3-.4a10.200 10.200 0 0 1-1.600-5.500C5.400 9.800 10.200 5.200 16 5.200s10.600 4.600 10.600 10.300S21.800 25.800 16 25.800zm5.800-7.600c-.3-.2-1.900-.9-2.200-1-.3-.1-.5-.2-.7.200-.2.300-.8 1-1 1.200-.2.200-.4.200-.7.100-.3-.2-1.400-.5-2.600-1.600-1-.9-1.600-1.900-1.800-2.200-.2-.3 0-.5.100-.6l.5-.6c.1-.2.200-.3.300-.5.100-.2.100-.4 0-.6-.1-.2-.7-1.700-1-2.300-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.100-.9.400-.3.300-1.200 1.200-1.200 2.900s1.200 3.400 1.400 3.600c.2.200 2.400 3.800 5.900 5.200 3.500 1.400 3.500.9 4.100.9.600-.1 1.900-.8 2.200-1.600.3-.8.300-1.400.2-1.600-.1-.1-.3-.2-.6-.4z"/></svg>
            Send via WhatsApp
          </a>
        </div>

        <form method="post" action="learn.php#booking" id="enquiryForm" novalidate>
          <input type="hidden" name="csrf" value="<?= $e($_SESSION['csrf']) ?>">
          <div class="hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

          <div class="form-group"><label for="name">Full name</label>
            <input type="text" id="name" name="name" value="<?= $e($old['name']) ?>" required autocomplete="name"></div>

          <div class="form-row">
            <div class="form-group"><label for="email">Email</label>
              <input type="email" id="email" name="email" value="<?= $e($old['email']) ?>" required autocomplete="email"></div>
            <div class="form-group"><label for="phone">Phone</label>
              <input type="tel" id="phone" name="phone" value="<?= $e($old['phone']) ?>" required autocomplete="tel"></div>
          </div>

          <div class="form-group"><label for="instrument">Instrument</label>
            <select id="instrument" name="instrument" required>
              <option value="">Choose an instrument</option>
              <?php foreach ($valid_instruments as $opt): ?>
                <option value="<?= $e($opt) ?>" <?= $old['instrument']===$opt?'selected':'' ?>><?= $e($opt) ?></option>
              <?php endforeach; ?>
            </select></div>

          <div class="form-row">
            <div class="form-group"><label for="age_group">Learner</label>
              <select id="age_group" name="age_group" required>
                <option value="">Choose age group</option>
                <?php foreach ($valid_ages as $opt): ?>
                  <option value="<?= $e($opt) ?>" <?= $old['age_group']===$opt?'selected':'' ?>><?= $e($opt) ?></option>
                <?php endforeach; ?>
              </select></div>
            <div class="form-group"><label for="level">Experience</label>
              <select id="level" name="level" required>
                <option value="">Choose level</option>
                <?php foreach ($valid_levels as $opt): ?>
                  <option value="<?= $e($opt) ?>" <?= $old['level']===$opt?'selected':'' ?>><?= $e($opt) ?></option>
                <?php endforeach; ?>
              </select></div>
          </div>

          <div class="form-group"><label for="message">Anything we should know? (optional)</label>
            <textarea id="message" name="message" maxlength="1000" placeholder="Preferred days, songs you want to learn, goals..."><?= $e($old['message']) ?></textarea></div>

          <button type="submit" class="btn-primary">Send enquiry</button>
        </form>
      </div>
    </div>
  </div>
</section>
</main>

<footer>
  <div class="footer-inner">
    <div class="footer-copy">&copy; <?= date('Y') ?> <?= $e($studio_name) ?> &middot; <?= $e($studio_loc) ?></div>
    <div class="footer-copy">Lessons &middot; Rehearsal &middot; Event sound</div>
  </div>
</footer>

<script>
(function () {
  var root = document.documentElement;

  // Theme toggle (desktop + mobile)
  function toggleTheme() {
    var next = root.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    root.setAttribute('data-theme', next);
    try { localStorage.setItem('sg-theme', next); } catch (e) {}
  }
  ['themeBtn', 'themeBtnM'].forEach(function (id) {
    var b = document.getElementById(id); if (b) b.addEventListener('click', toggleTheme);
  });

  // Hamburger menu
  var burger = document.getElementById('burger'), menu = document.getElementById('mobileMenu');
  function setMenu(open) {
    burger.classList.toggle('open', open); menu.classList.toggle('open', open);
    burger.setAttribute('aria-expanded', open); document.body.style.overflow = open ? 'hidden' : '';
  }
  burger.addEventListener('click', function () { setMenu(!menu.classList.contains('open')); });
  menu.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', function () { setMenu(false); }); });

  // Instrument filter
  var chips = document.querySelectorAll('.chip'), cards = document.querySelectorAll('.inst-card');
  chips.forEach(function (chip) {
    chip.addEventListener('click', function () {
      var f = chip.dataset.filter;
      chips.forEach(function (c) { c.setAttribute('aria-pressed', c === chip); });
      cards.forEach(function (card) {
        card.hidden = !(f === 'all' || card.dataset.group.split(' ').indexOf(f) !== -1);
      });
    });
  });

  // "Enquire about X" pre-selects instrument and jumps to the form
  document.querySelectorAll('.pick').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var sel = document.getElementById('instrument');
      if (sel) sel.value = btn.dataset.instrument;
      document.getElementById('booking').scrollIntoView({ behavior: 'smooth' });
      setTimeout(function () { var n = document.getElementById('name'); if (n) n.focus({ preventScroll: true }); }, 600);
    });
  });

  // Booking is not live yet: intercept submit, show notice, point to WhatsApp
  var WA_NUMBER = <?= json_encode($wa_number) ?>;
  var form = document.getElementById('enquiryForm');
  var notice = document.getElementById('wipNotice');
  var waBtn = document.getElementById('wipWa');

  function val(id) { var el = document.getElementById(id); return el ? el.value.trim() : ''; }

  function buildWaLink() {
    var lines = ['Hi Sauti Gang, I would like to book a trial lesson.'];
    var rows = [
      ['Name', val('name')], ['Phone', val('phone')], ['Email', val('email')],
      ['Instrument', val('instrument')], ['Learner', val('age_group')],
      ['Experience', val('level')], ['Notes', val('message')]
    ];
    var extra = rows.filter(function (r) { return r[1]; });
    if (extra.length) {
      lines.push('');
      extra.forEach(function (r) { lines.push(r[0] + ': ' + r[1]); });
    }
    return 'https://wa.me/' + WA_NUMBER + '?text=' + encodeURIComponent(lines.join('\n'));
  }

  function showNotice() {
    if (waBtn) waBtn.href = buildWaLink();
    if (notice) {
      notice.hidden = false;
      notice.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  }

  if (form) {
    form.addEventListener('submit', function (ev) {
      ev.preventDefault();   // nothing is sent to the server
      showNotice();
    });
  }
  // If the page was loaded via a POST fallback (no JS earlier), refresh the link with what they typed
  <?php if ($wip): ?>if (waBtn) waBtn.href = buildWaLink(); document.getElementById('booking').scrollIntoView();<?php endif; ?>

  // Scroll reveal
  var io = 'IntersectionObserver' in window ? new IntersectionObserver(function (entries) {
    entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('visible'); io.unobserve(en.target); } });
  }, { threshold: 0.12 }) : null;
  document.querySelectorAll('.reveal').forEach(function (el) { io ? io.observe(el) : el.classList.add('visible'); });
})();
</script>

<!-- IMAGE LIGHTBOX (click any photo to expand) -->
<script>
(function () {
  var SEL = '.hero-img, .inst-card .thumb, .who-card';
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