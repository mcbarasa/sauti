@extends('layouts.app')
@section('title', 'Sauti Gang Studios')

@section('content')

<style>
/* ── Mobile-first responsive additions ── */

/* Hero */
.hero-stats {
  display:flex; gap:3rem; margin-top:4rem;
  flex-wrap:wrap; justify-content:center;
}
.hero-buttons {
  display:flex; gap:1rem; margin-top:2.5rem;
  flex-wrap:wrap; justify-content:center;
}

/* About grid */
.about-grid {
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:5rem;
  align-items:center;
  margin-top:3rem;
}
.about-features {
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:1rem;
  margin-top:2rem;
}

/* Booking layout */
.booking-wrap {
  display:grid;
  grid-template-columns:1fr 1.3fr;
  gap:4rem;
  margin-top:3rem;
  align-items:start;
}
.form-row {
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:1rem;
}

/* Gallery grid */
.gallery-grid {
  display:grid;
  grid-template-columns:2fr 1fr 1fr;
  grid-template-rows:200px 200px;
  gap:1rem;
  margin-top:3rem;
}

/* Contact grid */
.contact-grid {
  display:grid;
  grid-template-columns:1fr 1.4fr;
  gap:4rem;
  margin-top:3rem;
}

/* ── Tablet ── */
@media (max-width:900px) {
  .about-grid    { grid-template-columns:1fr; gap:2.5rem; }
  .contact-grid  { grid-template-columns:1fr; gap:2rem; }
  .contact-map   { height:280px !important; }
  .gallery-grid  {
    grid-template-columns:1fr 1fr;
    grid-template-rows:180px 180px 180px;
  }
  .gallery-grid .gallery-hero {
    grid-column:span 2;
    grid-row:span 1;
  }
  .gallery-grid .gallery-wide {
    grid-column:span 2;
  }
  .booking-wrap  { grid-template-columns:1fr; gap:2.5rem; }
}
#pay{
  color: brown;
}

/* ── Mobile ── */
@media (max-width:600px) {
  /* Nav */
  nav { padding:0.9rem 1.2rem !important; }

  /* Hero */
  .hero-stats   { gap:1.5rem; }
  .hero-buttons { flex-direction:column; align-items:center; }
  .hero-buttons a { width:100%; max-width:300px; text-align:center; }

  /* Sections */
  section { padding:4rem 1.2rem !important; }
  .container { padding:0 !important; }

  /* About */
  .about-grid       { gap:2rem; }
  .about-img-wrap   { aspect-ratio:16/9 !important; }
  .about-badge      { width:90px !important; height:90px !important; font-size:0.85rem !important;
                      bottom:-1rem !important; right:-0.5rem !important; }
  .about-features   { grid-template-columns:1fr; }

  /* Booking */
  .booking-wrap     { gap:2rem; }
  .form-row         { grid-template-columns:1fr; gap:0; }
  .booking-form     { padding:1.2rem !important; }

  /* Gallery */
  .gallery-grid {
    grid-template-columns:1fr;
    grid-template-rows:200px 160px 160px 160px;
  }
  .gallery-grid .gallery-hero { grid-column:span 1; grid-row:span 1; }
  .gallery-grid .gallery-wide { grid-column:span 1; }

  /* Contact */
  .contact-grid { gap:2rem; }
  .contact-map  { height:240px !important; }

  /* Social icons */
  .social-row { flex-wrap:wrap; }

  /* Cal nav */
  .cal-day { font-size:0.75rem; padding:5px 2px; }
}

@keyframes pulse-info {
  0%,100% { box-shadow:0 0 0 0 rgba(245,197,24,0.5); }
  50%      { box-shadow:0 0 0 5px rgba(245,197,24,0); }
}
@keyframes slideUp {
  from { opacity:0; transform:translateY(20px) scale(0.97); }
  to   { opacity:1; transform:translateY(0)    scale(1); }
}

