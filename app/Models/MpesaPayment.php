<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MpesaPayment extends Model
{
    protected $fillable = [
        'checkout_request_id',
        'merchant_request_id',
        'phone',
        'amount',
        'reference',
        'status',
        'mpesa_receipt',
        'raw_callback',
        'booking_id',
    ];

    protected $casts = [
        'raw_callback' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}