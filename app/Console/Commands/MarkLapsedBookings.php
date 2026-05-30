<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkLapsedBookings extends Command
{
    protected $signature   = 'bookings:mark-lapsed';
    protected $description = 'Mark confirmed bookings whose session time has fully passed as lapsed';

    public function handle(): void
    {
        $now = now();

        Booking::where('status', 'confirmed')
            ->whereDate('booking_date', '<=', today())
            ->get()
            ->each(function (Booking $booking) use ($now) {
                if ($now->gt($booking->session_end)) {
                    $overtimeMinutes = $now->diffInMinutes($booking->session_end);
                    $overtimeCost    = round($overtimeMinutes * Booking::OVERTIME_RATE_PER_MINUTE);

                    $booking->update([
                        'status'           => 'lapsed',
                        'overtime_minutes' => $overtimeMinutes,
                        'overtime_amount'  => $overtimeCost,
                    ]);

                    $this->info("Marked booking #{$booking->id} ({$booking->name}) as lapsed.");
                }
            });
    }
}