/* Hover highlight on the recording suite row */
li:has(#recording-suite-row) { transition:background 0.2s; }
</style>

<!-- ═══════════════ HERO ═══════════════ -->
@include('bookings.top')

<!-- ═══════════════ ABOUT ═══════════════ -->

@include('bookings.about')

<!-- ═══════════════ BOOKING ═══════════════ -->
<section id="booking" style="padding:6rem 1.5rem;">
  <div class="container">

    <div class="reveal">
      <p class="section-label">Book Online</p>
      <h2 class="section-title">Reserve Your<br>Studio Session</h2>
      <p class="section-sub">Pick a date, choose your room and time slot. We'll make sure your session doesn't clash with any existing bookings.</p>
    </div>

    <div class="booking-wrap reveal">

      <!-- Info side -->
      <div class="booking-info">
        <h3>Studio Hours</h3>
        <p>Our rooms are available every day. Book in advance to secure your preferred slot.</p>
        <ul class="hours-list">
          <li>Monday – Friday <span>7:00 AM – 11:00 PM</span></li>
          <li>Saturday        <span>8:00 AM – 12:00 AM</span></li>
          <li>Sunday <span>02:00 PM – 09:00 PM</span></li>
          <li>Overnight Rehearsal           <span>Contact Us so will make it happen ASAP!.</span></li>
        </ul>
<div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--hours-border);">
  <h3 style="font-size:1.4rem;margin-bottom:0.75rem;">Rates</h3>
  <ul class="hours-list">
    <li>Rehearsal Room (per hour) <span>KES 700</span></li>

    {{-- ── Recording Suite — clickable with info popup ── --}}
    <li style="cursor:pointer;position:relative;" onclick="showRecordingInfo()"
        title="Click to learn more">
      <span style="display:flex;align-items:center;gap:0.5rem;">
        Recording Suite (per hour)
        <span style="display:inline-flex;align-items:center;justify-content:center;
                     width:16px;height:16px;border-radius:50%;
                     background:var(--yellow);color:#0A0A0A;
                     font-size:0.65rem;font-weight:900;flex-shrink:0;
                     animation:pulse-info 2s infinite;">?</span>
      </span>
      <span style="color:var(--yellow);font-weight:700;text-decoration:underline;
                   text-underline-offset:3px;text-decoration-style:dotted;">
        KES 3,000
        <span style="font-size:0.65rem;font-weight:500;color:var(--gray);
                     text-decoration:none;display:block;margin-top:1px;">
          tap to see what's included
        </span>
      </span>
    </li>

    <li>Full Day Hire (12 hours) <span>KES 8,000</span></li>
    <li>Monthly Package          <span>Custom</span></li>
    <li>Payment:
      <span id="pay">
        The amount listed below is the deposit and we recommend clearing the balance after your session
      </span>
    </li>
  </ul>
</div>

{{-- ── Recording Suite Info Modal ── --}}
<div id="recording-modal"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.82);
            backdrop-filter:blur(6px);z-index:2000;
            align-items:center;justify-content:center;padding:1rem;">

  <div style="background:var(--surface);border:1px solid var(--border-y);
              border-radius:10px;max-width:480px;width:100%;
              box-shadow:0 24px 64px rgba(0,0,0,0.5);
              animation:slideUp 0.3s cubic-bezier(0.34,1.56,0.64,1);">

    {{-- Header --}}
    <div style="background:linear-gradient(135deg,#1a1400,#0A0A0A);
                border-bottom:1px solid var(--border-y);border-radius:10px 10px 0 0;
                padding:1.5rem 1.5rem 1.25rem;position:relative;">

      <button onclick="closeRecordingInfo()"
        style="position:absolute;top:1rem;right:1rem;width:28px;height:28px;
               border-radius:50%;background:var(--surface2);border:1px solid var(--border);
               color:var(--gray);cursor:pointer;font-size:1rem;display:flex;
               align-items:center;justify-content:center;transition:all 0.2s;"
        onmouseover="this.style.borderColor='var(--yellow)';this.style.color='var(--yellow)'"
        onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--gray)'">
        ✕
      </button>

      <div style="display:flex;align-items:center;gap:0.9rem;">
        <div style="width:44px;height:44px;border-radius:8px;background:var(--yellow);
                    display:flex;align-items:center;justify-content:center;
                    font-size:1.4rem;flex-shrink:0;">🎙</div>
        <div>
          <p style="font-size:0.65rem;letter-spacing:3px;text-transform:uppercase;
                    color:var(--yellow);margin-bottom:2px;">Premium Service</p>
          <h3 style="font-family:'Bebas Neue',sans-serif;font-size:1.6rem;
                     letter-spacing:2px;color:#fff;line-height:1;">
            Recording Suite
          </h3>
        </div>
      </div>

      <div style="margin-top:1rem;display:flex;align-items:baseline;gap:0.4rem;">
        <span style="font-family:'Bebas Neue',sans-serif;font-size:2.2rem;
                     color:var(--yellow);letter-spacing:2px;">KES 3,000</span>
        <span style="color:var(--gray);font-size:0.8rem;">/ hour</span>
      </div>
    </div>

    {{-- Body --}}
    <div style="padding:1.5rem;">
      <p style="font-size:0.82rem;color:var(--gray);margin-bottom:1.25rem;line-height:1.6;">
        The Recording Suite rate reflects a premium, fully-prepared environment built around your sound. Here's exactly what you get:
      </p>

      {{-- Reason 1 --}}
      <div style="display:flex;gap:1rem;margin-bottom:1.1rem;align-items:flex-start;">
        <div style="width:38px;height:38px;border-radius:8px;flex-shrink:0;
                    background:rgba(245,197,24,0.12);border:1px solid var(--border-y);
                    display:flex;align-items:center;justify-content:center;font-size:1.1rem;">
          🎛
        </div>
        <div>
          <p style="font-weight:700;color:var(--text);font-size:0.9rem;margin-bottom:3px;">
            Custom Room Setup & Configuration
          </p>
          <p style="font-size:0.8rem;color:var(--gray);line-height:1.65;">
            Before your session begins, our team configures the entire room to match your setup —
            instrument placements, monitor mixes, mic positions, signal routing and DAW template.
            No time wasted, just plug in and play.
          </p>
        </div>
      </div>

      {{-- Reason 2 --}}
      <div style="display:flex;gap:1rem;margin-bottom:1.5rem;align-items:flex-start;">
        <div style="width:38px;height:38px;border-radius:8px;flex-shrink:0;
                    background:rgba(245,197,24,0.12);border:1px solid var(--border-y);
                    display:flex;align-items:center;justify-content:center;font-size:1.1rem;">
          🎧
        </div>
        <div>
          <p style="font-weight:700;color:var(--text);font-size:0.9rem;margin-bottom:3px;">
            In-Session Sound Engineer
          </p>
          <p style="font-size:0.8rem;color:var(--gray);line-height:1.65;">
            A dedicated sound engineer is on hand throughout your session — handling levels,
            making real-time adjustments and ensuring every take sounds its best.
            Think of it as having a professional ear in the room at all times.
          </p>
        </div>
      </div>

      {{-- CTA --}}
      <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
        <a href="#booking" onclick="closeRecordingInfo()"
           class="btn-primary" style="flex:1;text-align:center;padding:0.65rem 1rem;font-size:0.85rem;">
          Book Recording Suite
        </a>
        <button onclick="closeRecordingInfo()"
          class="btn-secondary"
          style="flex:1;padding:0.65rem 1rem;font-size:0.85rem;cursor:pointer;">
          Got it
        </button>
      </div>
    </div>
  </div>
