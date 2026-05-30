<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class MpesaService
{
public function getAccessToken(): string
{
    $cacheKey = 'mpesa_access_token';
    $retryKey = 'mpesa_token_retry_after';

    // Check if we're in a cooldown period
    if (Cache::has($retryKey)) {
        $retryAfter = Cache::get($retryKey);
        $secondsLeft = $retryAfter - now()->timestamp;

        throw new \Exception(
            "M-Pesa is temporarily unavailable. Please try again in " .
            ceil($secondsLeft / 60) . " minute(s)."
        );
    }

    // Return cached token if still valid
    if (Cache::has($cacheKey)) {
        return Cache::get($cacheKey);
    }

    try {
        $response = Http::withBasicAuth(
            config('mpesa.consumer_key'),
            config('mpesa.consumer_secret')
        )->get(rtrim(config('mpesa.base_url'), '/') . '/oauth/v1/generate?grant_type=client_credentials');

        $token = $response->json('access_token');

        if ($response->failed() || is_null($token)) {
            // Set a 60-second cooldown before allowing retry
            Cache::put($retryKey, now()->addMinute()->timestamp, 60);

            throw new \Exception(
                "Could not connect to M-Pesa. Please try again in 1 minute."
            );
        }

        // Cache the token for 55 minutes (tokens expire after 1 hour)
        Cache::put($cacheKey, $token, now()->addMinutes(55));

        return $token;

    } catch (\Illuminate\Http\Client\ConnectionException $e) {
        Cache::put($retryKey, now()->addMinute()->timestamp, 60);

        throw new \Exception(
            "Could not reach M-Pesa servers. Please try again in 1 minute."
        );
    }
}

    public function stkPush(string $phone, int $amount, string $reference): array
    {
        $token     = $this->getAccessToken();
        $timestamp = now('Africa/Nairobi')->format('YmdHis');
        $shortcode = config('mpesa.shortcode');
        $password  = base64_encode($shortcode . config('mpesa.passkey') . $timestamp);
        $phone     = $this->formatPhone($phone);

        $response = Http::withToken($token)
            ->post(config('mpesa.base_url') . '/mpesa/stkpush/v1/processrequest', [
                'BusinessShortCode' => $shortcode,
                'Password'          => $password,
                'Timestamp'         => $timestamp,
                'TransactionType'   => 'CustomerPayBillOnline',
                'Amount'            => $amount,
                'PartyA'            => $phone,
                'PartyB'            => $shortcode,
                'PhoneNumber'       => $phone,
                'CallBackURL'       => config('mpesa.callback_url'),
                'AccountReference'  => $reference,
                'TransactionDesc'   => 'Sauti Gang Studio Booking',
            ]);

        Log::info('STK Push', $response->json());
        return $response->json();
    }

    public function stkQuery(string $checkoutRequestId): array
    {
        $token     = $this->getAccessToken();
        $timestamp = now('Africa/Nairobi')->format('YmdHis');
        $shortcode = config('mpesa.shortcode');
        $password  = base64_encode($shortcode . config('mpesa.passkey') . $timestamp);

        $response = Http::withToken($token)
            ->post(config('mpesa.base_url') . '/mpesa/stkpushquery/v1/query', [
                'BusinessShortCode' => $shortcode,
                'Password'          => $password,
                'Timestamp'         => $timestamp,
                'CheckoutRequestID' => $checkoutRequestId,
            ]);

        return $response->json();
    }

    public function formatPhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        if (str_starts_with($phone, '0')) $phone = '254' . substr($phone, 1);
        return ltrim($phone, '+');
    }
}