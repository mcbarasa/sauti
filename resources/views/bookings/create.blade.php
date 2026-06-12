@extends('layouts.app')
@section('title', 'Book a Session')
<style>
#pay{
  color: brown;
}
</style>
@section('content')
<section id="booking" style="padding-top:8rem;">
  <div class="container">
    <div class="reveal">
      <p class="section-label">Book Online</p>
      <h2 class="section-title">Reserve Your<br>Studio Session</h2>
      <p class="section-sub">Pick a date, choose your room and time slot. We'll confirm via WhatsApp.</p>
    </div>

    <div class="booking-wrap reveal">
      <!-- Studio info -->
      <div class="booking-info">
        <h3>Studio Hours</h3>
        <p>Book in advance to secure your preferred slot. All rooms include basic backline.</p>
        <ul class="hours-list">
          <li>Monday – Friday <span>7:00 AM – 10:00 PM</span></li>
          <li>Saturday <span>8:00 AM – 11:00 PM</span></li>
          <li>Sunday <span>02:00 PM – 09:00 PM</span></li>
          <li>Night Shift          <span>Can contact us and will let you know</span></li>
        </ul>
        <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--hours-border);">
          <h3 style="font-size:1.4rem;margin-bottom:0.75rem;">Rates</h3>
          <ul class="hours-list">
            <li>Rehearsal Room (2hr block) <span>KES 700</span></li>
            <li>Recording Suite (per hour) <span>KES 1,000</span></li>
            <li>Full Day Hire <span>KES 8,000</span></li>
            <li>Monthly Package <span>Custom</span></li>
            <li>Payment:<span id="pay">   The amount listed below is the deposit and we recommend clearing the balance after your session</span></li>
          </ul>
        </div>
        <div style="margin-top:2rem;">
          <a href="{{ route('home') }}" class="btn-secondary" style="padding:0.6rem 1.4rem;font-size:0.8rem;">← Back to Home</a>
        </div>
      </div>

      <!-- Booking form -->
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
              <input type="text" id="selectedDateDisplay" placeholder="Click a date above" readonly style="cursor:default;"
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
              <label>Duration</label>
              <select name="duration">
                @foreach($durations as $value => $label)
                  <option value="{{ $value }}" {{ old('duration', '1') == $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
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
          <div class="form-group" style="margin-top:0.5rem;">
    <label>Deposited Amount (KES)</label>
    <input type="text" id="amountDisplay" readonly
        style="cursor:default; color:var(--yellow); font-weight:700; font-size:1.05rem;"
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
    <button type="button" onclick="previewRecurring()"
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

<input type="hidden" name="is_recurring" id="isRecurringInput" value="0">

          <div class="form-group">
            <label>Notes (optional)</label>
            <textarea name="notes" placeholder="Equipment needs, band members, genre...">{{ old('notes') }}</textarea>
          </div>

          <div class="slot-notice" id="slotNotice"></div>
          <button type="submit" id="submitBtn" class="btn-primary" style="width:100%;">Confirm Booking</button>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
const bookedSlots = @json(json_decode($bookedSlotsJson, true));
let calYear, calMonth, selectedDate;

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
function renderCalendar() {
  const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
  document.getElementById('calMonthYear').textContent = `${months[calMonth]} ${calYear}`;
  const grid = document.getElementById('calGrid'); grid.innerHTML = '';
  ['Su','Mo','Tu','We','Th','Fr','Sa'].forEach(d => { const el = document.createElement('div'); el.className = 'cal-day-name'; el.textContent = d; grid.appendChild(el); });
  const firstDay = new Date(calYear, calMonth, 1).getDay();
  const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
  const today = new Date();
  for (let i = 0; i < firstDay; i++) { const el = document.createElement('div'); el.className = 'cal-day empty'; grid.appendChild(el); }
  for (let d = 1; d <= daysInMonth; d++) {
    const el = document.createElement('div'); el.className = 'cal-day'; el.textContent = d;
    const thisDate = new Date(calYear, calMonth, d);
    if (thisDate < new Date(today.getFullYear(), today.getMonth(), today.getDate())) el.classList.add('past');
    const key = `${calYear}-${calMonth}-${d}`;
    if (Array.isArray(bookedSlots[key]) && bookedSlots[key].length >= 3) el.classList.add('booked');
    if (selectedDate && selectedDate.d === d && selectedDate.m === calMonth && selectedDate.y === calYear) el.classList.add('selected');
    if (d === today.getDate() && calMonth === today.getMonth() && calYear === today.getFullYear() && !(selectedDate && selectedDate.d === d)) el.classList.add('today');
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

  filterTimeSlots(dateStr);
  renderCalendar();
  checkClash();
}
function checkClash() {
  if (!selectedDate) return;
  const key = `${selectedDate.y}-${selectedDate.m}-${selectedDate.d}`;
  const room = document.getElementById('roomSelect').value;
  const time = document.getElementById('startTime').value;
  const notice = document.getElementById('slotNotice');
  if (!room || !time) { notice.classList.remove('show'); return; }
  if (bookedSlots[`${key}-${room}-${time}`]) { notice.textContent = '⚠ That slot is already booked. Please choose a different time or room.'; notice.classList.add('show'); }
  else { notice.classList.remove('show'); }
}
document.getElementById('prevMonth').onclick = async () => { calMonth--; if (calMonth < 0) { calMonth = 11; calYear--; } const res = await fetch(`/api/slots?year=${calYear}&month=${calMonth+1}`); const d = await res.json(); Object.assign(bookedSlots, d); renderCalendar(); };
document.getElementById('nextMonth').onclick = async () => { calMonth++; if (calMonth > 11) { calMonth = 0; calYear++; } const res = await fetch(`/api/slots?year=${calYear}&month=${calMonth+1}`); const d = await res.json(); Object.assign(bookedSlots, d); renderCalendar(); };

// When room changes, re-filter time slots
document.getElementById('roomSelect').onchange = () => {
  const dateStr = document.getElementById('bookingDateInput').value;
  if (dateStr) filterTimeSlots(dateStr);
};

document.getElementById('startTime').onchange = checkClash;
initCalendar();

// Debug — paste in console after selecting date + room
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
};


// ── Auto-compute amount ──────────────────────────────────────────────
const rates = { '1': 350, '2': 700, '3': 1050, '4': 1400, 'full': 4000 };

function computeAmount() {
    const duration = document.querySelector('select[name="duration"]').value;
    const amount   = rates[duration] ?? 0;
    document.getElementById('amountDisplay').value =
        amount ? 'KES ' + amount.toLocaleString() : '';
    document.getElementById('amountInput').value = amount;
}

document.querySelector('select[name="duration"]').addEventListener('change', computeAmount);

// Compute on load if old() value exists
computeAmount();

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

  // Build key — match PHP format: YYYY-M-D (no leading zeros, 1-indexed month)
  const parts    = selectedDateStr.split('-');
  const slotYear = parseInt(parts[0]);
  const slotMon  = parseInt(parts[1]);     // ← 1-indexed, no change
  const slotDay  = parseInt(parts[2]);     // ← no leading zeros
  const dateKey  = `${slotYear}-${slotMon}-${slotDay}`;

  const room = document.getElementById('roomSelect').value;

    // ── Sunday restricted hours: 14:00 – 20:00 only (last start = 20:00 if 1hr) ──
  const dateObj  = new Date(slotYear, slotMon - 1, slotDay);
  const isSunday = dateObj.getDay() === 0;

  if (hint) hint.style.display = isToday ? 'block' : 'none';

options.forEach(opt => {
    if (!opt.value) return;

    const slotHour = parseInt(opt.value.split(':')[0], 10);

    // ── Sunday: only 14:00–21:00 allowed, others hidden completely ──
    if (isSunday && (slotHour < 14 || slotHour > 21)) {
      opt.style.display = 'none';
      opt.disabled       = true;
      return;
    } else {
      opt.style.display = '';
    }

    // Key format: "2026-5-24-room-a-09:00"
    const slotKey  = `${dateKey}-${room}-${opt.value.substring(0, 5)}`;
    const isPast   = isToday && slotHour <= currentHr;
    const isBooked = room && bookedSlots[slotKey];

    if (isPast) {
      opt.disabled         = true;
      opt.style.color      = '#555';
      opt.style.background = '#1a1a1a';
      opt.textContent      = opt.value.substring(0, 5) + ' — passed';
    } else if (isBooked) {
      opt.disabled         = true;
      opt.style.color      = '#E55A5A';
      opt.style.background = 'rgba(229,90,90,0.08)';
      opt.textContent      = opt.value.substring(0, 5) + ' — booked';
    } else {
      opt.disabled         = false;
      opt.style.color      = '';
      opt.style.background = '';
      opt.textContent      = opt.value.substring(0, 5);
    }
  });

  // Reset if selected slot is now disabled
  if (select.value && select.options[select.selectedIndex]?.disabled) {
    select.value = '';
  }
}

// ── Check for slot clash (now silent — slots are already grayed) ──────
function checkClash() {
  if (!selectedDate) return;

  // Re-run filterTimeSlots whenever room or date changes
  // so booked slots update based on room selection
  const dateStr = document.getElementById('bookingDateInput').value;
  if (dateStr) filterTimeSlots(dateStr);

  // Hide the notice — slots are visually blocked instead
  const notice = document.getElementById('slotNotice');
  if (notice) notice.classList.remove('show');
}

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
  const duration  = document.querySelector('select[name="duration"]').value;
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
</script>
@endpush
