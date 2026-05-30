<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    // MySQL requires re-defining the full enum to add a value
    DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending','confirmed','cancelled','lapsed') NOT NULL DEFAULT 'pending'");
}

public function down(): void
{
    DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending'");
}
};
