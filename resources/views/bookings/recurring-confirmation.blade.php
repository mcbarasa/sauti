@extends('layouts.app')
@section('title', 'Recurring Booking Confirmed — Sauti Gang Studio')

@section('content')
<section style="padding-top:8rem;padding-bottom:4rem;">
<div class="container" style="max-width:680px;margin:0 auto;">

  <div style="background:var(--surface);border:1px solid var(--border-y);
              border-radius:8px;padding:2.5rem 2rem;box-shadow:var(--shadow);">

    <div style="text-align:center;margin-bottom:2rem;">
      <div style="font-size:3rem;margin-bottom:0.75rem;">🔁</div>
      <h1 style="font-family:'Bebas Neue',sans-serif;font-size:2.2rem;
                 letter-spacing:3px;color:var(--yellow);margin-bottom:0.3rem;">
        Recurring Sessions Booked!
      </h1>
      <p style="color:var(--gray);">
        {{ $bookings->count() }} sessions have been reserved.
        We'll confirm each one via WhatsApp.
      </p>
    </div>

    {{-- Summary --}}
    @php
      $first = $bookings->first();
      $last  = $bookings->last();
    @endphp
    <div style="background:var(--surface2);border:1px solid var(--border);
                border-radius:6px;padding:1.2rem;margin-bottom:1.5rem;">
      <div style="display:flex;justify-content:space-between;padding:0.5rem 0;
                  border-bottom:1px solid var(--border);font-size:0.88rem;">
        <span style="color:var(--gray);font-size:0.75rem;text-transform:uppercase;letter-spacing:1.5px;">Name</span>
        <span style="color:var(--text);font-weight:600;">{{ $first->name }}</span>
      </div>
      <div style="display:flex;justify-content:space-between;padding:0.5rem 0;
                  border-bottom:1px solid var(--border);font-size:0.88rem;">
        <span style="color:var(--gray);font-size:0.75rem;text-transform:uppercase;letter-spacing:1.5px;">Room</span>
        <span style="color:var(--text);">{{ $first->room_label }}</span>
      </div>
      <div style="display:flex;justify-content:space-between;padding:0.5rem 0;
                  border-bottom:1px solid var(--border);font-size:0.88rem;">
        <span style="color:var(--gray);font-size:0.75rem;text-transform:uppercase;letter-spacing:1.5px;">Time</span>
        <span style="color:var(--text);">{{ substr($first->start_time,0,5) }} · {{ $first->duration_label }}</span>
      </div>
      <div style="display:flex;justify-content:space-between;padding:0.5rem 0;
                  border-bottom:1px solid var(--border);font-size:0.88rem;">
        <span style="color:var(--gray);font-size:0.75rem;text-transform:uppercase;letter-spacing:1.5px;">Frequency</span>
        <span style="color:var(--text);">{{ ucfirst($first->recurrence_frequency) }}</span>
      </div>
      <div style="display:flex;justify-content:space-between;padding:0.5rem 0;
                  border-bottom:1px solid var(--border);font-size:0.88rem;">
        <span style="color:var(--gray);font-size:0.75rem;text-transform:uppercase;letter-spacing:1.5px;">Period</span>
        <span style="color:var(--text);">{{ $first->formatted_date }} → {{ $last->formatted_date }}</span>
      </div>
      <div style="display:flex;justify-content:space-between;padding:0.5rem 0;font-size:0.88rem;">
        <span style="color:var(--gray);font-size:0.75rem;text-transform:uppercase;letter-spacing:1.5px;">Total Amount</span>
        <span style="color:var(--yellow);font-weight:700;font-size:1.1rem;">
          KES {{ number_format($bookings->sum('amount')) }}
        </span>
      </div>
    </div>

    {{-- All sessions list --}}
    <p style="font-size:0.72rem;letter-spacing:2px;text-transform:uppercase;
               color:var(--gray);margin-bottom:0.75rem;">All Sessions</p>
    <div style="border:1px solid var(--border);border-radius:4px;
                overflow:hidden;max-height:280px;overflow-y:auto;margin-bottom:1.5rem;">
      <table style="width:100%;border-collapse:collapse;font-size:0.85rem;">
        <tbody>
          @foreach($bookings as $i => $booking)
          <tr style="{{ $loop->first ? '' : 'border-top:1px solid var(--border);' }}">
            <td style="padding:0.55rem 0.9rem;color:var(--gray);width:40px;">{{ $loop->iteration }}</td>
            <td style="padding:0.55rem 0.9rem;color:var(--text);">{{ $booking->formatted_date }}</td>
            <td style="padding:0.55rem 0.9rem;color:var(--gray);">{{ substr($booking->start_time,0,5) }}</td>
            <td style="padding:0.55rem 0.9rem;text-align:right;">
              <span style="background:rgba(245,197,24,0.12);color:var(--confirm-color);
                           border-radius:20px;padding:2px 10px;font-size:0.7rem;
                           font-weight:700;letter-spacing:1px;">Confirmed</span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div style="display:flex;gap:0.75rem;flex-wrap:wrap;justify-content:center;">
      <a href="{{ route('bookings.create') }}" class="btn-primary">+ Book Another</a>
      <a href="{{ route('home') }}" class="btn-secondary">← Back to Home</a>
    </div>
  </div>
</div>
</section>
@endsection