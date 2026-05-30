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
    Schema::table('bookings', function (Blueprint $table) {
        $table->enum('room', ['room-a','room-b','room-c','room-d','room-e'])->after('booking_date');
    });
}

public function down(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn('room');
    });
}
};
