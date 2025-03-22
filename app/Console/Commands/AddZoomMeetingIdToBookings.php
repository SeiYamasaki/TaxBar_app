<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AddZoomMeetingIdToBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:add-zoom-meeting-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add zoom_meeting_id column to bookings table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Adding zoom_meeting_id column to bookings table...');

        try {
            if (Schema::hasColumn('bookings', 'zoom_meeting_id')) {
                $this->info('Column zoom_meeting_id already exists. Skipping.');
                return 0;
            }

            Schema::table('bookings', function (Blueprint $table) {
                $table->string('zoom_meeting_id')->nullable()->after('zoom_meeting_url');
                $table->string('zoom_meeting_password')->nullable()->after('zoom_meeting_id');
            });

            $this->info('Column zoom_meeting_id and zoom_meeting_password successfully added to bookings table.');
            return 0;
        } catch (\Exception $e) {
            $this->error('Error adding columns: ' . $e->getMessage());
            return 1;
        }
    }
}
