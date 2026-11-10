<?php

namespace App\Console\Commands;

use App\Models\FeaturedRecord;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteExpiredFeaturedCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:expired-featured-company';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expired featured company-job deleted';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        FeaturedRecord::where('end_time', '<', Carbon::today())->delete();
    }
}
