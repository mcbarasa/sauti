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
    DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending','confirmed','cancelled','lapsed','completed') NOT NULL DEFAULT 'pending'");
    
    Schema::table('bookings', function (Blueprint $table) {
        $table->timestamp('checked_out_at')->nullable()->after('updated_at');
    });
}

public function down(): void
{
    DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending','confirmed','cancelled','lapsed') NOT NULL DEFAULT 'pending'");
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn('checked_out_at');
    });
}
};
