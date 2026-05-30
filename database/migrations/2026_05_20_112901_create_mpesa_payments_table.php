<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('mpesa_payments', function (Blueprint $table) {
        $table->id();
        $table->string('checkout_request_id')->unique();
        $table->string('merchant_request_id')->nullable();
        $table->string('phone');
        $table->decimal('amount', 10, 2);
        $table->string('reference');
        $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
        $table->string('mpesa_receipt')->nullable();
        $table->json('raw_callback')->nullable();
        $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
        $table->timestamps();
    });
}
};
