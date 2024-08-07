<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete activity logs';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle(): int
    {
        $date = Carbon::now()->subDay();
        DB::table('activity_log')->where('created_at', '<', $date)->delete();

        $this->info('Activity logs older than 24 hours have been deleted successfully.');

        return 0;
    }
}
