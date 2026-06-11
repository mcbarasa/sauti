<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Admin Login</title>
<link rel="icon" type="image/webp" href="{{ asset('img/sauti_logo.WebP') }}">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet"/>
<style>
  /* ── Shared tokens ── */
  :root {
    --y: #F5C518;
    --y-dark: #D4A017;
    --red: #E55A5A;
    --r: 8px;
  }

  /* ── Dark theme (default) ── */
  [data-theme="dark"] {
    --bg:      #0A0A0A;
    --card-bg: #111111;
    --s2:      #171717;
    --s3:      #1e1e1e;
    --border:  rgba(255,255,255,0.07);
    --borderY: rgba(245,197,24,0.22);
    --txt:     #F0F0F0;
    --txt2:    #aaaaaa;
    --txt3:    #555555;
    --glow:    rgba(245,197,24,0.06);
    --input-bg:#1a1a1a;
    --input-border: rgba(255,255,255,0.09);
    --shadow:  0 8px 40px rgba(0,0,0,0.55);
  }

  /* ── Light theme ── */
  [data-theme="light"] {
    --bg:      #f4f1eb;
    --card-bg: #ffffff;
    --s2:      #f9f7f3;
    --s3:      #f0ede6;
    --border:  rgba(0,0,0,0.07);
    --borderY: rgba(180,130,10,0.25);
    --txt:     #111111;
    --txt2:    #444444;
    --txt3:    #888888;
    --glow:    rgba(245,197,24,0.08);
    --input-bg:#f5f3ee;
    --input-border: rgba(0,0,0,0.1);
    --shadow:  0 4px 24px rgba(0,0,0,0.09);
  }

  * { margin:0; padding:0; box-sizing:border-box; }

  body {
    background: var(--bg);
    color: var(--txt);
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.35s ease, color 0.35s ease;
  }

  body::before {
    content: '';
    position: fixed; inset: 0;
    background: radial-gradient(ellipse 60% 50% at 50% 50%, var(--glow), transparent 70%);
    pointer-events: none;
    transition: background 0.35s ease;
  }

  /* ── Card ── */
  .login-card {
    background: var(--card-bg);
    border: 1px solid var(--borderY);
    border-radius: 12px;
    padding: 2.5rem 2rem;
    width: 100%;
    max-width: 400px;
    box-shadow: var(--shadow);
    transition: background 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease;
  }

  /* ── Logo row ── */
/* ── Logo image theme handling ── */
.login-logo-icon {
    background: transparent; /* remove the yellow box behind the image */
}

.logo-img {
    width: 46px;
    height: 46px;
    object-fit: contain;
    border-radius: 9px;
    transition: filter 0.35s ease;
}

/* Dark theme: keep natural colors */
[data-theme="dark"] .logo-img {
    filter: none;
}

