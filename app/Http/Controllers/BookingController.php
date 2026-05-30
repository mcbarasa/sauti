<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Services\MpesaService;
use App\Models\MpesaPayment;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    // ── Homepage ─────────────────────────────────────────────────────────
    public function index()
    {
        $now   = Carbon::now('Africa/Nairobi');
        $slots = Booking::bookedSlotsForMonth($now->year, $now->month);

        return view('bookings.index', [
            'rooms'           => Booking::$rooms,
            'durations'       => Booking::$durations,
            'timeSlots'       => Booking::$timeSlots,
            'bookedSlotsJson' => json_encode($slots),
        ]);
    }

    // ── Dedicated booking page ───────────────────────────────────────────
    public function create()
    {
        $now   = Carbon::now('Africa/Nairobi');
        $slots = Booking::bookedSlotsForMonth($now->year, $now->month);

        return view('bookings.create', [
            'rooms'           => Booking::$rooms,
            'durations'       => Booking::$durations,
            'timeSlots'       => Booking::$timeSlots,
            'bookedSlotsJson' => json_encode($slots),
        ]);
    }

    // ── Initiate single booking + STK Push ───────────────────────────────
    public function initiate(StoreBookingRequest $request, MpesaService $mpesa)
    {
        $data           = $request->validated();
        $data['amount'] = Booking::computeAmount($data['duration']);

        if (Booking::isSlotTaken($data['booking_date'], $data['room'], $data['start_time'])) {
            if ($request->expectsJson()) {
                return response()->json(['status' => 'slot_taken'], 422);
            }
            return back()->withInput();
        }

        $reference = 'SGS-' . strtoupper(substr(preg_replace('/\D/', '', $data['phone']), -6)) . '-' . time();

        try {
            $response = $mpesa->stkPush($data['phone'], (int) $data['amount'], $reference);
        } catch (\Exception $e) {
            logger()->error('STK Push failed: ' . $e->getMessage());
            return back()->withInput()
                ->withErrors(['payment' => 'M-Pesa service unavailable. Please try again or contact us on 0733 590 438.']);
        }

        if (!isset($response['CheckoutRequestID'])) {
            return back()->withInput()
                ->withErrors(['payment' => 'Could not initiate M-Pesa payment. Check your number and try again.']);
        }

        MpesaPayment::create([
            'checkout_request_id' => $response['CheckoutRequestID'],
            'merchant_request_id' => $response['MerchantRequestID'] ?? null,
            'phone'               => $data['phone'],
            'amount'              => $data['amount'],
            'reference'           => $reference,
            'status'              => 'pending',
        ]);

        // Clear any stale recurring session and set single booking
        session()->forget(['pending_recurring', 'payment_type']);
        session([
            'pending_booking'   => $data,
            'payment_type'      => 'single',
            'mpesa_checkout_id' => $response['CheckoutRequestID'],
        ]);

        return view('bookings.payment-pending', [
            'checkoutRequestId' => $response['CheckoutRequestID'],
            'amount'            => $data['amount'],
            'phone'             => $data['phone'],
        ]);
    }

    // ── Safaricom callback ───────────────────────────────────────────────
    public function mpesaCallback(Request $request)
    {
        $body       = $request->input('Body.stkCallback', []);
        $checkoutId = $body['CheckoutRequestID'] ?? null;
        $payment    = MpesaPayment::where('checkout_request_id', $checkoutId)->first();

        if (!$payment) return response()->json(['ResultCode' => 0, 'ResultDesc' => 'ok']);

        if (($body['ResultCode'] ?? 1) === 0) {
            $items   = collect($body['CallbackMetadata']['Item'] ?? []);
            $receipt = $items->firstWhere('Name', 'MpesaReceiptNumber')['Value'] ?? null;

            $payment->update([
                'status'        => 'completed',
                'mpesa_receipt' => $receipt,
                'raw_callback'  => $request->all(),
            ]);
        } else {
            $payment->update(['status' => 'failed', 'raw_callback' => $request->all()]);
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'ok']);
    }

    // ── Frontend polls this to check payment ─────────────────────────────
