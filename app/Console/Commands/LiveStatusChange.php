<?php

namespace App\Console\Commands;

use App\Models\Live;
use Illuminate\Console\Command;

class LiveStatusChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'liveStatus:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'change live status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Live::where('status',Live::WAITING)->where('start_at','<=',now())->update(['status'=>Live::BEGINNING]);
        Live::where('status',Live::BEGINNING)->where('end_at','<=',now())->update(['status'=>Live::END]);
    }
}