/* Light theme: slightly darken to suit light bg */
[data-theme="light"] .logo-img {
    filter: brightness(0.88) saturate(1.1);
}

  .login-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 2rem;
    justify-content: center;
  }

  .login-logo-icon {
    width: 46px; height: 46px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background 0.2s;
  }

  .login-logo-text b {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.18rem;
    letter-spacing: 3px;
    color: var(--y);
    display: block;
    line-height: 1.1;
    transition: color 0.35s;
  }

  [data-theme="light"] .login-logo-icon { filter: none; }

  .login-logo-text span {
    font-size: 0.62rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--txt3);
    transition: color 0.35s;
  }

  /* ── Heading ── */
  h2 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.85rem;
    letter-spacing: 2px;
    color: var(--txt);
    margin-bottom: 0.2rem;
    transition: color 0.35s;
  }

  .login-sub {
    font-size: 0.82rem;
    color: var(--txt3);
    margin-bottom: 1.75rem;
    transition: color 0.35s;
  }

  /* ── Form elements ── */
  .form-group {
    display: flex;
    flex-direction: column;
    gap: 0.38rem;
    margin-bottom: 1rem;
  }

  .form-group label {
    font-size: 0.68rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--txt3);
    transition: color 0.35s;
  }

  .form-group input {
    background: var(--input-bg);
    border: 1px solid var(--input-border);
    border-radius: var(--r);
    padding: 0.68rem 1rem;
    color: var(--txt);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.92rem;
    outline: none;
    width: 100%;
    transition: border-color 0.2s, background 0.35s, color 0.35s;
  }

  .form-group input:focus { border-color: var(--y); }

  .form-group input::placeholder { color: var(--txt3); }

  .input-error {
    color: var(--red);
    font-size: 0.75rem;
    margin-top: 0.2rem;
  }

  .error-banner {
    background: rgba(229,90,90,0.1);
    border: 1px solid rgba(229,90,90,0.3);
    color: var(--red);
    border-radius: var(--r);
    padding: 0.7rem 1rem;
    font-size: 0.84rem;
    margin-bottom: 1rem;
  }

  /* ── Remember me ── */
  .remember-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
    font-size: 0.84rem;
    color: var(--txt3);
    cursor: pointer;
    transition: color 0.35s;
  }

  .remember-row input {
    width: auto;
    accent-color: var(--y);
    cursor: pointer;
  }

  /* ── Submit button ── */
  .btn-login {
    width: 100%;
    background: var(--y);
    color: #0A0A0A;
    border: none;
    border-radius: var(--r);
    padding: 0.85rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.88rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.2s;
  }

  .btn-login:hover { background: var(--y-dark); }

  /* ── Back link ── */
  .back-link {
    display: block;
    text-align: center;
    margin-top: 1.25rem;
    font-size: 0.8rem;
    color: var(--txt3);
    text-decoration: none;
    transition: color 0.2s;
  }

  .back-link:hover { color: var(--y); }

  /* ── Responsive ── */
  @media (max-width: 440px) {
    .login-card { margin: 1rem; padding: 2rem 1.5rem; }
  }
</style>
</head>
<body>

@include('bookings.navbar')

<div class="login-card">

<div class="login-logo">
    <div class="login-logo-icon">
      <img src="{{ asset('img/sauti_logo.WebP') }}" alt="Sauti Gang Logo" style="height: 40px; width: auto;">
    </div>
    <div class="login-logo-text">
      <b>Sauti Gang</b>
      <span>Admin Portal</span>
    </div>
  </div>

  <h2>Welcome Back</h2>
  <p class="login-sub">Sign in to access the studio dashboard.</p>

  @if($errors->any())
    <div class="error-banner">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('admin.login') }}">
    @csrf

    <div class="form-group">
      <label>Email Address</label>
      <input type="email" name="email" value="{{ old('email') }}"
             placeholder="Enter email address" autofocus autocomplete="email"/>
      @error('email')<span class="input-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" placeholder="••••••••" autocomplete="current-password"/>
      @error('password')<span class="input-error">{{ $message }}</span>@enderror
    </div>

    <label class="remember-row">
      <input type="checkbox" name="remember"> Keep me signed in
    </label>

    <button type="submit" class="btn-login">Sign In →</button>
  </form>

  <a href="{{ route('home') }}" class="back-link">← Back to studio website</a>
</div>

<script>
/* ── Theme ── */
function toggleTheme() {
  const html = document.documentElement;
  html.setAttribute('data-theme', html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
  localStorage.setItem('theme', html.getAttribute('data-theme'));
}
const saved = localStorage.getItem('theme');
if (saved) document.documentElement.setAttribute('data-theme', saved);

/* ── Mobile menu ── */
const hamburger  = document.getElementById('navHamburger');
const mobileMenu = document.getElementById('mobileMenu');

function closeMobileMenu() {
  mobileMenu.classList.remove('open');
  hamburger.classList.remove('open');
  hamburger.setAttribute('aria-expanded', 'false');
  document.body.style.overflow = '';
}

hamburger.addEventListener('click', function() {
  const isOpen = mobileMenu.classList.toggle('open');
  hamburger.classList.toggle('open', isOpen);
  hamburger.setAttribute('aria-expanded', String(isOpen));
  document.body.style.overflow = isOpen ? 'hidden' : '';
});

mobileMenu.querySelectorAll('a[href*="#"]').forEach(function(link) {
  link.addEventListener('click', closeMobileMenu);
});

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeMobileMenu();
});

/* ── Scroll reveal ── */
const obs = new IntersectionObserver(function(entries) {
  entries.forEach(function(e) {
    if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
  });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(function(el) { obs.observe(el); });
</script>
@stack('scripts')
</body>
</html>