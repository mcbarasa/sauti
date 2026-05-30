@extends('layouts.app')
@section('title', 'Admin — Sauti Gang Studio')

@section('content')
<style>
/* ── Admin wrap ── */
.admin-wrap { padding:6rem 0 4rem; min-height:100vh; }

/* ── Top nav bar ── */
.admin-topbar {
  display:flex; align-items:center; justify-content:space-between;
  margin-bottom:2rem; flex-wrap:wrap; gap:1rem;
  padding-bottom:1.5rem; border-bottom:1px solid var(--border);
}
.admin-topbar-right {
  display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap;
}

/* ── Tabs ── */
.admin-tabs {
  display:flex; gap:4px; background:var(--surface2);
  border:1px solid var(--border); border-radius:4px; padding:3px;
  flex-wrap:wrap; margin-bottom:1.5rem;
}
.admin-tab {
  padding:0.4rem 1rem; border-radius:3px; font-size:0.8rem;
  cursor:pointer; color:var(--gray); border:none; background:none;
  font-family:'DM Sans',sans-serif; font-weight:500; transition:all 0.15s;
  display:flex; align-items:center; gap:5px;
}
.admin-tab:hover { color:var(--text); background:var(--surface3); }
.admin-tab.active { background:var(--yellow); color:#0A0A0A; font-weight:700; }
.admin-tab .tab-badge {
  background:#0A0A0A; color:var(--yellow); font-size:0.62rem;
  font-weight:700; padding:1px 5px; border-radius:10px;
}
.admin-tab.active .tab-badge { background:rgba(0,0,0,0.25); color:#0A0A0A; }

/* ── Tab pages ── */
.tab-page { display:none; }
.tab-page.active { display:block; }

/* ── Filters ── */
.admin-filters {
  display:flex; gap:0.75rem; margin-bottom:1.5rem;
  flex-wrap:wrap; align-items:flex-end;
}
.admin-filter-actions {
  display:flex; gap:0.5rem; align-items:flex-end;
}

/* ── Table wrapper ── */
.table-scroll-wrap {
  overflow-x:auto; border:1px solid var(--border); border-radius:4px;
  -webkit-overflow-scrolling:touch;
}

/* ── Admin table ── */
.admin-table { width:100%; border-collapse:collapse; font-size:0.88rem; min-width:900px; }
.admin-table th {
  background:var(--surface2); color:var(--gray); font-size:0.7rem;
  letter-spacing:2px; text-transform:uppercase; padding:0.75rem 1rem;
  text-align:left; border-bottom:1px solid var(--border-y); white-space:nowrap;
}
.admin-table td {
  padding:0.75rem 1rem; border-bottom:1px solid var(--border);
  color:var(--text2); vertical-align:middle;
}
.admin-table tr:hover td { background:var(--surface2); }

/* ── Status pills ── */
.status-pill {
  display:inline-block; padding:2px 10px; border-radius:20px;
  font-size:0.68rem; font-weight:700; letter-spacing:1px; text-transform:uppercase;
  white-space:nowrap;
}
.status-pending   { background:rgba(245,197,24,0.12); color:var(--yellow); }
.status-confirmed { background:rgba(52,199,123,0.12); color:#34C77B; }
.status-cancelled { background:rgba(229,90,90,0.1);   color:#E55A5A; }
.status-lapsed    { background:rgba(100,100,100,0.15); color:#888; }
.status-completed { background:rgba(90,158,229,0.12); color:#5A9EE5; }

/* ── Pagination ── */
.pagination-wrap {
  display:flex; align-items:center; justify-content:space-between;
  margin-top:1.25rem; flex-wrap:wrap; gap:0.75rem;
}
.pagination-info { font-size:0.78rem; color:var(--gray); }
.pagination-pages { display:flex; gap:0.35rem; flex-wrap:wrap; align-items:center; }
.pag-btn {
  padding:0.4rem 0.85rem; background:var(--surface2);
  border:1px solid var(--border); border-radius:4px;
  color:var(--text2); font-size:0.8rem; text-decoration:none;
  display:inline-block; transition:border-color 0.2s,color 0.2s;
}
.pag-btn:hover { border-color:var(--yellow); color:var(--yellow); }
.pag-btn.current { background:var(--yellow); border-color:var(--yellow); color:#0A0A0A; font-weight:700; }
.pag-btn.disabled { opacity:0.4; pointer-events:none; }
.pag-ellipsis { color:var(--gray); font-size:0.8rem; padding:0 0.2rem; }

/* ── Flash messages ── */
.flash-success {
  background:rgba(52,199,123,0.1); border:1px solid rgba(52,199,123,0.3);
  color:#34C77B; border-radius:4px; padding:0.75rem 1rem;
  margin-bottom:1.5rem; font-size:0.88rem;
}

/* ── Session timer cards ── */
@keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:0.3} }
@keyframes overtime-pulse { 0%,100%{border-color:rgba(229,90,90,0.3)} 50%{border-color:rgba(229,90,90,0.9)} }

.session-card {
  background:var(--surface2); border:1px solid var(--border);
  border-radius:6px; padding:1.2rem; position:relative; overflow:hidden;
  transition:border-color 0.3s;
}
.session-card.upcoming { border-color:rgba(245,197,24,0.35); }
.session-card.active   { border-color:rgba(52,199,123,0.4); }
.session-card.overtime { border-color:rgba(229,90,90,0.5); animation:overtime-pulse 1.5s infinite; }
.session-card.lapsed   { border-color:var(--border); opacity:0.65; }

.timer-display {
  font-family:'DM Mono',monospace; font-size:2rem; font-weight:700;
  letter-spacing:3px; text-align:center; padding:0.75rem 0.5rem;
  border-radius:5px; margin:0.75rem 0;
}
.timer-display.upcoming { background:rgba(245,197,24,0.08); color:var(--yellow); }
.timer-display.active   { background:rgba(52,199,123,0.08); color:#34C77B; }
.timer-display.overtime { background:rgba(229,90,90,0.1);   color:#E55A5A; }
.timer-display.lapsed   { background:var(--surface3);       color:#666; }

.progress-track { height:5px; background:var(--surface3); border-radius:3px; overflow:hidden; margin:0.5rem 0; }
.progress-fill  { height:100%; border-radius:3px; transition:width 1s linear; }

.overtime-badge {
  background:rgba(229,90,90,0.1); border:1px solid rgba(229,90,90,0.3);
  color:#E55A5A; border-radius:4px; padding:0.5rem 0.75rem;
  font-size:0.8rem; text-align:center; margin-top:0.5rem;
}

.live-dot {
  width:8px; height:8px; border-radius:50%; background:#34C77B;
  display:inline-block; animation:pulse-dot 1.4s infinite;
}

/* ── Summary count pills ── */
.count-pill {
  background:var(--surface2); border:1px solid var(--border);
  border-radius:4px; padding:0.45rem 0.9rem; font-size:0.82rem;
  display:flex; align-items:center; gap:0.4rem;
  transition:all 0.15s; user-select:none;
}
.count-pill:hover { border-color:var(--yellow); transform:translateY(-1px); }
.count-pill.active-filter                        { border-color:var(--yellow); background:rgba(245,197,24,0.1); }
.count-pill.active-filter[data-filter="active"]  { border-color:#34C77B; background:rgba(52,199,123,0.1); }
.count-pill.active-filter[data-filter="overtime"]{ border-color:#E55A5A; background:rgba(229,90,90,0.1); }
.count-pill.active-filter[data-filter="lapsed"]  { border-color:#888; background:rgba(100,100,100,0.1); }

.session-card.hidden { display:none; }

/* ── Sessions header ── */
.sessions-header {
  display:flex; align-items:center; justify-content:space-between;
  margin-bottom:1.25rem; flex-wrap:wrap; gap:0.75rem;
}
.sessions-live-label {
  display:flex; align-items:center; gap:0.5rem;
  font-size:0.78rem; color:#34C77B;
}

/* ── Session grid ── */
#session-grid {
  display:grid;
  grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));
  gap:1rem;
}

/* ── Filter pills row ── */
#filter-pills {
  display:flex; gap:0.6rem; margin-bottom:1.25rem; flex-wrap:wrap;
}

/* ══════════════════════════════
   RESPONSIVE BREAKPOINTS
   Only layout changes; zero
   functionality altered.
══════════════════════════════ */

/* Tablets ≤ 768px */
@media (max-width: 768px) {
  .admin-wrap { padding:5rem 0 3rem; }

  .admin-topbar { gap:0.75rem; }
  .admin-topbar-right { width:100%; justify-content:flex-start; }

  .admin-tabs { width:100%; }
  .admin-tab  { flex:1; justify-content:center; font-size:0.75rem; padding:0.4rem 0.6rem; }

  .admin-filters { gap:0.6rem; }
  .admin-filters .form-group { min-width:calc(50% - 0.3rem) !important; flex:1 1 calc(50% - 0.3rem); }
  .admin-filter-actions { width:100%; }
  .admin-filter-actions .btn-primary,
  .admin-filter-actions .btn-secondary { flex:1; text-align:center; padding:0.55rem 0.5rem; }

  /* Table: scrollable on small screens */
  .admin-table { min-width:700px; font-size:0.82rem; }
  .admin-table th,
  .admin-table td { padding:0.6rem 0.75rem; }

  /* Pagination info stacks */
  .pagination-wrap { flex-direction:column; align-items:flex-start; gap:0.5rem; }

  /* Session grid single column */
  #session-grid { grid-template-columns:1fr; }

  .sessions-header { flex-direction:column; align-items:flex-start; }

  .timer-display { font-size:1.6rem; letter-spacing:2px; }

  /* Count pills wrap freely */
  #filter-pills { gap:0.4rem; }
  .count-pill { font-size:0.76rem; padding:0.4rem 0.7rem; }
}

/* Phones ≤ 480px */
@media (max-width: 480px) {
  .admin-wrap { padding:5rem 0 2rem; }

  .admin-topbar { flex-direction:column; align-items:flex-start; }
  .admin-topbar-right { flex-wrap:wrap; gap:0.5rem; }
  .admin-topbar-right .btn-primary,
  .admin-topbar-right .btn-danger { flex:1; text-align:center; justify-content:center; font-size:0.8rem; }

  .admin-tabs { flex-direction:column; }
  .admin-tab  { width:100%; font-size:0.8rem; }

  .admin-filters .form-group { min-width:100% !important; flex:1 1 100%; }

  /* Make table fully scrollable */
  .admin-table { min-width:600px; font-size:0.78rem; }
  .admin-table th,
  .admin-table td { padding:0.5rem 0.6rem; }

  /* Notes column hide on tiny screens */
  .admin-table th.col-notes,
  .admin-table td.col-notes { display:none; }

  .pagination-pages { gap:0.25rem; }
  .pag-btn { padding:0.35rem 0.6rem; font-size:0.75rem; }

  .count-pill { font-size:0.72rem; padding:0.35rem 0.6rem; }
  .timer-display { font-size:1.4rem; letter-spacing:1px; }
}

/* Very small ≤ 360px */
@media (max-width: 360px) {
  .admin-table { min-width:520px; }
  #session-grid { gap:0.75rem; }
}
</style>

<div class="admin-wrap">
  <div class="container">

    {{-- ── Top Header ── --}}
    <div class="admin-topbar">
      <div>
        <p class="section-label">Admin Panel</p>
        <h2 class="section-title" style="font-size:2.2rem;margin:0;">
          Sauti Gang Studio
        </h2>
      </div>

      <div class="admin-topbar-right">
        <a href="{{ route('bookings.create') }}" class="btn-primary" style="font-size:0.85rem;padding:0.55rem 1.2rem;">
          + New Booking
        </a>
        <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
          @csrf
          <button type="submit" class="btn-danger"
            style="padding:0.55rem 1.1rem;font-size:0.85rem;display:flex;align-items:center;gap:0.4rem;cursor:pointer;">
            🔒 Sign Out
          </button>
        </form>
        <span style="font-size:0.78rem;color:var(--gray);white-space:nowrap;">
          {{ Auth::user()->name }}
        </span>
      </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
      <div class="flash-success">✓ {{ session('success') }}</div>
    @endif

    {{-- ── Tab Navigation ── --}}
    <div class="admin-tabs">
      <button class="admin-tab active" onclick="switchTab('bookings', this)">
        Bookings
        @php $pendingCount = $bookings->where('status','pending')->count(); @endphp
        @if($pendingCount > 0)
          <span class="tab-badge">{{ $pendingCount }}</span>
        @endif
      </button>
      <button class="admin-tab" onclick="switchTab('sessions', this)" id="tab-sessions">
        ⏱ Live Sessions
        <span class="tab-badge" id="live-badge" style="display:none;">0</span>
      </button>
    </div>

    {{-- ════════════════════════════════════════════
         TAB 1: BOOKINGS
    ════════════════════════════════════════════ --}}
    <div class="tab-page active" id="tab-page-bookings">

      {{-- Filters --}}
      <form method="GET" action="{{ route('bookings.admin') }}" class="admin-filters">
        <div class="form-group" style="margin:0;min-width:170px;">
          <label>Date</label>
          <input type="date" name="date" value="{{ request('date') }}"
            style="background:var(--input-bg);border:1px solid var(--border-y);border-radius:3px;padding:0.55rem 0.9rem;color:var(--text);font-family:'DM Sans',sans-serif;font-size:0.88rem;outline:none;" />
        </div>
        <div class="form-group" style="margin:0;min-width:190px;">
          <label>Room</label>
          <select name="room"
            style="background:var(--input-bg);border:1px solid var(--border-y);border-radius:3px;padding:0.55rem 0.9rem;color:var(--text);font-family:'DM Sans',sans-serif;font-size:0.88rem;outline:none;width:100%;">
            <option value="">All Rooms</option>
            @foreach($rooms as $value => $label)
              <option value="{{ $value }}" {{ request('room') == $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group" style="margin:0;min-width:160px;">
          <label>Status</label>
          <select name="status"
            style="background:var(--input-bg);border:1px solid var(--border-y);border-radius:3px;padding:0.55rem 0.9rem;color:var(--text);font-family:'DM Sans',sans-serif;font-size:0.88rem;outline:none;width:100%;">
            <option value="">All Statuses</option>
            <option value="pending"   {{ request('status')=='pending'   ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
            <option value="lapsed"    {{ request('status')=='lapsed'    ? 'selected' : '' }}>Lapsed</option>
          </select>
        </div>
        <div class="form-group" style="margin:0;min-width:150px;">
  <label>Type</label>
  <select name="type" class="filter-input" style="width:100%;">
    <option value="">All Types</option>
    <option value="recurring" {{ request('type')=='recurring' ? 'selected':'' }}>Recurring</option>
    <option value="oneoff"    {{ request('type')=='oneoff'    ? 'selected':'' }}>One-off</option>
  </select>
</div>
        <div class="admin-filter-actions">
          <button type="submit" class="btn-primary" style="padding:0.55rem 1.2rem;font-size:0.82rem;">Filter</button>
          <a href="{{ route('bookings.admin') }}" class="btn-secondary" style="padding:0.55rem 1.2rem;font-size:0.82rem;">Clear</a>
        </div>
      </form>

      {{-- Table --}}
      @if($bookings->isEmpty())
        <div style="text-align:center;padding:4rem 2rem;color:var(--gray);">
          <p style="font-size:2rem;margin-bottom:0.5rem;">📭</p>
          <p>No bookings found.</p>
        </div>
      @else
        <div class="table-scroll-wrap">
          <table class="admin-table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Room</th>
                <th>Time</th>
                <th>Duration</th>
                <th>Amount</th>
                <th class="col-notes">Notes</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($bookings as $booking)
              <tr>
                <td style="color:var(--gray);font-size:0.8rem;font-family:monospace;">
                  #{{ str_pad($booking->id, 3, '0', STR_PAD_LEFT) }}
                </td>
                <td style="font-weight:600;color:var(--text);">{{ $booking->name }}
                   @if($booking->is_recurring)
    <span style="background:rgba(90,158,229,0.12);color:#5A9EE5;
                 border-radius:20px;padding:1px 7px;font-size:0.62rem;
                 font-weight:700;letter-spacing:1px;margin-left:4px;">
      🔁 recurring
    </span>
  @endif
                </td>
                <td style="font-family:monospace;">{{ $booking->phone }}</td>
                <td>{{ $booking->formatted_date }}</td>
                <td style="font-size:0.82rem;">{{ $booking->room_label }}</td>
                <td style="font-family:monospace;">{{ substr($booking->start_time, 0, 5) }}</td>
                <td>{{ $booking->duration_label }}</td>
                <td style="color:var(--yellow);font-weight:600;">{{ $booking->formatted_amount }}</td>
                <td class="col-notes"
                    style="font-size:0.8rem;max-width:150px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                    title="{{ $booking->notes }}">{{ $booking->notes ?: '—' }}</td>
                <td>
                  <span class="status-pill status-{{ $booking->status }}">
                    {{ ucfirst($booking->status) }}
                  </span>
                </td>
                <td style="white-space:nowrap;">
                  <div style="display:flex;gap:0.4rem;align-items:center;flex-wrap:wrap;">

                    <a href="{{ route('bookings.show', $booking) }}"
                       class="btn-secondary" style="padding:0.3rem 0.8rem;font-size:0.72rem;">
                      View
                    </a>

                    @if($booking->status === 'pending')
                    <form action="{{ route('bookings.confirm', $booking) }}" method="POST" style="display:inline;">
                      @csrf @method('PATCH')
                      <button type="submit" class="btn-primary"
                        style="padding:0.3rem 0.8rem;font-size:0.72rem;">Confirm</button>
                    </form>
                    @endif

                    @if(!in_array($booking->status, ['cancelled','lapsed']))
                    <form action="{{ route('bookings.destroy', $booking) }}" method="POST"
                          style="display:inline;"
                          onsubmit="return confirm('Cancel booking #{{ $booking->id }} for {{ $booking->name }}?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn-danger">Cancel</button>
                    </form>
                    @endif

                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        {{-- Pagination --}}
        @if($bookings->hasPages())
          <div class="pagination-wrap">

            <p class="pagination-info">
              Showing <b style="color:var(--text);">{{ $bookings->firstItem() }}</b>
              to <b style="color:var(--text);">{{ $bookings->lastItem() }}</b>
              of <b style="color:var(--text);">{{ $bookings->total() }}</b> bookings
            </p>

            <div class="pagination-pages">

              {{-- Previous --}}
              @if($bookings->onFirstPage())
                <span class="pag-btn disabled">← Prev</span>
              @else
                <a class="pag-btn" href="{{ $bookings->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}">← Prev</a>
              @endif

              {{-- Page numbers --}}
              @foreach($bookings->getUrlRange(1, $bookings->lastPage()) as $page => $url)
                @if($page == $bookings->currentPage())
                  <span class="pag-btn current">{{ $page }}</span>
                @elseif($page == 1 || $page == $bookings->lastPage() || abs($page - $bookings->currentPage()) <= 2)
                  <a class="pag-btn" href="{{ $url }}&{{ http_build_query(request()->except('page')) }}">{{ $page }}</a>
                @elseif(abs($page - $bookings->currentPage()) == 3)
                  <span class="pag-ellipsis">…</span>
                @endif
              @endforeach

              {{-- Next --}}
              @if($bookings->hasMorePages())
                <a class="pag-btn" href="{{ $bookings->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}">Next →</a>
              @else
                <span class="pag-btn disabled">Next →</span>
              @endif

            </div>
          </div>
        @endif
      @endif
    </div>{{-- /tab-page-bookings --}}

    {{-- ════════════════════════════════════════════
         TAB 2: LIVE SESSIONS
    ════════════════════════════════════════════ --}}
    <div class="tab-page" id="tab-page-sessions">

      {{-- Header --}}
      <div class="sessions-header">
        <p style="color:var(--gray);font-size:0.85rem;">
          Today's confirmed bookings with live countdown timers.
          Overtime costs accrue at <strong style="color:var(--yellow);">KES 1,000/hr</strong>.
        </p>
        <div class="sessions-live-label">
          <span class="live-dot"></span> Live — updates every second
        </div>
      </div>

      {{-- Summary counts --}}
      <div id="filter-pills">
        <div class="count-pill active-filter" data-filter="upcoming"
             onclick="filterSessions('upcoming', this)" style="cursor:pointer;">
          ⏳ Upcoming: <b id="cnt-upcoming" style="color:var(--yellow);">0</b>
        </div>
        <div class="count-pill" data-filter="active"
             onclick="filterSessions('active', this)" style="cursor:pointer;">
          🟢 Active: <b id="cnt-active" style="color:#34C77B;">0</b>
        </div>
        <div class="count-pill" data-filter="overtime"
             onclick="filterSessions('overtime', this)" style="cursor:pointer;">
          🔴 Overtime: <b id="cnt-overtime" style="color:#E55A5A;">0</b>
        </div>
        <div class="count-pill" data-filter="lapsed"
             onclick="filterSessions('lapsed', this)" style="cursor:pointer;">
          ⚫ Lapsed: <b id="cnt-lapsed" style="color:#888;">0</b>
        </div>
      </div>

      {{-- Session cards --}}
      <div id="session-grid">
        <div style="color:var(--gray);padding:3rem;text-align:center;grid-column:1/-1;font-size:0.9rem;">
          Loading sessions…
        </div>
      </div>

    </div>{{-- /tab-page-sessions --}}

  </div>
</div>

<script>
// ══════════════════════════════════════════════
// TAB SWITCHER
// ══════════════════════════════════════════════
function switchTab(name, btn) {
  document.querySelectorAll('.tab-page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.admin-tab').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-page-' + name).classList.add('active');
  btn.classList.add('active');

  if (name === 'sessions') {
    window._fetchedAt = Date.now() / 1000;
    fetchSessions();
    startTimers();
  } else {
    stopTimers();
  }
}

// ══════════════════════════════════════════════
// TIMER ENGINE
// ══════════════════════════════════════════════
let sessionData   = [];
let _timerTick    = null;
let _fetchLoop    = null;
const RATE_PER_MIN = 1250 / 60;

function startTimers() {
  if (_timerTick) return;
  _timerTick  = setInterval(tickAll, 1000);
  _fetchLoop  = setInterval(() => {
    window._fetchedAt = Date.now() / 1000;
    fetchSessions();
  }, 60000);
}

function stopTimers() {
  clearInterval(_timerTick);
  clearInterval(_fetchLoop);
  _timerTick = null;
  _fetchLoop = null;
}

async function fetchSessions() {
  try {
    const res  = await fetch('/api/live-timers');
    sessionData = await res.json();
    buildCards();
  } catch(e) {
    console.error('Session fetch failed', e);
  }
}

function fmt(secs) {
  const a = Math.abs(Math.floor(secs));
  const h = Math.floor(a / 3600);
  const m = Math.floor((a % 3600) / 60);
  const s = a % 60;
  return `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
}

function getTiming(b) {
  const drift      = (Date.now() / 1000) - (window._fetchedAt || Date.now()/1000);
  const toStart    = b.seconds_to_start - drift;
  const toEnd      = b.seconds_to_end   - drift;

  if (toStart > 0) {
    return { state:'upcoming', label:'Upcoming', timerLabel:'Starts in',
             display: toStart, pct: 0, oMin: 0, oCost: 0 };
  }
  if (toEnd > 0) {
    const elapsed  = Math.abs(toStart);
    const total    = elapsed + toEnd;
    return { state:'active', label:'Live ●', timerLabel:'Time remaining',
             display: toEnd, pct: Math.min(100,(elapsed/total)*100), oMin: 0, oCost: 0 };
  }

  const oSecs = Math.abs(toEnd);
  const oMin  = Math.floor(oSecs / 60);
  const oCost = oMin * RATE_PER_MIN;

  if (b.status === 'lapsed') {
    return { state:'lapsed', label:'Lapsed', timerLabel:'Ended',
             display: oSecs, pct: 100, oMin, oCost };
  }
  return { state:'overtime', label:'Overtime', timerLabel:'Over by',
           display: oSecs, pct: 100, oMin, oCost };
}

function buildCards() {
  const grid = document.getElementById('session-grid');
  if (!sessionData.length) {
    grid.innerHTML = '<div style="color:var(--gray);padding:3rem;text-align:center;grid-column:1/-1;">No sessions scheduled.</div>';
    updateCounts({upcoming:0,active:0,overtime:0,lapsed:0,completed:0});
    return;
  }

  grid.innerHTML = sessionData.map(b => {
    const t = getTiming(b);

    const canCheckout = (t.state === 'active' || t.state === 'overtime');
    const checkoutBtn = canCheckout ? `
      <button onclick="checkoutSession(${b.id}, this)"
        style="width:100%;margin-top:0.75rem;padding:0.6rem;border-radius:4px;
               border:none;cursor:pointer;font-family:'DM Sans',sans-serif;
               font-size:0.85rem;font-weight:700;letter-spacing:1px;
               background:${t.state === 'overtime' ? '#E55A5A' : '#34C77B'};
               color:#fff;display:flex;align-items:center;justify-content:center;gap:0.5rem;"
        id="checkout-btn-${b.id}">
        ${t.state === 'overtime' ? '🔴 Check Out (Overtime)' : '✅ Check Out'}
      </button>` : '';

    const completedBadge = b.status === 'completed' ? `
      <div style="background:rgba(90,158,229,0.1);border:1px solid rgba(90,158,229,0.3);
                  color:#5A9EE5;border-radius:4px;padding:0.5rem;text-align:center;
                  font-size:0.82rem;margin-top:0.75rem;">
        ✓ Checked out at ${b.checked_out_at || '—'}
      </div>` : '';

    return `
    <div class="session-card ${t.state}" id="sc-${b.id}">

      <div style="position:absolute;top:0.8rem;right:0.8rem;">
        <span class="status-pill status-${
          t.state === 'upcoming'  ? 'pending'   :
          t.state === 'active'   ? 'confirmed'  :
          t.state === 'overtime' ? 'cancelled'  :
          t.state === 'completed'? 'completed'  : 'lapsed'
        }">${t.label}</span>
      </div>

      <div style="font-weight:700;font-size:0.95rem;color:var(--text);
                  margin-bottom:0.2rem;padding-right:90px;">
        ${b.name}
      </div>
      <div style="font-size:0.78rem;color:var(--gray);margin-bottom:0.6rem;">
        📍 ${b.room} &nbsp;·&nbsp; ${b.date}
      </div>
      <div style="display:flex;justify-content:space-between;
                  font-size:0.75rem;color:var(--gray);margin-bottom:0.5rem;">
        <span>🕐 ${b.start_time} – ${b.end_time}</span>
        <span>${b.duration_label}</span>
      </div>

      ${t.state === 'active' ? `
        <div class="progress-track">
          <div class="progress-fill" id="pf-${b.id}"
               style="width:${t.pct}%;background:#34C77B;"></div>
        </div>` : ''}

      <div class="timer-display ${t.state}" id="td-${b.id}">
        ${fmt(t.display)}
      </div>

      <div style="text-align:center;font-size:0.7rem;color:var(--gray);
                  letter-spacing:1.5px;text-transform:uppercase;margin-top:-0.3rem;">
        ${t.timerLabel}
      </div>

      ${(t.state === 'overtime' || t.state === 'lapsed') ? `
        <div class="overtime-badge" id="ob-${b.id}">
          ⚠ Overtime: <b>KES ${Math.round(t.oCost).toLocaleString()}</b>
          &nbsp;·&nbsp; ${t.oMin} min over
        </div>` : ''}

      ${checkoutBtn}
      ${completedBadge}

      <div style="display:flex;justify-content:space-between;margin-top:0.9rem;
                  padding-top:0.75rem;border-top:1px solid var(--border);
                  font-size:0.75rem;color:var(--gray);">
        <span>#${String(b.id).padStart(3,'0')}</span>
        <span style="color:var(--yellow);font-weight:600;">
          KES ${Number(b.amount).toLocaleString()}
        </span>
      </div>
    </div>`;
  }).join('');

  tickAll();
}

async function checkoutSession(bookingId, btn) {
  const booking = sessionData.find(b => b.id === bookingId);
  const t       = getTiming(booking);

  const confirmed = await showCheckoutConfirm(booking, t);
  if (!confirmed) return;

  btn.disabled    = true;
  btn.textContent = 'Checking out…';

  try {
    const res = await fetch(`/admin/bookings/${bookingId}/checkout`, {
      method: 'PATCH',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept':       'application/json',
        'Content-Type': 'application/json',
      },
    });

    const data = await res.json();

    if (data.success) {
      // ── On-time checkout ────────────────────────────────────────
      showCheckoutResult(data);
      applyLapsedToCard(bookingId, data, btn);
      sessionData = sessionData.map(b =>
        b.id === bookingId ? { ...b, status: 'lapsed' } : b
      );

    } else if (data.requires_payment) {
      // ── Overtime — show styled payment modal, NOT alert() ───────
      showOvertimePaymentPending(data, bookingId, btn, t);

    } else {
      showErrorModal(data.message || 'Checkout failed. Please try again.');
      btn.disabled    = false;
      btn.textContent = t.state === 'overtime' ? '🔴 Check Out (Overtime)' : '✅ Check Out';
    }

  } catch(e) {
    console.error('Checkout error:', e);
    showErrorModal('Network error. Please try again.');
    btn.disabled    = false;
    btn.textContent = t.state === 'overtime' ? '🔴 Check Out (Overtime)' : '✅ Check Out';
  }
}

// ── Apply lapsed state to card ─────────────────────────────────────────
function applyLapsedToCard(bookingId, data, btn) {
  const card = document.getElementById(`sc-${bookingId}`);
  if (!card) return;

  card.className = 'session-card lapsed';

  if (btn && btn.parentNode) {
    btn.outerHTML = `
      <div style="background:rgba(90,158,229,0.1);border:1px solid rgba(90,158,229,0.3);
                  color:#5A9EE5;border-radius:4px;padding:0.5rem;text-align:center;
                  font-size:0.82rem;margin-top:0.75rem;">
        ✓ Checked out at ${data.checked_out_at}
        ${data.was_overtime ? `<br><span style="color:#E55A5A;font-size:0.78rem;">
          Overtime: KES ${Number(data.overtime_cost).toLocaleString()}
          (${data.overtime_minutes} mins)</span>` : ''}
      </div>`;
  }

  const td = document.getElementById(`td-${bookingId}`);
  if (td) {
    td.className        = 'timer-display lapsed';
    td.textContent      = '✓ Done';
    td.style.background = 'var(--surface3)';
    td.style.color      = '#666';
  }

  const pill = card.querySelector('.status-pill');
  if (pill) {
    pill.className   = 'status-pill status-lapsed';
    pill.textContent = 'Lapsed';
  }
}

// ── Overtime payment pending modal ─────────────────────────────────────
function showOvertimePaymentPending(data, bookingId, btn, t) {
  document.getElementById('overtime-payment-modal')?.remove();

  // ── Re-enable the checkout button while modal is open ──────────────
  btn.disabled    = false;
  btn.textContent = '🔴 Check Out (Overtime)';

  const modal = document.createElement('div');
  modal.id    = 'overtime-payment-modal';
  modal.style.cssText = `
    position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:1000;
    display:flex;align-items:center;justify-content:center;padding:1rem;`;

  modal.innerHTML = `
    <div style="background:var(--surface);border:1px solid rgba(229,90,90,0.4);
                border-radius:10px;padding:2rem;max-width:400px;width:100%;text-align:center;">

      <div style="font-size:2.5rem;margin-bottom:0.75rem;">📲</div>

      <h3 style="font-family:'Bebas Neue',sans-serif;font-size:1.6rem;
                 letter-spacing:2px;color:#E55A5A;margin-bottom:0.5rem;">
        Overtime Payment
      </h3>

      <p style="color:var(--gray);font-size:0.85rem;margin-bottom:1.25rem;">
        M-Pesa prompt sent to
        <strong style="color:var(--text);">${data.phone}</strong>
      </p>

      <div style="background:rgba(229,90,90,0.1);border:1px solid rgba(229,90,90,0.3);
                  border-radius:6px;padding:1rem;margin-bottom:1.25rem;">
        <p style="color:#E55A5A;font-size:0.72rem;letter-spacing:1.5px;
                  text-transform:uppercase;margin-bottom:0.35rem;">Amount Due</p>
        <p style="font-size:1.8rem;font-weight:700;color:#E55A5A;
                  font-family:'DM Mono',monospace;margin-bottom:0.2rem;">
          KES ${Number(data.overtime_cost).toLocaleString()}
        </p>
        <p style="color:#888;font-size:0.76rem;">${data.overtime_minutes} min overtime</p>
      </div>

      <div style="display:flex;align-items:center;justify-content:center;
                  gap:0.5rem;margin-bottom:1.5rem;">
        <span class="live-dot"></span>
        <span id="ot-poll-status" style="font-size:0.82rem;color:var(--gray);">
          Waiting for payment…
        </span>
      </div>

      <div style="display:flex;gap:0.75rem;">
        <button id="ot-cancel-btn"
          style="flex:1;padding:0.65rem;border-radius:4px;border:1px solid var(--border);
                 background:transparent;color:var(--text2);font-family:'DM Sans',sans-serif;
                 font-size:0.85rem;font-weight:600;cursor:pointer;">
          Cancel
        </button>
        <button id="ot-manual-btn"
          style="flex:2;padding:0.65rem;border-radius:4px;
                 border:1px solid rgba(245,197,24,0.4);
                 background:rgba(245,197,24,0.1);color:var(--yellow);
                 font-family:'DM Sans',sans-serif;font-size:0.85rem;
                 font-weight:600;cursor:pointer;">
          Mark Paid Manually
        </button>
      </div>
    </div>`;

  document.body.appendChild(modal);

  // ── Shared finalize function used by both poll + manual ────────────
  function finalizeCheckout() {
    modal.remove();

    const now     = new Date();
    const timeStr = now.getHours().toString().padStart(2,'0')   + ':' +
                    now.getMinutes().toString().padStart(2,'0') + ':' +
                    now.getSeconds().toString().padStart(2,'0');

    const resultData = {
      success:          true,
      name:             sessionData.find(b => b.id === bookingId)?.name || '',
      checked_out_at:   timeStr,
      was_overtime:     true,
      overtime_minutes: data.overtime_minutes,
      overtime_cost:    data.overtime_cost,
    };

    // ── Update sessionData FIRST so tickAll stops overwriting the card ─
    sessionData = sessionData.map(b =>
      b.id === bookingId ? { ...b, status: 'lapsed' } : b
    );

    // ── Update the card directly by ID (no stale btn reference) ───────
    const card = document.getElementById(`sc-${bookingId}`);
    if (card) {
      card.className = 'session-card lapsed';

      // Replace checkout button by ID
      const checkoutBtn = document.getElementById(`checkout-btn-${bookingId}`);
      if (checkoutBtn) {
        checkoutBtn.outerHTML = `
          <div style="background:rgba(90,158,229,0.1);border:1px solid rgba(90,158,229,0.3);
                      color:#5A9EE5;border-radius:4px;padding:0.5rem;text-align:center;
                      font-size:0.82rem;margin-top:0.75rem;">
            ✓ Checked out at ${timeStr}
            <br><span style="color:#E55A5A;font-size:0.78rem;">
              Overtime: KES ${Number(data.overtime_cost).toLocaleString()}
              (${data.overtime_minutes} mins)
            </span>
          </div>`;
      }

      // Update timer display
      const td = document.getElementById(`td-${bookingId}`);
      if (td) {
        td.className        = 'timer-display lapsed';
        td.textContent      = '✓ Done';
        td.style.background = 'var(--surface3)';
        td.style.color      = '#666';
      }

      // Update status pill
      const pill = card.querySelector('.status-pill');
      if (pill) {
        pill.className   = 'status-pill status-lapsed';
        pill.textContent = 'Lapsed';
      }
    }

    // ── Show result modal ──────────────────────────────────────────────
    showCheckoutResult(resultData);
  }

  // ── Poll every 5s ──────────────────────────────────────────────────
  let pollCount  = 0;
  const maxPolls = 24;
  const statusEl = document.getElementById('ot-poll-status');

  const poll = setInterval(async () => {
    pollCount++;
    try {
      const res    = await fetch(`/bookings/check-payment?checkout_request_id=${data.checkout_request_id}`, {
        headers: { 'Accept': 'application/json' },
      });
      const result = await res.json();

      if (result.status === 'completed') {
        clearInterval(poll);
        finalizeCheckout();

      } else if (result.status === 'failed') {
        clearInterval(poll);
        statusEl.textContent = '✗ Payment cancelled or failed.';
        statusEl.style.color = '#E55A5A';

      } else if (pollCount >= maxPolls) {
        clearInterval(poll);
        statusEl.textContent = 'Timed out — use "Mark Paid Manually" if payment went through.';
        statusEl.style.color = '#888';
      }
    } catch(e) { console.error('Poll error:', e); }
  }, 5000);

  // ── Manual override ────────────────────────────────────────────────
  document.getElementById('ot-manual-btn').addEventListener('click', () => {
    clearInterval(poll);
    finalizeCheckout();
  });

  // ── Cancel ─────────────────────────────────────────────────────────
  document.getElementById('ot-cancel-btn').addEventListener('click', () => {
    clearInterval(poll);
    modal.remove();
  });
}

// ── Apply lapsed state to card (used for on-time checkouts only) ───────
function applyLapsedToCard(bookingId, data, btn) {
  // Update sessionData first to stop tickAll overwriting the card state
  sessionData = sessionData.map(b =>
    b.id === bookingId ? { ...b, status: 'lapsed' } : b
  );

  const card = document.getElementById(`sc-${bookingId}`);
  if (!card) return;

  card.className = 'session-card lapsed';

  // Use ID-based lookup instead of the passed btn reference
  const checkoutBtn = document.getElementById(`checkout-btn-${bookingId}`);
  if (checkoutBtn) {
    checkoutBtn.outerHTML = `
      <div style="background:rgba(90,158,229,0.1);border:1px solid rgba(90,158,229,0.3);
                  color:#5A9EE5;border-radius:4px;padding:0.5rem;text-align:center;
                  font-size:0.82rem;margin-top:0.75rem;">
        ✓ Checked out at ${data.checked_out_at}
        ${data.was_overtime ? `<br><span style="color:#E55A5A;font-size:0.78rem;">
          Overtime: KES ${Number(data.overtime_cost).toLocaleString()}
          (${data.overtime_minutes} mins)</span>` : ''}
      </div>`;
  }

  const td = document.getElementById(`td-${bookingId}`);
  if (td) {
    td.className        = 'timer-display lapsed';
    td.textContent      = '✓ Done';
    td.style.background = 'var(--surface3)';
    td.style.color      = '#666';
  }

  const pill = card.querySelector('.status-pill');
  if (pill) {
    pill.className   = 'status-pill status-lapsed';
    pill.textContent = 'Lapsed';
  }
}

// ── Simple error modal (replaces all alert() calls) ────────────────────
function showErrorModal(message) {
  const modal = document.createElement('div');
  modal.style.cssText = `
    position:fixed;inset:0;background:rgba(0,0,0,0.75);z-index:1001;
    display:flex;align-items:center;justify-content:center;padding:1rem;`;
  modal.innerHTML = `
    <div style="background:var(--surface);border:1px solid rgba(229,90,90,0.3);
                border-radius:10px;padding:2rem;max-width:360px;width:100%;text-align:center;">
      <div style="font-size:2rem;margin-bottom:0.75rem;">⚠️</div>
      <p style="color:var(--text);font-size:0.9rem;margin-bottom:1.5rem;">${message}</p>
      <button onclick="this.closest('[style]').remove()"
        style="background:var(--yellow);color:#0A0A0A;border:none;border-radius:4px;
               padding:0.65rem 2rem;font-weight:700;cursor:pointer;
               font-family:'DM Sans',sans-serif;">
        OK
      </button>
    </div>`;
  document.body.appendChild(modal);
  modal.addEventListener('click', e => { if (e.target === modal) modal.remove(); });
}

async function completeCheckout(bookingId, overtimeMins, overtimeCost, btn) {
  try {
    const now = new Date();
    const checkedOutAt = now.getHours().toString().padStart(2,'0') + ':' +
                         now.getMinutes().toString().padStart(2,'0') + ':' +
                         now.getSeconds().toString().padStart(2,'0');

    // Update booking status to lapsed via a second checkout call
    const res = await fetch(`/admin/bookings/${bookingId}/checkout-confirm`, {
      method: 'PATCH',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept':       'application/json',
        'Content-Type': 'application/json',
      },
    });

    const data = await res.json();

    showCheckoutResult({
      success:          true,
      name:             data.name || '',
      checked_out_at:   data.checked_out_at || checkedOutAt,
      was_overtime:     true,
      overtime_minutes: overtimeMins,
      overtime_cost:    overtimeCost,
    });

    const card = document.getElementById(`sc-${bookingId}`);
    if (card) {
      card.className = 'session-card lapsed';
      if (btn) btn.outerHTML = `
        <div style="background:rgba(90,158,229,0.1);border:1px solid rgba(90,158,229,0.3);
                    color:#5A9EE5;border-radius:4px;padding:0.5rem;text-align:center;
                    font-size:0.82rem;margin-top:0.75rem;">
          ✓ Checked out — overtime KES ${Number(overtimeCost).toLocaleString()}
        </div>`;
    }

    sessionData = sessionData.map(b =>
      b.id === bookingId ? { ...b, status: 'lapsed' } : b
    );

  } catch(e) {
    console.error('Complete checkout error:', e);
  }
}

// ── Styled checkout confirmation modal ────────────────────────────────
function showCheckoutConfirm(booking, t) {
  return new Promise(resolve => {
    document.getElementById('checkout-confirm-modal')?.remove();

    const isOvertime = t.state === 'overtime';

    const modal = document.createElement('div');
    modal.id    = 'checkout-confirm-modal';
    modal.style.cssText = `
      position:fixed;inset:0;background:rgba(0,0,0,0.8);z-index:1000;
      display:flex;align-items:center;justify-content:center;padding:1rem;`;

    modal.innerHTML = `
      <div style="background:var(--surface);border:1px solid ${isOvertime ? 'rgba(229,90,90,0.4)' : 'var(--border-y)'};
                  border-radius:10px;padding:2rem;max-width:400px;width:100%;
                  text-align:center;">

        <div style="font-size:2.5rem;margin-bottom:0.75rem;">
          ${isOvertime ? '⚠️' : '🚪'}
        </div>

        <h3 style="font-family:'Bebas Neue',sans-serif;font-size:1.6rem;
                   letter-spacing:2px;color:var(--yellow);margin-bottom:0.4rem;">
          Confirm Checkout
        </h3>

        <p style="color:var(--text);font-size:0.95rem;margin-bottom:0.25rem;">
          <strong>${booking.name}</strong>
        </p>
        <p style="color:var(--gray);font-size:0.82rem;margin-bottom:1.25rem;">
          📍 ${booking.room} &nbsp;·&nbsp; ${booking.start_time} – ${booking.end_time}
        </p>

        ${isOvertime ? `
          <div style="background:rgba(229,90,90,0.1);border:1px solid rgba(229,90,90,0.3);
                      border-radius:6px;padding:0.9rem;margin-bottom:1.25rem;">
            <p style="color:#E55A5A;font-size:0.78rem;letter-spacing:1.5px;
                      text-transform:uppercase;margin-bottom:0.35rem;">Overtime Running</p>
            <p style="font-size:1.5rem;font-weight:700;color:#E55A5A;
                      font-family:'DM Mono',monospace;margin-bottom:0.2rem;">
              KES ${Math.round(t.oCost).toLocaleString()}
            </p>
            <p style="color:#888;font-size:0.76rem;">${t.oMin} min${t.oMin !== 1 ? 's' : ''} over</p>
          </div>` : `
          <div style="background:rgba(52,199,123,0.07);border:1px solid rgba(52,199,123,0.2);
                      border-radius:6px;padding:0.75rem;margin-bottom:1.25rem;">
            <p style="color:#34C77B;font-size:0.85rem;">✓ Session ending on time</p>
          </div>`}

        <p style="color:var(--gray);font-size:0.8rem;margin-bottom:1.5rem;">
          Are you sure you want to check out this session?
        </p>

        <div style="display:flex;gap:0.75rem;">
          <button id="confirm-cancel-btn"
            style="flex:1;padding:0.7rem;border-radius:4px;border:1px solid var(--border);
                   background:transparent;color:var(--text2);font-family:'DM Sans',sans-serif;
                   font-size:0.88rem;font-weight:600;cursor:pointer;letter-spacing:0.5px;">
            Cancel
          </button>
          <button id="confirm-proceed-btn"
            style="flex:2;padding:0.7rem;border-radius:4px;border:none;
                   background:${isOvertime ? '#E55A5A' : '#34C77B'};color:#fff;
                   font-family:'DM Sans',sans-serif;font-size:0.88rem;
                   font-weight:700;cursor:pointer;letter-spacing:1px;">
            ${isOvertime ? '🔴 Yes, Check Out' : '✅ Yes, Check Out'}
          </button>
        </div>
      </div>`;

    document.body.appendChild(modal);

    // Close on backdrop click
    modal.addEventListener('click', e => {
      if (e.target === modal) { modal.remove(); resolve(false); }
    });

    document.getElementById('confirm-cancel-btn').addEventListener('click', () => {
      modal.remove(); resolve(false);
    });

    document.getElementById('confirm-proceed-btn').addEventListener('click', () => {
      modal.remove(); resolve(true);
    });
  });
}

function tickAll() {
  if (!sessionData.length) return;

  let counts = { upcoming:0, active:0, overtime:0, lapsed:0 };

  sessionData.forEach(b => {
    const t   = getTiming(b);
    const td  = document.getElementById(`td-${b.id}`);
    const sc  = document.getElementById(`sc-${b.id}`);
    const pf  = document.getElementById(`pf-${b.id}`);
    const ob  = document.getElementById(`ob-${b.id}`);

    if (!td) return;

    td.textContent  = fmt(t.display);
    td.className    = `timer-display ${t.state}`;
    sc.className    = `session-card ${t.state}`;
    if (pf) pf.style.width = t.pct + '%';
    if (ob) ob.innerHTML = `⚠ Overtime: <b>KES ${Math.round(t.oCost).toLocaleString()}</b> &nbsp;·&nbsp; ${t.oMin} min over`;

    counts[t.state] = (counts[t.state] || 0) + 1;
  });

  updateCounts(counts);
}

function updateCounts(c) {
  document.getElementById('cnt-upcoming').textContent = c.upcoming || 0;
  document.getElementById('cnt-active').textContent   = c.active   || 0;
  document.getElementById('cnt-overtime').textContent = c.overtime || 0;
  document.getElementById('cnt-lapsed').textContent   = c.lapsed   || 0;

  const badge  = document.getElementById('live-badge');
  const active = (c.active || 0) + (c.overtime || 0);
  if (badge) {
    badge.textContent    = active;
    badge.style.display  = active > 0 ? 'inline' : 'none';
    badge.style.background = (c.overtime || 0) > 0 ? '#E55A5A' : '#34C77B';
    badge.style.color      = '#fff';
  }
}

window._fetchedAt = Date.now() / 1000;

function filterSessions(filter, pillEl) {
  currentFilter = filter;

  document.querySelectorAll('.count-pill').forEach(p => {
    p.classList.remove('active-filter');
  });
  if (pillEl) pillEl.classList.add('active-filter');

  const existing = document.getElementById('filter-empty-msg');
  if (existing) existing.remove();

  if (!sessionData.length) return;

  let visibleCount = 0;

  sessionData.forEach(b => {
    const card = document.getElementById(`sc-${b.id}`);
    if (!card) return;

    const t = getTiming(b);
    const show = (filter === 'upcoming') || (t.state === filter);

    if (show) {
      card.classList.remove('hidden');
      visibleCount++;
    } else {
      card.classList.add('hidden');
    }
  });

  if (visibleCount === 0) {
    const grid = document.getElementById('session-grid');
    const msg  = document.createElement('div');
    msg.id     = 'filter-empty-msg';
    msg.style.cssText = 'color:var(--gray);padding:2rem;text-align:center;grid-column:1/-1;font-size:0.9rem;';
    msg.textContent   = `No ${filter} sessions right now.`;
    grid.appendChild(msg);
  }
}

function confirmCancel(bookingId, name, form) {
  const confirmed = confirm(`Cancel booking for ${name}?`);
  if (!confirmed) return false;

  sessionData = sessionData.filter(b => b.id !== bookingId);

  const card = document.getElementById(`sc-${bookingId}`);
  if (card) {
    card.style.transition = 'opacity 0.3s, transform 0.3s';
    card.style.opacity    = '0';
    card.style.transform  = 'scale(0.95)';
    setTimeout(() => card.remove(), 300);
  }

  tickAll();
  return true;
}
</script>
@endsection