// ── Frontend polls this to check payment ─────────────────────────────
public function checkMpesaPayment(Request $request, MpesaService $mpesa)
{
    $checkoutId = $request->checkout_request_id;
    $payment    = MpesaPayment::where('checkout_request_id', $checkoutId)->first();

    if (!$payment) return response()->json(['status' => 'not_found']);

    // ── If callback already resolved — skip querying Safaricom ───────
    if ($payment->status === 'failed') {
        return response()->json([
            'status'  => 'failed',
            'message' => 'Payment was cancelled or failed. Please try again.',
        ]);
    }

    if ($payment->status !== 'completed') {
        try {
            $result     = $mpesa->stkQuery($checkoutId);
            $resultCode = $result['ResultCode'] ?? null;

            // Null = Safaricom hasn't processed yet — keep polling
            if (is_null($resultCode)) {
                return response()->json(['status' => 'pending']);
            }

            $resultCode = (string) $resultCode;

            if ($resultCode === '0') {
                $payment->update(['status' => 'completed']);

            } elseif ($resultCode === '1032') {
                // User explicitly cancelled
                $payment->update(['status' => 'failed']);
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'You cancelled the M-Pesa prompt. Please try again.',
                ]);

            } elseif ($resultCode === '1037') {
                // DS timeout — user hasn't responded yet, keep polling
                return response()->json(['status' => 'pending']);

            } elseif ($resultCode === '1') {
                // Insufficient funds
                $payment->update(['status' => 'failed']);
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Insufficient M-Pesa balance. Please top up and try again.',
                ]);

            } else {
                // Be lenient on early polls — Safaricom sometimes returns
                // errors before the transaction is fully processed
                $attempt = (int) $request->query('attempt', 1);
                if ($attempt < 3) {
                    return response()->json(['status' => 'pending']);
                }

                $payment->update(['status' => 'failed']);
                return response()->json([
                    'status'  => 'failed',
                    'message' => $result['ResultDesc'] ?? 'Payment failed. Please try again.',
                ]);
            }

        } catch (\Exception $e) {
            // Network/timeout error — don't fail the payment, keep polling
            logger()->error('STK Query error: ' . $e->getMessage());
            return response()->json(['status' => 'pending']);
        }
    }

    $payment->refresh();

    // ── OVERTIME PAYMENT — booking_id already set, just needs checkout ──
    if ($payment->status === 'completed' && $payment->booking_id) {
        $booking = Booking::find($payment->booking_id);

        if ($booking && $booking->status !== 'lapsed') {
            $now = now('Africa/Nairobi');
            $booking->update([
                'status'         => 'lapsed',
                'checked_out_at' => $now,
            ]);
        }

        return response()->json([
            'status'     => 'completed',
            'booking_id' => $payment->booking_id,
        ]);
    }

    // ── NEW BOOKING (single or recurring) ─────────────────────────────
    if ($payment->status === 'completed' && !$payment->booking_id) {
        $paymentType   = session('payment_type', 'single');
        $recurringData = session('pending_recurring');
        $bookingData   = session('pending_booking');

        // ── RECURRING ────────────────────────────────────────────────
        if ($paymentType === 'recurring' && $recurringData) {
            $startDate = Carbon::parse($recurringData['booking_date']);
            $endDate   = Carbon::parse($recurringData['recurrence_end']);
            $frequency = $recurringData['recurrence_frequency'];
            $groupId   = Str::uuid()->toString();
            $created   = [];

            $current = $startDate->copy();
            while ($current->lte($endDate)) {
                $isTaken = Booking::isSlotTaken(
                    $current->toDateString(),
                    $recurringData['room'],
                    $recurringData['start_time']
                );

                if (!$isTaken) {
                    $booking = Booking::create([
                        'name'                 => $recurringData['name'],
                        'phone'                => $recurringData['phone'],
                        'booking_date'         => $current->toDateString(),
                        'room'                 => $recurringData['room'],
                        'start_time'           => $recurringData['start_time'],
                        'duration'             => $recurringData['duration'],
                        'notes'                => $recurringData['notes'] ?? null,
                        'amount'               => $recurringData['amount_per_session'],
                        'status'               => 'confirmed',
                        'is_recurring'         => true,
                        'recurrence_group_id'  => $groupId,
                        'recurrence_frequency' => $frequency,
                    ]);
                    $created[] = $booking;
                }

                $current = match($frequency) {
                    'daily'    => $current->addDay(),
                    'weekly'   => $current->addWeek(),
                    'biweekly' => $current->addWeeks(2),
                    'monthly'  => $current->addMonth(),
                };
            }

            if (!empty($created)) {
                $payment->update(['booking_id' => $created[0]->id]);
            }

            session()->forget([
                'pending_recurring', 'pending_booking',
                'mpesa_checkout_id', 'payment_type',
                'pending_booking_session_count',
            ]);

            return response()->json([
                'status'       => 'completed',
                'is_recurring' => true,
                'group_id'     => $groupId,
                'count'        => count($created),
                'redirect_url' => route('bookings.recurring.confirmation', ['group' => $groupId]),
            ]);
        }

        // ── SINGLE BOOKING ────────────────────────────────────────────
        if ($bookingData) {
            if (Booking::isSlotTaken(
                $bookingData['booking_date'],
                $bookingData['room'],
                $bookingData['start_time']
            )) {
                return response()->json(['status' => 'slot_taken']);
            }

            $booking = Booking::create(array_merge($bookingData, ['status' => 'confirmed']));
            $payment->update(['booking_id' => $booking->id]);

            session()->forget(['pending_booking', 'mpesa_checkout_id', 'payment_type']);

            return response()->json([
                'status'     => 'completed',
                'booking_id' => $booking->id,
            ]);
        }

        return response()->json([
            'status'  => 'session_expired',
            'message' => 'Session expired. Contact us on 0733 590 438 to confirm your booking.',
        ]);
    }

    return response()->json(['status' => $payment->status]);
}

    // ── Show single booking ──────────────────────────────────────────────
    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    // ── Admin booking list ───────────────────────────────────────────────
    public function adminIndex(Request $request)
    {
        $bookings = Booking::when($request->date,   fn($q) => $q->forDate($request->date))
            ->when($request->room,   fn($q) => $q->where('room', $request->room))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->type === 'recurring', fn($q) => $q->where('is_recurring', true))
            ->when($request->type === 'oneoff',    fn($q) => $q->where('is_recurring', false))
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('bookings.admin', [
            'bookings' => $bookings,
            'rooms'    => Booking::$rooms,
        ]);
    }

    // ── Cancel booking ───────────────────────────────────────────────────
    public function destroy(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);

        return redirect()
            ->route('bookings.admin')
            ->with('success', "Booking #{$booking->id} has been cancelled.");
    }

    // ── Confirm booking ──────────────────────────────────────────────────
    public function confirm(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);

        return redirect()
            ->route('bookings.admin')
            ->with('success', "Booking #{$booking->id} has been confirmed.");
    }

    // ── Slots for calendar JS ────────────────────────────────────────────
    public function slotsForMonth(Request $request)
    {
        $year  = (int) $request->query('year',  now()->year);
        $month = (int) $request->query('month', now()->month);

        return response()->json(Booking::bookedSlotsForMonth($year, $month));
    }

    // ── Live timers for admin ────────────────────────────────────────────
    public function liveTimers()
    {
        $now = now('Africa/Nairobi');

        $bookings = Booking::where(function ($query) {
                $query->where('booking_date', '>=', today('Africa/Nairobi'))
                      ->whereIn('status', ['confirmed', 'pending', 'lapsed', 'completed']);
            })
            ->orWhere(function ($query) use ($now) {
                $query->where('booking_date', '<', today('Africa/Nairobi'))
                      ->where('status', 'lapsed')
                      ->where('checked_out_at', '>=', $now->copy()->subMinutes(30));
            })
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get()
            ->filter(function (Booking $b) use ($now) {
                if ($b->status === 'lapsed' && $b->checked_out_at) {
                    return $b->checked_out_at->diffInMinutes($now) <= 30;
                }
                return true;
            })
            ->map(function (Booking $b) use ($now) {
                $start = $b->session_start->setTimezone('Africa/Nairobi');
                $end   = $b->session_end->setTimezone('Africa/Nairobi');

                return [
                    'id'                => $b->id,
                    'name'              => $b->name,
                    'room'              => $b->room_label,
                    'room_key'          => $b->room,
                    'date'              => $b->formatted_date,
                    'start_time'        => substr($b->start_time, 0, 5),
                    'end_time'          => $end->format('H:i'),
                    'duration_label'    => $b->duration_label,
                    'amount'            => $b->amount,
                    'status'            => $b->status,
                    'timing_status'     => $b->timing_status,
                    'seconds_to_start'  => $now->diffInSeconds($start, false),
                    'seconds_to_end'    => $now->diffInSeconds($end, false),
                    'overtime_minutes'  => $b->overtime_minutes,
                    'overtime_cost'     => $b->overtime_cost,
                    'checked_out_at'    => $b->checked_out_at
                        ? $b->checked_out_at->setTimezone('Africa/Nairobi')->format('H:i')
                        : null,
                    'lapsed_expires_in' => ($b->status === 'lapsed' && $b->checked_out_at)
                        ? max(0, 30 - $b->checked_out_at->diffInMinutes($now))
                        : null,
                ];
            })
            ->values();

        return response()->json($bookings);
    }

    // ── Checkout a session ───────────────────────────────────────────────
