<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'booking_date',
        'room',
        'start_time',
        'duration',
        'notes',
        'status',
        'amount',
        'overtime_amount', 
        'overtime_minutes',
        'checked_out_at',
        'is_recurring', 
        'recurrence_group_id', 
        'recurrence_frequency',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'checked_out_at' => 'datetime',
    ];

    public static array $durations = [
    '1'  => '1 Hour',
    '2'  => '2 Hours',
    '3'  => '3 Hours',
    '4'  => '4 Hours',
    '5'  => '5 Hours',
    '6'  => '6 Hours',
    '7'  => '7 Hours',
    '8'  => '8 Hours',
    '9'  => '9 Hours',
    '10' => '10 Hours',
    '11' => '11 Hours',
    '12' => '12 Hours (Full Day)',
];

    // ─── Room labels ────────────────────────────────────────────────────
    public static array $rooms = [
        'room-a' => 'Rehearsal –  (Band)',
        'room-b' => 'Rehearsal –  (Solo)',
        'room-c' => 'Recording –  Suite',
        'room-d' => 'Lesson – Instrument',
        'room-e' => 'Room 1 – Podcast/Production',
    ];


    // ─── Time slots ─────────────────────────────────────────────────────
    public static array $timeSlots = [
        '07:00', '08:00', '09:00', '10:00', '11:00', '12:00',
        '13:00', '14:00', '15:00', '16:00', '17:00', '18:00',
        '19:00', '20:00', '21:00',
    ];

    // ─── Accessors ───────────────────────────────────────────────────────
    public function getRoomLabelAttribute(): string
    {
        return static::$rooms[$this->room] ?? $this->room;
    }

    public function getDurationLabelAttribute(): string
{
    $hours = intval($this->duration);
    return $hours === 12 ? '12 Hours (Full Day)' : $hours . ($hours === 1 ? ' Hour' : ' Hours');
}

    public function getFormattedDateAttribute(): string
    {
        return $this->booking_date->format('d M Y');
    }

    // ─── Scopes ──────────────────────────────────────────────────────────
    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', today())->orderBy('booking_date')->orderBy('start_time');
    }

    public function scopeForDate($query, string $date)
    {
        return $query->where('booking_date', $date);
    }

    // ─── Helper: check if a slot is already taken ───────────────────────
    // (Exact start-time match only — kept as-is so any existing caller
    // that relies on this exact behaviour is unaffected.)
    public static function isSlotTaken(string $date, string $room, string $startTime, ?int $excludeId = null): bool
    {
        $query = static::where('booking_date', $date)
            ->where('room', $room)
            ->where('start_time', $startTime)
            ->where('status', '!=', 'cancelled');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    // ─── Studio closing hour per day-of-week (0 = Sunday … 6 = Saturday) ──
    // Used to reject bookings whose duration would run past closing time.
    public static array $closingHour = [
        0 => 21, // Sunday   – 09:00 PM
        1 => 22, // Monday   – 10:00 PM
        2 => 22, // Tuesday  – 10:00 PM
        3 => 22, // Wednesday– 10:00 PM
        4 => 22, // Thursday – 10:00 PM
        5 => 23, // Friday   – 11:00 PM
        6 => 23, // Saturday – 11:00 PM
    ];

    public static array $openingHour = [
        0 => 14, // Sunday   – 02:00 PM
        1 => 7,  // Monday   – 07:00 AM
        2 => 7,
        3 => 7,
        4 => 7,
        5 => 7,
        6 => 8,  // Saturday – 08:00 AM
    ];

    // ─── Helper: would this booking run outside operating hours? ────────
    public static function isOutsideOperatingHours(string $date, string $startTime, int|string $duration): bool
    {
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        $open      = self::$openingHour[$dayOfWeek] ?? 7;
        $close     = self::$closingHour[$dayOfWeek] ?? 22;

        $startHour = (int) substr($startTime, 0, 2);
        $hours     = intval($duration) >= 1 ? intval($duration) : 1;
        $endHour   = $startHour + $hours;

        return $startHour < $open || $endHour > $close;
    }

    // ─── Helper: does this booking overlap any existing booking for the
    //     same room/date (regardless of exact start-time match)? ─────────
    public static function hasOverlap(string $date, string $room, string $startTime, int|string $duration, ?int $excludeId = null): bool
    {
        $hours      = intval($duration) >= 1 ? intval($duration) : 1;
        $startHour  = (int) substr($startTime, 0, 2);
        $endHour    = $startHour + $hours;

        $query = static::where('booking_date', $date)
            ->where('room', $room)
            ->where('status', '!=', 'cancelled');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $existing = $query->get(['start_time', 'duration']);

        foreach ($existing as $booking) {
            $existingStart = (int) substr($booking->start_time, 0, 2);
            $existingHours = intval($booking->duration) >= 1 ? intval($booking->duration) : 1;
            $existingEnd   = $existingStart + $existingHours;

            // Two ranges overlap if one starts before the other ends,
            // on both sides.
            if ($startHour < $existingEnd && $endHour > $existingStart) {
                return true;
            }
        }

        return false;
    }

    // Get all bookings in the same recurrence group
public function recurringGroup()
{
    return static::where('recurrence_group_id', $this->recurrence_group_id)
        ->orderBy('booking_date')
        ->get();
}

    // ─── Return bookings grouped by date as JSON-friendly array ─────────
    public static function bookedSlotsForMonth(int $year, int $month): array
    {
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        $bookings = static::whereBetween('booking_date', [$start, $end])
            ->where('status', '!=', 'cancelled')
            ->get(['booking_date', 'room', 'start_time', 'duration']);

        $result = [];
        foreach ($bookings as $b) {
            $key       = $b->booking_date->format('Y-n-j');
            $startHour = (int) substr($b->start_time, 0, 2);
            $hours     = intval($b->duration) >= 1 ? intval($b->duration) : 1;

            // Mark every hour the booking spans as taken (e.g. a 3-hour
            // booking starting at 09:00 blocks 09:00, 10:00 and 11:00),
            // not just its exact start time.
            for ($h = $startHour; $h < $startHour + $hours; $h++) {
                $slotTime = sprintf('%02d:00', $h);
                $slotKey  = $key . '-' . $b->room . '-' . $slotTime;
                $result[$slotKey] = true;
            }

            // Keep original per-day list (used for the "heavily booked"
            // calendar day marker) populated with the start-time key only,
            // exactly as before, so day-level marker behaviour is unchanged.
            $startSlotKey = $key . '-' . $b->room . '-' . substr($b->start_time, 0, 5);
            $result[$key][] = $startSlotKey;
        }

        return $result;
    }

    // Hourly rate (default / fallback rate, used when no room is given)
const DEPOSIT_RATE_PER_HOUR = 350;

    // ─── Per-room hourly rates ───────────────────────────────────────────
    // Recording Suite (room-c) bills at a premium rate; every other room
    // bills at the standard deposit rate. Add/adjust rooms here only.
    public static array $roomRates = [
        'room-a' => 350,   // Rehearsal – (Band)
        'room-b' => 350,   // Rehearsal – (Solo)
        'room-c' => 3000,  // Recording – Suite
        'room-d' => 1000,   // Lesson – Instrument
        'room-e' => 350,   // Room 1 – Podcast/Production
    ];

public static function computeAmount(int|string $duration, ?string $room = null): float
{
    $hours = intval($duration);

    // If a room is supplied, use its specific rate; otherwise fall back
    // to the original flat rate so any existing calls without a room
    // argument keep behaving exactly as before.
    $rate = $room !== null
        ? (self::$roomRates[$room] ?? self::DEPOSIT_RATE_PER_HOUR)
        : self::DEPOSIT_RATE_PER_HOUR;

    return $hours >= 1 ? $hours * $rate : 0;
}

public function getFormattedAmountAttribute(): string
{
    return 'KES ' . number_format($this->amount, 2);
}

// Hourly rate for overtime
const OVERTIME_RATE_PER_MINUTE = 700 / 60; // KES 1000 per hour

// Get duration in minutes
public function getDurationMinutesAttribute(): int
{
    $hours = intval($this->duration);
    return $hours >= 1 ? $hours * 60 : 60;
}

// Get session start as Carbon datetime
public function getSessionStartAttribute(): \Carbon\Carbon
{
    return \Carbon\Carbon::parse(
        $this->booking_date->format('Y-m-d') . ' ' . $this->start_time
    );
}

// Get session end as Carbon datetime
public function getSessionEndAttribute(): \Carbon\Carbon
{
    return $this->session_start->addMinutes($this->duration_minutes);
}

// Get session status with timing info
public function getTimingStatusAttribute(): string
{
    $now = now();

    if ($now->lt($this->session_start)) return 'upcoming';
    if ($now->between($this->session_start, $this->session_end)) return 'active';
    if ($now->gt($this->session_end)) return 'overtime';

    return $this->status;
}

// Calculate overtime cost
public function getOvertimeCostAttribute(): float
{
    $now = now();
    if ($now->lte($this->session_end)) return 0;

    $overtimeMinutes = $now->diffInMinutes($this->session_end);
    return round($overtimeMinutes * (700 / 60));
}
//checkout

public function getIsOverdueAttribute(): bool
{
    return now()->gt($this->session_end);
}

}