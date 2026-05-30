@extends('layouts.app')
@section('title', 'Complete M-Pesa Payment — Sauti Gang Studio')

@section('content')
<section style="padding-top:8rem;padding-bottom:4rem;">
<div class="container" style="max-width:520px;margin:0 auto;">
  <div style="background:var(--surface);border:1px solid var(--border-y);border-radius:8px;padding:3rem 2rem;text-align:center;box-shadow:var(--shadow);">

    <div style="font-size:3.5rem;margin-bottom:1rem;">📱</div>

    <h2 style="font-family:'Bebas Neue',sans-serif;font-size:2rem;letter-spacing:2px;color:var(--yellow);margin-bottom:0.5rem;">
      Check Your Phone
    </h2>
    <p style="color:var(--gray-light);margin-bottom:0.3rem;">An M-Pesa prompt has been sent to</p>
    <p style="font-size:1.1rem;font-weight:700;color:var(--text);margin-bottom:0.3rem;">{{ $phone }}</p>
    {{-- Replace the amount line --}}
<p style="color:var(--gray);margin-bottom:2rem;">
  Enter your M-Pesa PIN to pay
  <strong style="color:var(--yellow);font-size:1.2rem;">
    KES {{ number_format($amount) }}
  </strong>
  @if(isset($is_recurring) && $is_recurring)
    <br>
    <span style="font-size:0.82rem;color:var(--gray);">
      Covers all <strong style="color:var(--text);">{{ $session_count }}</strong>
      recurring sessions
      ({{ $session_count }} × KES {{ number_format($amount_per) }})
    </span>
  @endif
</p>

    {{-- Status box --}}
    <div id="status-box" style="background:var(--surface2);border:1px solid var(--border);border-radius:6px;padding:1.2rem;margin-bottom:1.5rem;transition:border-color 0.3s;">
      <div id="status-icon" style="font-size:2rem;">⏳</div>
      <p id="status-text" style="color:var(--gray);font-size:0.9rem;margin-top:0.5rem;">
        Waiting for M-Pesa confirmation…
      </p>
      <div id="spinner" style="margin-top:0.75rem;">
        <div style="width:28px;height:28px;border:3px solid var(--border);border-top-color:var(--yellow);border-radius:50%;animation:spin 0.9s linear infinite;margin:0 auto;"></div>
      </div>
    </div>

    {{-- Attempt counter --}}
    <p id="attempt-text" style="font-size:0.78rem;color:var(--gray);margin-bottom:1.5rem;">
      Checking payment status…
    </p>

    <div style="display:flex;gap:0.75rem;justify-content:center;flex-wrap:wrap;">
      <a href="{{ route('bookings.create') }}" class="btn-secondary" style="font-size:0.82rem;padding:0.55rem 1.2rem;">
        ← Try Again
      </a>
      <a href="{{ route('home') }}" class="btn-secondary" style="font-size:0.82rem;padding:0.55rem 1.2rem;">
        Home
      </a>
    </div>
  </div>
</div>
</section>

<style>
@keyframes spin { to { transform:rotate(360deg); } }
</style>
@endsection

@push('scripts')
<script>
const csrfToken   = document.querySelector('meta[name="csrf-token"]').content;
const checkoutId  = '{{ $checkoutRequestId }}';
let   attempts    = 0;
const maxAttempts = 48;

async function checkPayment() {
  attempts++;

  try {
    // ── Pass attempt number so server can be lenient on early polls ───
    const res  = await fetch(
      `/book/check-payment?checkout_request_id=${checkoutId}&attempt=${attempts}`
    );
    const data = await res.json();

    if (data.status === 'completed') {
      document.getElementById('status-icon').textContent      = '✅';
      document.getElementById('status-text').textContent      = 'Payment confirmed! Redirecting…';
      document.getElementById('status-box').style.borderColor = 'rgba(52,199,123,0.5)';
      document.getElementById('spinner').style.display        = 'none';
      document.getElementById('attempt-text').textContent     = '';

      setTimeout(() => {
        if (data.is_recurring && data.redirect_url) {
          window.location.href = data.redirect_url;
        } else {
          window.location.href = `/bookings/${data.booking_id}`;
        }
      }, 1500);
      return;
    }

    if (data.status === 'failed') {
      document.getElementById('status-icon').textContent      = '❌';
      document.getElementById('status-box').style.borderColor = 'rgba(229,90,90,0.5)';
      document.getElementById('spinner').style.display        = 'none';
      document.getElementById('attempt-text').textContent     = '';
      document.getElementById('status-text').innerHTML        = `
        ${data.message || 'Payment failed or cancelled.'}<br><br>
        <a href="{{ route('bookings.create') }}"
           style="display:inline-block;background:var(--yellow);color:#0A0A0A;
                  padding:0.55rem 1.4rem;border-radius:4px;font-weight:700;
                  text-decoration:none;font-size:0.88rem;">
          Try Again
        </a>`;
      return;
    }

    if (data.status === 'slot_taken') {
      document.getElementById('status-icon').textContent  = '⚠️';
      document.getElementById('status-text').textContent  =
        'Payment received but that slot was just taken. Please contact us on 0733 590 438.';
      document.getElementById('spinner').style.display   = 'none';
      document.getElementById('attempt-text').textContent = '';
      return;
    }

    if (data.status === 'session_expired') {
      document.getElementById('status-icon').textContent  = '⚠️';
      document.getElementById('status-text').textContent  =
        'Session expired. If you paid, contact us on 0733 590 438 with your M-Pesa receipt.';
      document.getElementById('spinner').style.display   = 'none';
      document.getElementById('attempt-text').textContent = '';
      return;
    }

    // ── Still pending ─────────────────────────────────────────────────
    const elapsed = attempts * 5;
    let hint = '';
    if (elapsed >= 30 && elapsed < 90) hint = ' — check your phone for the prompt';
    else if (elapsed >= 90)            hint = ' — still waiting…';

    document.getElementById('attempt-text').textContent =
      `Checking with Safaricom… (${attempts}/${maxAttempts})${hint}`;

    if (attempts < maxAttempts) {
      setTimeout(checkPayment, 5000);
    } else {
      document.getElementById('status-icon').textContent      = '⏰';
      document.getElementById('status-box').style.borderColor = 'rgba(245,197,24,0.4)';
      document.getElementById('spinner').style.display        = 'none';
      document.getElementById('attempt-text').textContent     = '';
      document.getElementById('status-text').innerHTML        = `
        We haven't received confirmation yet.<br>
        <span style="font-size:0.85rem;color:var(--gray);">
          If you completed the payment, contact us on
          <strong style="color:var(--text);">0733 590 438</strong>
          with your M-Pesa receipt and we'll confirm manually.
        </span><br><br>
        <a href="{{ route('bookings.create') }}"
           style="display:inline-block;background:var(--yellow);color:#0A0A0A;
                  padding:0.55rem 1.4rem;border-radius:4px;font-weight:700;
                  text-decoration:none;font-size:0.88rem;margin-right:0.5rem;">
          Try Again
        </a>
        <a href="{{ route('home') }}"
           style="color:var(--gray);font-size:0.85rem;text-decoration:underline;">
          Go Home
        </a>`;
    }

  } catch(e) {
    console.error('Poll error:', e);
    if (attempts < maxAttempts) setTimeout(checkPayment, 5000);
  }
}

// ── Wait 8 seconds before first poll — gives Safaricom time to process ─
setTimeout(checkPayment, 8000);
</script>
@endpush