public function checkout(Booking $booking)
{
    if (!in_array($booking->status, ['confirmed', 'lapsed'])) {
        return response()->json([
            'success' => false,
            'message' => 'This booking cannot be checked out.',
        ], 422);
    }

    $now        = now('Africa/Nairobi');
    $sessionEnd = Carbon::parse(
        $booking->booking_date->format('Y-m-d') . ' ' . $booking->start_time,
        'Africa/Nairobi'
    )->addMinutes($booking->duration_minutes);

    $isOvertime   = $now->gt($sessionEnd);
    $overtimeMins = $isOvertime ? (int) $sessionEnd->diffInMinutes($now) : 0;
    $overtimeCost = $isOvertime ? (int) round($overtimeMins * (1000 / 60)) : 0;

    // ── Overtime STK Push ─────────────────────────────────────────────
    if ($isOvertime && $overtimeCost > 0) {
        $reference = 'SGS-OT-' . $booking->id . '-' . time();

        try {
            $mpesa    = app(\App\Services\MpesaService::class);
            $response = $mpesa->stkPush($booking->phone, (int) $overtimeCost, $reference);

            if (!isset($response['CheckoutRequestID'])) {
                return response()->json([
                    'success'          => false,
                    'requires_payment' => true,
                    'overtime_minutes' => $overtimeMins,
                    'overtime_cost'    => $overtimeCost,
                    'message'          => 'Could not initiate M-Pesa prompt. Collect KES ' . number_format($overtimeCost) . ' manually.',
                ], 502);
            }

            MpesaPayment::create([
                'checkout_request_id' => $response['CheckoutRequestID'],
                'merchant_request_id' => $response['MerchantRequestID'] ?? null,
                'phone'               => $booking->phone,
                'amount'              => $overtimeCost,
                'reference'           => $reference,
                'status'              => 'pending',
                'booking_id'          => $booking->id,
            ]);

            // Mark overtime on booking but keep status until payment confirmed
            $booking->update([
                'overtime_minutes' => $overtimeMins,
                'overtime_amount'  => $overtimeCost,
            ]);

            return response()->json([
                'success'             => false,
                'requires_payment'    => true,
                'overtime_minutes'    => $overtimeMins,
                'overtime_cost'       => $overtimeCost,
                'checkout_request_id' => $response['CheckoutRequestID'],
                'phone'               => $booking->phone,
                'message'             => 'M-Pesa prompt sent to ' . $booking->phone . ' for KES ' . number_format($overtimeCost) . ' (' . $overtimeMins . ' mins overtime). Waiting for payment…',
            ]);

        } catch (\Exception $e) {
            logger()->error('Overtime STK Push failed: ' . $e->getMessage());
            return response()->json([
                'success'          => false,
                'requires_payment' => true,
                'overtime_minutes' => $overtimeMins,
                'overtime_cost'    => $overtimeCost,
                'message'          => 'M-Pesa unavailable. Collect KES ' . number_format($overtimeCost) . ' manually before checking out.',
            ], 502);
        }
    }

    // ── No overtime — complete checkout immediately ───────────────────
    $booking->update([
        'status'           => 'lapsed',
        'checked_out_at'   => $now,
        'overtime_minutes' => 0,
        'overtime_amount'  => 0,
    ]);

    return response()->json([
        'success'          => true,
        'booking_id'       => $booking->id,
        'name'             => $booking->name,
        'checked_out_at'   => $now->format('H:i:s'),
        'was_overtime'     => false,
        'overtime_minutes' => 0,
        'overtime_cost'    => 0,
        'message'          => "Checked out {$booking->name} on time ✓",
    ]);
}

