<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // open to all visitors
    }

   public function rules(): array
{
    return [
        'name'                 => ['required', 'string', 'max:120'],
        'phone'                => ['required', 'string', 'regex:/^[0-9+\s]+$/', 'min:10', 'max:15'],
        'booking_date'         => ['required', 'date', 'after_or_equal:today'],
        'room'                 => ['required', Rule::in(array_keys(\App\Models\Booking::$rooms))],
        // 'start_time'           => ['required', Rule::in(\App\Models\Booking::$timeSlots)],
        'duration'             => ['required', Rule::in(array_keys(\App\Models\Booking::$durations))],
        'notes'                => ['nullable', 'string', 'max:600'],
        'amount'               => ['required', 'numeric', 'min:0'],
        // Recurring fields — only required when is_recurring = 1
        'is_recurring'         => ['nullable', 'boolean'],
        'skip_conflicts'       => ['nullable'],

        'recurrence_frequency' => [
            Rule::when(
                $this->boolean('is_recurring'),
                ['required', Rule::in(['daily', 'weekly', 'biweekly', 'monthly'])],
                ['nullable']
            )
        ],
        'recurrence_end' => [
            Rule::when(
                $this->boolean('is_recurring'),
                ['required', 'date', 'after:booking_date'],
                ['nullable']
            )
        ],
        'start_time' => [
    'required',
    Rule::in(\App\Models\Booking::$timeSlots),
    function($attribute, $value, $fail) {
        $date    = request('booking_date');
        if (!$date) return;

        $dayOfWeek = \Carbon\Carbon::parse($date)->dayOfWeek; // 0 = Sunday
        $hour      = (int) substr($value, 0, 2);

        if ($dayOfWeek === 0 && ($hour < 14 || $hour >= 21)) {
            $fail('On Sundays, bookings are only available between 2:00 PM and 9:00 PM.');
        }
    },
],
    ];
}

    public function messages(): array
    {
        return [
            'booking_date.after_or_equal' => 'You cannot book a date in the past.',
            'room.in'                      => 'Please select a valid room.',
            'start_time.in'                => 'Please select a valid start time.',
        ];
    }
    
}