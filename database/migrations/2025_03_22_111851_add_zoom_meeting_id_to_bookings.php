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
            if (!Schema::hasColumn('bookings', 'zoom_meeting_id')) {
                $table->string('zoom_meeting_id')->nullable()->after('zoom_meeting_url');
            }

            if (!Schema::hasColumn('bookings', 'zoom_meeting_password')) {
                $table->string('zoom_meeting_password')->nullable()->after('zoom_meeting_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'zoom_meeting_id')) {
                $table->dropColumn('zoom_meeting_id');
            }

            if (Schema::hasColumn('bookings', 'zoom_meeting_password')) {
                $table->dropColumn('zoom_meeting_password');
            }
        });
    }
};
