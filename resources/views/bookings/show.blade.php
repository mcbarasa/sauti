@extends('layouts.app')
@section('title', 'Booking Confirmed — Sauti Gang Studio')

@section('content')
<div class="container">
  <div class="confirm-card">
    <span class="confirm-icon">✓</span>
    <h1>Booking Confirmed!</h1>
    <p style="color:var(--gray);font-weight:300;margin:0.5rem 0 2rem;">
      We'll reach out on WhatsApp to finalise the details. See you in the studio!
    </p>

    <div style="text-align:left;margin-bottom:2rem;">
      <div class="confirm-detail">
        <span>Booking #</span><span>#{{ $booking->id }}</span>
      </div>
      <div class="confirm-detail">
        <span>Name</span><span>{{ $booking->name }}</span>
      </div>
      <div class="confirm-detail">
        <span>Phone</span><span>{{ $booking->phone }}</span>
      </div>
      <div class="confirm-detail">
        <span>Date</span><span>{{ $booking->formatted_date }}</span>
      </div>
      <div class="confirm-detail">
        <span>Room</span><span>{{ $booking->room_label }}</span>
      </div>
      <div class="confirm-detail">
        <span>Start Time</span><span>{{ substr($booking->start_time, 0, 5) }}</span>
      </div>
      <div class="confirm-detail">
        <span>Duration</span><span>{{ $booking->duration_label }}</span>
      </div>
      <div class="confirm-detail">
    <span>Amount</span>
    <span style="color:var(--yellow);font-weight:700;">{{ $booking->formatted_amount }}</span>
</div>
      @if($booking->notes)
      <div class="confirm-detail" style="flex-direction:column;gap:0.3rem;">
        <span>Notes</span><span style="color:var(--text2);font-size:0.88rem;">{{ $booking->notes }}</span>
      </div>
      @endif
      <div class="confirm-detail">
        <span>Status</span>
        <span class="status-pill status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
      </div>
    </div>

    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
      <a href="{{ route('bookings.create') }}" class="btn-primary">Book Another Session</a>
      <a href="{{ route('home') }}" class="btn-secondary">← Back to Home</a>
    </div>
  </div>
</div>
@endsection