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

    // ─── Room labels ────────────────────────────────────────────────────
    public static array $rooms = [
        'room-a' => 'Rehearsal –  (Band)',
        'room-b' => 'Rehearsal –  (Solo)',
        'room-c' => 'Recording –  Suite',
        'room-d' => 'Lesson – Instrument',
        'room-e' => 'Room 1 – Podcast/Production',
    ];

    // ─── Duration labels ────────────────────────────────────────────────
    public static array $durations = [
        '1'    => '1 Hours',
        '2'    => '2 Hours',
        '3'    => '3 Hours',
        '4'    => '4 Hours',
        'full' => 'Full Day',
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
        return static::$durations[$this->duration] ?? $this->duration;
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
            ->get(['booking_date', 'room', 'start_time']);

        $result = [];
        foreach ($bookings as $b) {
            $key = $b->booking_date->format('Y-n-j');
            $slotKey = $key . '-' . $b->room . '-' . substr($b->start_time, 0, 5);
            $result[$slotKey] = true;
            $result[$key][] = $slotKey;
        }

        return $result;
    }

    // Hourly rate
const HOURLY_RATE = 700;

public static array $rates = [
    '1'    => 350,   
    '2'    => 700,   
    '3'    => 1050,   
    '4'    => 1400,   
    'full' => 4000,   // flat full-day rate
];

public static function computeAmount(string $duration): float
{
    return static::$rates[$duration] ?? 0;
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
    return match($this->duration) {
        '1'    => 60,
        '2'    => 120,
        '3'    => 180,
        '4'    => 240,
        'full' => 6600,
    };
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