// ── Finalise checkout after overtime payment confirmed ───────────────
public function checkoutConfirm(Booking $booking)
{
    $now = now('Africa/Nairobi');

    $booking->update([
        'status'         => 'lapsed',
        'checked_out_at' => $now,
    ]);

    return response()->json([
        'success'        => true,
        'name'           => $booking->name,
        'checked_out_at' => $now->format('H:i:s'),
    ]);
}

    // ── Preview recurring slots ──────────────────────────────────────────
    public function previewRecurring(Request $request)
    {
        try {
            $request->validate([
                'booking_date'         => ['required', 'date', 'after_or_equal:today'],
                'room'                 => ['required', Rule::in(array_keys(Booking::$rooms))],
                'start_time'           => ['required'],
                'duration'             => ['required'],
                'recurrence_frequency' => ['required', Rule::in(['daily', 'weekly', 'biweekly', 'monthly'])],
                'recurrence_end'       => ['required', 'date', 'after:booking_date'],
            ]);

            $startDate = Carbon::parse($request->booking_date);
            $endDate   = Carbon::parse($request->recurrence_end);
            $room      = $request->room;
            $startTime = $request->start_time;
            $frequency = $request->recurrence_frequency;

            $dates   = [];
            $current = $startDate->copy();
            while ($current->lte($endDate)) {
                $dates[]  = $current->copy();
                $current  = match($frequency) {
                    'daily' => $current->addDay(),
                    'weekly'   => $current->addWeek(),
                    'biweekly' => $current->addWeeks(2),
                    'monthly'  => $current->addMonth(),
                };
            }

            $slots = collect($dates)->map(function (Carbon $date) use ($room, $startTime) {
                $isTaken = Booking::isSlotTaken($date->toDateString(), $room, $startTime);
                return [
                    'date'      => $date->toDateString(),
                    'formatted' => $date->format('D, d M Y'),
                    'available' => !$isTaken,
                    'conflict'  => $isTaken,
                ];
            });

            $availableCount = $slots->where('available', true)->count();
            $conflictCount  = $slots->where('conflict', true)->count();
            $amount         = Booking::computeAmount($request->duration);
            $totalAmount    = $availableCount * $amount;

            return response()->json([
                'slots'           => $slots,
                'available_count' => $availableCount,
                'conflict_count'  => $conflictCount,
                'amount_per'      => $amount,
                'total_amount'    => $totalAmount,
                'frequency_label' => match($frequency) {
                    'daily' => "Daily",
                    'weekly'   => 'Weekly',
                    'biweekly' => 'Every 2 Weeks',
                    'monthly'  => 'Monthly',
                },
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            logger()->error('Preview recurring error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ── Store recurring bookings via M-Pesa ──────────────────────────────
    public function storeRecurring(Request $request, MpesaService $mpesa)
    {
        $request->validate([
            'name'                 => ['required', 'string', 'max:120'],
            'phone'                => ['required', 'string', 'min:10', 'max:15'],
            'booking_date'         => ['required', 'date', 'after_or_equal:today'],
            'room'                 => ['required', Rule::in(array_keys(Booking::$rooms))],
            'start_time'           => ['required'],
            'duration'             => ['required', Rule::in(array_keys(Booking::$durations))],
            'notes'                => ['nullable', 'string', 'max:600'],
            'recurrence_frequency' => ['required', Rule::in(['daily', 'weekly', 'biweekly', 'monthly'])],
            'recurrence_end'       => ['required', 'date', 'after:booking_date'],
            'amount'               => ['required', 'numeric', 'min:1'],
        ]);

        $startDate = Carbon::parse($request->booking_date);
        $endDate   = Carbon::parse($request->recurrence_end);
        $frequency = $request->recurrence_frequency;

        // Generate all dates
        $dates   = [];
        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            $dates[]  = $current->copy();
            $current  = match($frequency) {
                'daily' => $current->addDay(),
                'weekly'   => $current->addWeek(),
                'biweekly' => $current->addWeeks(2),
                'monthly'  => $current->addMonth(),
            };
        }

        // Filter to available dates only
        $availableDates = array_values(array_filter($dates, function (Carbon $date) use ($request) {
            return !Booking::isSlotTaken($date->toDateString(), $request->room, $request->start_time);
        }));

        $amountPerSession = Booking::computeAmount($request->duration);
        $totalAmount      = count($availableDates) * $amountPerSession;

        if ($totalAmount <= 0) {
            return back()->withErrors(['slot' => 'No available slots found for the selected dates.']);
        }

        $reference = 'SGS-REC-' . strtoupper(substr(preg_replace('/\D/', '', $request->phone), -6)) . '-' . time();

        try {
            $response = $mpesa->stkPush($request->phone, (int) $totalAmount, $reference);
        } catch (\Exception $e) {
            logger()->error('Recurring STK Push failed: ' . $e->getMessage());
            return back()->withInput()
                ->withErrors(['payment' => 'M-Pesa service unavailable. Please try again.']);
        }

        if (!isset($response['CheckoutRequestID'])) {
            return back()->withInput()
                ->withErrors(['payment' => 'Could not initiate M-Pesa payment. Try again.']);
        }

        MpesaPayment::create([
            'checkout_request_id' => $response['CheckoutRequestID'],
            'merchant_request_id' => $response['MerchantRequestID'] ?? null,
            'phone'               => $request->phone,
            'amount'              => $totalAmount,
            'reference'           => $reference,
            'status'              => 'pending',
        ]);

        // Clear any stale single booking session and set recurring
        session()->forget(['pending_booking', 'payment_type']);
        session([
            'pending_recurring' => [
                'name'                 => $request->name,
                'phone'                => $request->phone,
                'booking_date'         => $request->booking_date,
                'room'                 => $request->room,
                'start_time'           => $request->start_time,
                'duration'             => $request->duration,
                'notes'                => $request->notes,
                'recurrence_frequency' => $frequency,
                'recurrence_end'       => $request->recurrence_end,
                'skip_conflicts'       => $request->boolean('skip_conflicts', true),
                'amount_per_session'   => $amountPerSession,
                'total_amount'         => $totalAmount,
                'session_count'        => count($availableDates),
            ],
            'payment_type'                    => 'recurring',
            'mpesa_checkout_id'               => $response['CheckoutRequestID'],
            'pending_booking_session_count'   => count($availableDates),
        ]);

        return view('bookings.payment-pending', [
            'checkoutRequestId' => $response['CheckoutRequestID'],
            'amount'            => $totalAmount,
            'phone'             => $request->phone,
            'is_recurring'      => true,
            'session_count'     => count($availableDates),
            'amount_per'        => $amountPerSession,
        ]);
    }

    // ── Recurring confirmation page ──────────────────────────────────────
    public function recurringConfirmation(Request $request)
    {
        $groupId  = $request->group;
        $bookings = Booking::where('recurrence_group_id', $groupId)
            ->orderBy('booking_date')
            ->get();

        return view('bookings.recurring-confirmation', compact('bookings', 'groupId'));
    }

    // ── Hard delete booking ──────────────────────────────────────────────
public function hardDelete(Booking $booking)
{
    $id = $booking->id;
    $booking->delete();

    return redirect()
        ->route('bookings.admin')
        ->with('success', "Booking #{$id} has been permanently deleted.");
}
}