</div>
      </div>

      <!-- Form side -->
      <div class="booking-form">

        {{-- ── General errors (payment, validation, etc.) ── --}}
@if ($errors->any())
  <div class="error-banner">
    <strong>Please fix the following:</strong><br>
    <ul style="margin-top:0.4rem;padding-left:1.2rem;">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

{{-- ── Slot-specific error ── --}}
@if ($errors->has('slot'))
  <div class="error-banner">{{ $errors->first('slot') }}</div>
@endif

        <form id="bookingForm" action="{{ route('bookings.initiate') }}" method="POST" novalidate>
          @csrf

          <!-- Mini Calendar -->
          <div class="mini-calendar">
            <div class="cal-header">
              <button type="button" class="cal-nav-btn" id="prevMonth">&#8249;</button>
              <h4 id="calMonthYear"></h4>
              <button type="button" class="cal-nav-btn" id="nextMonth">&#8250;</button>
            </div>
            <div class="cal-grid" id="calGrid"></div>
          </div>

          <input type="hidden" name="booking_date" id="bookingDateInput" value="{{ old('booking_date') }}">

          <div class="form-row">
            <div class="form-group">
              <label>Selected Date</label>
              <input type="text" id="selectedDateDisplay" placeholder="Click a date above" readonly
                     style="cursor:default;"
                     value="{{ old('booking_date') ? \Carbon\Carbon::parse(old('booking_date'))->format('d M Y') : '' }}" />
              @error('booking_date')<span class="input-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
              <label>Room</label>
              <select name="room" id="roomSelect">
                <option value="">Select Session</option>
                @foreach($rooms as $value => $label)
                  <option value="{{ $value }}" {{ old('room') == $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
              @error('room')<span class="input-error">{{ $message }}</span>@enderror
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Start Time</label> 
              <select name="start_time" id="startTime">
                <option value="">Start time</option>
                @foreach($timeSlots as $slot)
                  <option value="{{ $slot }}" {{ old('start_time') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                @endforeach
              </select>
              
              @error('start_time')<span class="input-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
  <label>Duration (hours)</label>
  <input type="number"
         name="duration"
         id="durationInput"
         min="1"
         max="12"
         step="1"
         placeholder="e.g. 1"
         value="{{ old('duration', '') }}"
         inputmode="numeric"
         oninput="this.value = Math.max(1, Math.min(12, Math.floor(Math.abs(this.value || 1)))); computeAmount();"
  />
  @error('duration')<span class="input-error">{{ $message }}</span>@enderror
</div>
          </div>

          <div class="form-group">
            <label>Your Name</label>
            <input type="text" name="name" placeholder="Full name" value="{{ old('name') }}" />
            @error('name')<span class="input-error">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
    <label>Phone</label>
    <div style="display:flex;align-items:center;background:var(--surface2);border:1px solid var(--border);border-radius:4px;overflow:hidden;">
        <span style="padding:0 0.75rem;color:var(--yellow);font-weight:600;font-size:0.95rem;border-right:1px solid var(--border);height:100%;display:flex;align-items:center;white-space:nowrap;user-select:none;">+254</span>
        <input type="tel"
               id="phoneInput"
               maxlength="9"
               placeholder="7XX XXX XXX"
               style="border:none;background:transparent;flex:1;padding:0.75rem;outline:none;"
               value="{{ old('phone') ? preg_replace('/^\+?254|^0/', '', old('phone')) : '' }}"
               inputmode="numeric"
               oninput="this.value = this.value.replace(/^0+/, '').replace(/[^0-9]/g, '').substring(0, 9)"
        />
    </div>
    <input type="hidden" name="phone" id="phoneHidden"
           value="{{ old('phone') ?: '' }}" />
    @error('phone')<span class="input-error">{{ $message }}</span>@enderror
</div>

          <div class="form-group">
            <label>Deposited Amount (KES)</label>
            <input type="text" id="amountDisplay" readonly
                   style="cursor:default;color:var(--yellow);font-weight:700;font-size:1.05rem;"
                   placeholder="Select duration to calculate" />
            <input type="hidden" name="amount" id="amountInput" value="{{ old('amount', 0) }}" />
            @error('amount')<span class="input-error">{{ $message }}</span>@enderror
          </div>

          {{-- ── Recurring toggle ── --}}
<div class="form-group" style="margin-top:0.75rem;">
  <label style="display:flex;align-items:center;gap:0.75rem;cursor:pointer;user-select:none;">
    <div id="recurringToggle"
         onclick="toggleRecurring()"
         style="width:42px;height:24px;border-radius:12px;background:var(--surface3);
                border:1px solid var(--border);position:relative;cursor:pointer;
                transition:background 0.25s,border-color 0.25s;flex-shrink:0;">
      <div id="recurringThumb"
           style="position:absolute;top:3px;left:3px;width:16px;height:16px;
                  border-radius:50%;background:var(--gray);
                  transition:transform 0.25s,background 0.25s;"></div>
    </div>
    <span style="font-size:0.82rem;color:var(--text2);">
      Make this a <strong style="color:var(--text);">recurring booking</strong>
    </span>
  </label>
</div>

{{-- ── Recurring options (hidden by default) ── --}}
<div id="recurringOptions" style="display:none;background:var(--surface2);
     border:1px solid var(--border-y);border-radius:6px;padding:1.2rem;margin-bottom:1rem;">

  <p style="font-size:0.72rem;letter-spacing:2px;text-transform:uppercase;
             color:var(--yellow);margin-bottom:1rem;">Recurring Settings</p>

  <div class="form-row">
    <div class="form-group">
      <label>Frequency</label>
      <select id="recurrenceFrequency" name="recurrence_frequency">
        <option value="daily">Daily (every day)</option>
        <option value="weekly">Weekly (same day every week)</option>
        <option value="biweekly">Every 2 Weeks</option>
        <option value="monthly">Monthly (same date)</option>
      </select>
    </div>
    <div class="form-group">
      <label>Repeat Until</label>
      <input type="date" id="recurrenceEnd" name="recurrence_end"
             min="{{ date('Y-m-d', strtotime('+1 week')) }}" />
    </div>
  </div>

  <div style="display:flex;gap:0.75rem;align-items:center;flex-wrap:wrap;">
    <button type="submit" onclick="previewRecurring()"
            class="btn-secondary" style="padding:0.5rem 1.2rem;font-size:0.82rem;">
      👁 Preview Sessions
    </button>
    <span id="recurringCount" style="font-size:0.82rem;color:var(--gray);"></span>
  </div>

  {{-- Preview table --}}
  <div id="recurringPreview" style="display:none;margin-top:1rem;"></div>

  {{-- Skip conflicts option --}}
  <div id="skipConflictsWrap" style="display:none;margin-top:0.75rem;">
    <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;
                  color:var(--text2);cursor:pointer;">
      <input type="checkbox" name="skip_conflicts" value="1" checked
             style="accent-color:var(--yellow);width:14px;height:14px;">
      Skip conflicting dates automatically
    </label>
  </div>
</div>

<div class="form-group">
            <label>Notes (optional)</label>
            <textarea name="notes" placeholder="Equipment needs, band members, genre...">{{ old('notes') }}</textarea>
          </div>

<input type="hidden" name="is_recurring" id="isRecurringInput" value="0">


          <div class="slot-notice" id="slotNotice"></div>

          <button type="submit" id="submitBtn" class="btn-primary" style="width:100%;">Confirm Booking</button>
        </form>

        @if(session('success'))
          <div class="booking-confirm-msg" style="display:block;">✓ {{ session('success') }}</div>
        @endif
      </div>
    </div>
  </div>
</section>

<section>
  @include('bookings.artists')
</section>

<!-- ═══════════════ CONTACT ═══════════════ -->
<section id="contact" style="background:var(--bg-alt);padding:6rem 1.5rem;">
  <div class="container">

    <div class="reveal">
      <p class="section-label">Find Us</p>
      <h2 class="section-title">Get in Touch</h2>
      <p class="section-sub">Drop by, call us, or hit us up on social. We're always ready to welcome the next great artist.</p>
    </div>

    <div class="contact-grid reveal">

      <!-- Contact info -->
      <div>
        <h3 style="font-family:'Bebas Neue',sans-serif;font-size:1.6rem;letter-spacing:2px;color:var(--yellow);margin-bottom:1.5rem;">
          Contact &amp; Socials
        </h3>

        @foreach([
          ['📍', 'Location',          'Karen Village<br>Nairobi, Kenya'],
          ['📞', 'Phone / WhatsApp',  '+254 733 590 438 / +254 112 935 073'],
          ['✉️', 'Email',             'hey@sautigang.com'],
        ] as $c)
        <div style="display:flex;gap:1rem;margin-bottom:1.5rem;align-items:flex-start;">
          <div style="width:40px;height:40px;background:var(--yellow-bg);border:1px solid var(--border-y);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;">{{ $c[0] }}</div>
          <div>
            <h4 style="font-size:0.75rem;letter-spacing:2px;text-transform:uppercase;color:var(--gray);margin-bottom:0.2rem;">{{ $c[1] }}</h4>
            <p style="color:var(--text);font-size:0.95rem;">{!! $c[2] !!}</p>
          </div>
        </div>
        @endforeach

        <div class="social-row" style="display:flex;gap:0.75rem;margin-top:2rem;">
          <a href="https://www.instagram.com/sautigangstudios/" target="_blank"
             style="background:var(--surface2);border:1px solid var(--border-y);border-radius:50%;width:42px;height:42px;display:flex;align-items:center;justify-content:center;color:var(--text2);font-size:1.1rem;text-decoration:none;transition:border-color 0.2s,color 0.2s;">
            <i class="fa-brands fa-instagram"></i>
          </a>
          <a href="https://www.youtube.com/@sautigang" target="_blank"
             style="background:var(--surface2);border:1px solid var(--border-y);border-radius:50%;width:42px;height:42px;display:flex;align-items:center;justify-content:center;color:var(--text2);font-size:1.1rem;text-decoration:none;">
            <i class="fa-brands fa-youtube"></i>
          </a>
          <a href="https://x.com/SautiGang" target="_blank"
             style="background:var(--surface2);border:1px solid var(--border-y);border-radius:50%;width:42px;height:42px;display:flex;align-items:center;justify-content:center;color:var(--text2);font-size:1.1rem;text-decoration:none;">
            <i class="fa-brands fa-twitter"></i>
          </a>
        </div>
      </div>

      <!-- Map -->
      <div class="contact-map" style="border-radius:4px;overflow:hidden;border:1px solid var(--border-y);height:380px;box-shadow:var(--shadow);">
        <iframe src="https://www.google.com/maps?q=/Sauti+Gang+Studios&output=embed"
                style="width:100%;height:100%;border:none;filter:var(--map-filter);"
                allowfullscreen loading="lazy"></iframe>
      </div>

    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
// ── Booked slots injected from PHP ───────────────────────────────────
const bookedSlots = @json($bookedSlotsJson ? json_decode($bookedSlotsJson, true) : []);

let calYear, calMonth, selectedDate;

// ── Init calendar ────────────────────────────────────────────────────
function initCalendar() {
  const now = new Date();
  calYear   = now.getFullYear();
  calMonth  = now.getMonth();

  const oldDate = document.getElementById('bookingDateInput').value;
  if (oldDate) {
    const d  = new Date(oldDate);
    selectedDate = { d: d.getDate(), m: d.getMonth(), y: d.getFullYear() };
    calYear  = d.getFullYear();
    calMonth = d.getMonth();
  }
  renderCalendar();
  if (document.getElementById('bookingDateInput').value) {
    filterTimeSlots(document.getElementById('bookingDateInput').value);
  }
}

// ── Render calendar grid ─────────────────────────────────────────────
function renderCalendar() {
  const months = ['January','February','March','April','May','June',
                  'July','August','September','October','November','December'];
  document.getElementById('calMonthYear').textContent = `${months[calMonth]} ${calYear}`;

  const grid = document.getElementById('calGrid');
  grid.innerHTML = '';

  ['Su','Mo','Tu','We','Th','Fr','Sa'].forEach(d => {
    const el = document.createElement('div');
    el.className   = 'cal-day-name';
    el.textContent = d;
    grid.appendChild(el);
  });

  const firstDay    = new Date(calYear, calMonth, 1).getDay();
  const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
  const today       = new Date();

  for (let i = 0; i < firstDay; i++) {
    const el = document.createElement('div');
    el.className = 'cal-day empty';
    grid.appendChild(el);
  }

  for (let d = 1; d <= daysInMonth; d++) {
    const el       = document.createElement('div');
    el.className   = 'cal-day';
    el.textContent = d;

    const thisDate = new Date(calYear, calMonth, d);
    if (thisDate < new Date(today.getFullYear(), today.getMonth(), today.getDate())) {
      el.classList.add('past');
    }

    const key = `${calYear}-${calMonth}-${d}`;
    if (Array.isArray(bookedSlots[key]) && bookedSlots[key].length >= 3) {
      el.classList.add('booked');
    }

    if (selectedDate &&
        selectedDate.d === d &&
        selectedDate.m === calMonth &&
        selectedDate.y === calYear) {
      el.classList.add('selected');
    } else if (d === today.getDate() &&
               calMonth === today.getMonth() &&
               calYear === today.getFullYear()) {
      el.classList.add('today');
    }

    el.addEventListener('click', () => selectDate(d, calMonth, calYear));
    grid.appendChild(el);
  }
}

// ── Select a date ────────────────────────────────────────────────────
function selectDate(d, m, y) {
  selectedDate = { d, m, y };
  const months  = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  const mm      = String(m + 1).padStart(2, '0');
  const dd      = String(d).padStart(2, '0');
  const dateStr = `${y}-${mm}-${dd}`;

  document.getElementById('selectedDateDisplay').value = `${d} ${months[m]} ${y}`;
  document.getElementById('bookingDateInput').value    = dateStr;

  filterTimeSlots(dateStr); // ← always call after date change
  renderCalendar();
}

// ── Mark booked + past time slots ───────────────────────────────────
function filterTimeSlots(selectedDateStr) {
  const select  = document.getElementById('startTime');
  const options = select.querySelectorAll('option');
  const hint    = document.getElementById('time-hint');

  const now      = new Date();
  const todayStr = now.getFullYear() + '-' +
    String(now.getMonth() + 1).padStart(2, '0') + '-' +
    String(now.getDate()).padStart(2, '0');

  const isToday   = selectedDateStr === todayStr;
  const currentHr = now.getHours();

  const parts    = selectedDateStr.split('-');
  const dateKey  = `${parseInt(parts[0])}-${parseInt(parts[1])}-${parseInt(parts[2])}`;
  const room     = document.getElementById('roomSelect').value;

  // ── Check if selected date is a Sunday ───────────────────────────
  const selectedDateObj = new Date(selectedDateStr);
  const isSunday        = selectedDateObj.getDay() === 0;

  // Show Sunday notice
const sundayNotice = document.getElementById('sunday-notice');
if (sundayNotice) sundayNotice.style.display = isSunday ? 'block' : 'none';

  if (hint) hint.style.display = isToday ? 'block' : 'none';

  options.forEach(opt => {
    if (!opt.value) return; // skip placeholder

    const slotHour = parseInt(opt.value.split(':')[0], 10);
    const slotKey  = `${dateKey}-${room}-${opt.value.substring(0, 5)}`;
    const isPast   = isToday && slotHour <= currentHr;
    const isBooked = room && bookedSlots[slotKey] === true;

    // ── Sunday rule: only 14:00 – 21:00 allowed ──────────────────
    const isClosedSunday = isSunday && (slotHour < 14 || slotHour >= 21);

    if (isClosedSunday) {
      // Hide completely on Sundays outside operating hours
      opt.disabled         = true;
      opt.style.display    = 'none';
      opt.style.color      = '#555';
      opt.style.background = '#1a1a1a';
      opt.textContent      = opt.value.substring(0, 5) + ' — closed';
    } else if (isPast) {
      opt.disabled         = true;
      opt.style.display    = '';
      opt.style.color      = '#555';
      opt.style.background = '#1a1a1a';
      opt.textContent      = opt.value.substring(0, 5) + ' — passed';
    } else if (isBooked) {
      opt.disabled         = true;
      opt.style.display    = '';
      opt.style.color      = '#E55A5A';
      opt.style.background = 'rgba(229,90,90,0.08)';
      opt.textContent      = opt.value.substring(0, 5) + ' — booked';
    } else {
      // Available
      opt.disabled         = false;
      opt.style.display    = '';
      opt.style.color      = '';
      opt.style.background = '';
      opt.textContent      = opt.value.substring(0, 5);
    }
  });

  // Reset selection if currently selected slot is now disabled
  if (select.value && select.options[select.selectedIndex]?.disabled) {
    select.value = '';
  }
}

// ── Check for slot clash ─────────────────────────────────────────────
function checkClash() {
  if (!selectedDate) return;
  const key    = `${selectedDate.y}-${selectedDate.m}-${selectedDate.d}`;
  const room   = document.getElementById('roomSelect').value;
  const time   = document.getElementById('startTime').value;
  const notice = document.getElementById('slotNotice');

  if (!room || !time) { notice.classList.remove('show'); return; }

  if (bookedSlots[`${key}-${room}-${time}`]) {
    notice.textContent = '⚠ That slot is already booked. Please choose a different time or room.';
    notice.classList.add('show');
  } else {
    notice.classList.remove('show');
  }
}

// ── Month navigation with slot fetching ─────────────────────────────
async function fetchSlotsForMonth(y, m) {
  const res  = await fetch(`/api/slots?year=${y}&month=${m + 1}`);
  const data = await res.json();
  Object.assign(bookedSlots, data);
}

document.getElementById('prevMonth').onclick = async () => {
  calMonth--;
  if (calMonth < 0) { calMonth = 11; calYear--; }
  await fetchSlotsForMonth(calYear, calMonth);
  renderCalendar();
};

document.getElementById('nextMonth').onclick = async () => {
  calMonth++;
  if (calMonth > 11) { calMonth = 0; calYear++; }
  await fetchSlotsForMonth(calYear, calMonth);
  renderCalendar();
};

// ── Room change handler (SINGLE listener — re-filters slots, recomputes
//    amount, and logs debug info). Previously this was assigned twice,
//    which silently dropped the first listener; now it's merged into one
//    so changing rooms always updates both the slot list and the amount. ──
document.getElementById('roomSelect').onchange = () => {
  const dateStr = document.getElementById('bookingDateInput').value;

  if (dateStr) {
    const parts   = dateStr.split('-');
    const year    = parseInt(parts[0]);
    const month   = parseInt(parts[1]);
    const day     = parseInt(parts[2]);
    const dateKey = `${year}-${month}-${day}`;
    const room    = document.getElementById('roomSelect').value;
    console.log('Date key built:', dateKey);
    console.log('Room:', room);
    console.log('Sample slot key:', `${dateKey}-${room}-09:00`);
    console.log('All booked keys:', Object.keys(bookedSlots));
    filterTimeSlots(dateStr);
  }

  computeAmount();
};

document.getElementById('startTime').onchange  = checkClash;

// ── Auto-compute amount (per-room hourly rates) ───────────────────────
// Recording Suite (room-c) bills at KES 3,000/hr; every other room
// bills at the standard KES 350/hr deposit rate. Selecting "Recording
// Suite" auto-applies its rate, and increasing duration auto-multiplies
// it (1hr = 3000, 2hr = 6000, 3hr = 9000, etc.) — same as every other room.
// Changing the room AFTER duration is already filled also recomputes
// immediately via the roomSelect.onchange handler above.
const ROOM_RATES = {
  'room-a': 350,   // Rehearsal – (Band)
  'room-b': 350,   // Rehearsal – (Solo)
  'room-c': 3000,  // Recording – Suite
  'room-d': 350,   // Lesson – Instrument
  'room-e': 350,   // Room 1 – Podcast/Production
};
const DEFAULT_RATE = 350;

function computeAmount() {
  const input    = document.getElementById('durationInput');
  const hours    = parseInt(input.value, 10);
  const room     = document.getElementById('roomSelect').value;
  const rate     = room ? (ROOM_RATES[room] ?? DEFAULT_RATE) : 0;
  const amount   = (!isNaN(hours) && hours >= 1 && rate) ? hours * rate : 0;
  const label    = !rate                ? '' :
                   hours === 12         ? `KES ${amount.toLocaleString()} (Full Day)` :
                   amount                ? `KES ${amount.toLocaleString()}` : '';
  document.getElementById('amountDisplay').value = label;
  document.getElementById('amountInput').value   = amount;
}

document.getElementById('durationInput').addEventListener('input', computeAmount);

// ── Kick off ─────────────────────────────────────────────────────────
initCalendar();
computeAmount();

// ── Recurring booking JS ─────────────────────────────────────────────
let recurringOn = false;

function toggleRecurring() {
  recurringOn = !recurringOn;
  const toggle = document.getElementById('recurringToggle');
  const thumb  = document.getElementById('recurringThumb');
  const opts   = document.getElementById('recurringOptions');
  const input  = document.getElementById('isRecurringInput');

  if (recurringOn) {
    toggle.style.background  = 'rgba(245,197,24,0.2)';
    toggle.style.borderColor = 'var(--yellow)';
    thumb.style.transform    = 'translateX(18px)';
    thumb.style.background   = 'var(--yellow)';
    opts.style.display       = 'block';
    input.value              = '1';
    document.getElementById('submitBtn').textContent = 'Book Recurring Sessions';
  } else {
    toggle.style.background  = 'var(--surface3)';
    toggle.style.borderColor = 'var(--border)';
    thumb.style.transform    = 'translateX(0)';
    thumb.style.background   = 'var(--gray)';
    opts.style.display       = 'none';
    input.value              = '0';
    document.getElementById('submitBtn').textContent       = 'Confirm Booking';
    document.getElementById('submitBtn').style.background  = '';
    document.getElementById('submitBtn').style.color       = '';

    // *** Reset form action back to single booking ***
    document.getElementById('bookingForm').action = '{{ route("bookings.initiate") }}';

    // *** Reset amount display back to single-session rate ***
    computeAmount();

    // Clear the preview
    document.getElementById('recurringPreview').style.display = 'none';
    document.getElementById('recurringPreview').innerHTML     = '';
    document.getElementById('recurringCount').innerHTML       = '';
    document.getElementById('skipConflictsWrap').style.display = 'none';
  }
}
async function previewRecurring() {
  const date      = document.getElementById('bookingDateInput').value;
  const room      = document.getElementById('roomSelect').value;
  const time      = document.getElementById('startTime').value;
  const duration  = document.getElementById('durationInput').value;
  const frequency = document.getElementById('recurrenceFrequency').value;
  const endDate   = document.getElementById('recurrenceEnd').value;

  if (!date || !room || !time || !duration || !endDate) {
    alert('Please fill in date, room, start time, duration and repeat-until date first.');
    return;
  }

  const btn = event.target;
  btn.textContent = 'Loading…';
  btn.disabled    = true;

  try {
    const res = await fetch('/book/preview-recurring', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept':       'application/json',
      },
      body: JSON.stringify({
        booking_date:          date,
        room,
        start_time:            time,
        duration,
        recurrence_frequency:  frequency,
        recurrence_end:        endDate,
      }),
    });

    const data = await res.json();

    // Update session count label
    document.getElementById('recurringCount').innerHTML =
      `<span style="color:#34C77B;">✓ ${data.available_count} available</span>` +
      (data.conflict_count > 0
        ? ` &nbsp;·&nbsp; <span style="color:#E55A5A;">⚠ ${data.conflict_count} conflicts</span>`
        : '') +
      ` &nbsp;·&nbsp; Total: <strong style="color:var(--yellow);">KES ${data.total_amount.toLocaleString()}</strong>`;

    // Build slot preview table
    const preview = document.getElementById('recurringPreview');
    preview.style.display = 'block';
    preview.innerHTML = `
      <div style="border:1px solid var(--border);border-radius:4px;overflow:hidden;max-height:240px;overflow-y:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:0.82rem;">
          <thead>
            <tr style="background:var(--surface3);">
              <th style="padding:0.5rem 0.75rem;text-align:left;color:var(--gray);font-size:0.68rem;letter-spacing:2px;text-transform:uppercase;">#</th>
              <th style="padding:0.5rem 0.75rem;text-align:left;color:var(--gray);font-size:0.68rem;letter-spacing:2px;text-transform:uppercase;">Date</th>
              <th style="padding:0.5rem 0.75rem;text-align:left;color:var(--gray);font-size:0.68rem;letter-spacing:2px;text-transform:uppercase;">Status</th>
            </tr>
          </thead>
          <tbody>
            ${data.slots.map((slot, i) => `
              <tr style="border-top:1px solid var(--border);">
                <td style="padding:0.45rem 0.75rem;color:var(--gray);">${i + 1}</td>
                <td style="padding:0.45rem 0.75rem;color:var(--text);">${slot.formatted}</td>
                <td style="padding:0.45rem 0.75rem;">
                  ${slot.available
                    ? '<span style="color:#34C77B;font-size:0.75rem;">✓ Available</span>'
                    : '<span style="color:#E55A5A;font-size:0.75rem;">⚠ Conflict — will skip</span>'
                  }
                </td>
              </tr>`).join('')}
          </tbody>
        </table>
      </div>
      <div style="background:rgba(245,197,24,0.08);border:1px solid var(--border-y);
                  border-radius:4px;padding:0.85rem 1rem;margin-top:0.75rem;
                  display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
        <div>
          <p style="font-size:0.7rem;letter-spacing:2px;text-transform:uppercase;
                    color:var(--gray);margin-bottom:2px;">Total M-Pesa Charge</p>
          <p style="font-family:'DM Mono',monospace;font-size:1.4rem;font-weight:700;
                    color:var(--yellow);">KES ${data.total_amount.toLocaleString()}</p>
        </div>
        <div style="text-align:right;">
          <p style="font-size:0.78rem;color:var(--gray);">
            ${data.available_count} sessions × KES ${data.amount_per.toLocaleString()}
          </p>
          ${data.conflict_count > 0
            ? `<p style="font-size:0.75rem;color:#E55A5A;">
                 ${data.conflict_count} conflicting date(s) excluded
               </p>`
            : ''}
        </div>
      </div>`;

    if (data.conflict_count > 0) {
      document.getElementById('skipConflictsWrap').style.display = 'block';
    }

    // Update amount fields to show recurring total
    document.getElementById('amountDisplay').value =
      `KES ${data.total_amount.toLocaleString()} (${data.available_count} × KES ${data.amount_per.toLocaleString()})`;
    document.getElementById('amountInput').value = data.total_amount;

    // *** KEY FIX: switch form action to recurring route ***
    document.getElementById('bookingForm').action = '{{ route("bookings.store-recurring") }}';

    // Update submit button
    document.getElementById('submitBtn').textContent =
      `Pay KES ${data.total_amount.toLocaleString()} & Book ${data.available_count} Sessions`;
    document.getElementById('submitBtn').style.background = 'var(--yellow)';
    document.getElementById('submitBtn').style.color      = '#0A0A0A';

  } catch (e) {
    console.error(e);
    alert('Could not load preview. Please try again.');
  } finally {
    btn.textContent = '👁 Preview Sessions';
    btn.disabled    = false;
  }
}
// ── Phone field: prefix +254 and strip leading zero ──────────────────
document.getElementById('bookingForm').addEventListener('submit', function () {
    const local = document.getElementById('phoneInput').value.replace(/^0+/, '').replace(/[^0-9]/g, '');
    document.getElementById('phoneHidden').value = '254' + local;
});

function showRecordingInfo() {
  const modal = document.getElementById('recording-modal');
  modal.style.display = 'flex';
  // Prevent body scroll while modal is open
  document.body.style.overflow = 'hidden';
}

function closeRecordingInfo() {
  document.getElementById('recording-modal').style.display = 'none';
  document.body.style.overflow = '';
}

// Close on backdrop click
document.getElementById('recording-modal').addEventListener('click', function(e) {
  if (e.target === this) closeRecordingInfo();
});

// Close on Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeRecordingInfo();
});
</script>
@endpush