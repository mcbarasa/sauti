<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Admin Login</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet"/>
<style>
  :root { --y:#F5C518; --bg:#0A0A0A; --s1:#111; --s2:#171717; --s3:#202020; --border:rgba(255,255,255,0.07); --borderY:rgba(245,197,24,0.22); --txt:#F0F0F0; --txt3:#666; --red:#E55A5A; --r:6px; }
  * { margin:0; padding:0; box-sizing:border-box; }
  body { background:var(--bg); color:var(--txt); font-family:'DM Sans',sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; }
  body::before { content:''; position:fixed; inset:0; background:radial-gradient(ellipse 60% 50% at 50% 50%, rgba(245,197,24,0.05), transparent 70%); pointer-events:none; }

  .login-card { background:var(--s2); border:1px solid var(--borderY); border-radius:10px; padding:2.5rem 2rem; width:100%; max-width:400px; box-shadow:0 8px 40px rgba(0,0,0,0.5); }

  .login-logo { display:flex; align-items:center; gap:12px; margin-bottom:2rem; justify-content:center; }
  .login-logo-icon { width:42px; height:42px; background:var(--y); border-radius:8px; display:flex; align-items:center; justify-content:center; }
  .login-logo-text b { font-family:'Bebas Neue',sans-serif; font-size:1.2rem; letter-spacing:3px; color:var(--y); display:block; line-height:1; }
  .login-logo-text span { font-size:0.65rem; letter-spacing:3px; text-transform:uppercase; color:var(--txt3); }

  h2 { font-family:'Bebas Neue',sans-serif; font-size:1.8rem; letter-spacing:2px; margin-bottom:0.25rem; }
  .login-sub { font-size:0.82rem; color:var(--txt3); margin-bottom:1.75rem; }

  .form-group { display:flex; flex-direction:column; gap:0.4rem; margin-bottom:1rem; }
  .form-group label { font-size:0.72rem; letter-spacing:2px; text-transform:uppercase; color:var(--txt3); }
  .form-group input { background:var(--s3); border:1px solid var(--border); border-radius:var(--r); padding:0.7rem 1rem; color:var(--txt); font-family:'DM Sans',sans-serif; font-size:0.92rem; outline:none; width:100%; transition:border-color 0.2s; }
  .form-group input:focus { border-color:var(--y); }
  .input-error { color:var(--red); font-size:0.75rem; margin-top:0.2rem; }
  .error-banner { background:rgba(229,90,90,0.1); border:1px solid rgba(229,90,90,0.3); color:var(--red); border-radius:var(--r); padding:0.7rem 1rem; font-size:0.84rem; margin-bottom:1rem; }

  .remember-row { display:flex; align-items:center; gap:0.5rem; margin-bottom:1.25rem; font-size:0.84rem; color:var(--txt3); cursor:pointer; }
  .remember-row input { width:auto; accent-color:var(--y); cursor:pointer; }

  .btn-login { width:100%; background:var(--y); color:#0A0A0A; border:none; border-radius:var(--r); padding:0.85rem; font-family:'DM Sans',sans-serif; font-size:0.92rem; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; cursor:pointer; transition:background 0.2s; }
  .btn-login:hover { background:#D4A017; }

  .back-link { display:block; text-align:center; margin-top:1.25rem; font-size:0.8rem; color:var(--txt3); text-decoration:none; }
  .back-link:hover { color:var(--y); }
</style>
</head>
<body>
<div class="login-card">

  <div class="login-logo">
    <div class="login-logo-icon">
      <svg width="24" height="24" viewBox="0 0 44 44" fill="none">
        <circle cx="22" cy="22" r="10" fill="#0A0A0A"/>
        <circle cx="22" cy="22" r="5" fill="#F5C518"/>
        <path d="M8 22 Q12 16 16 22 Q20 28 16 28" stroke="#0A0A0A" stroke-width="2" fill="none" stroke-linecap="round"/>
        <path d="M36 22 Q32 16 28 22 Q24 28 28 28" stroke="#0A0A0A" stroke-width="2" fill="none" stroke-linecap="round"/>
      </svg>
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
</body>
</html>