<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 9:42 PM ---------
 */

namespace SimpleCMS\ActivityLog;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class CleanActivityLogCommand extends Command
{
    protected $signature = 'activitylog:clean
                            {log? : (optional) The log name that will be cleaned.}
                            {--days= : (optional) Records older than this number of days will be cleaned.}';

    protected $description = 'Clean up old records from the activity log.';

    public function handle()
    {
        $this->comment('Cleaning activity log...');

        $log = $this->argument('log');

        $maxAgeInDays = $this->option('days') ?? config('activitylog.delete_records_older_than_days');

        $cutOffDate = Carbon::now()->subDays($maxAgeInDays)->format('Y-m-d H:i:s');

        $activity = ActivitylogServiceProvider::getActivityModelInstance();

        $amountDeleted = $activity::where('created_at', '<', $cutOffDate)
            ->when($log !== null, function (Builder $query) use ($log) {
                $query->inLog($log);
            })
            ->delete();

        $this->info("Deleted {$amountDeleted} record(s) from the activity log.");

        $this->comment('All done!');
    }
}
