<?php

namespace App\Console\Commands;

use App\Models\Sales;
use Illuminate\Console\Command;

class AutoSaleEnable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sale_enable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        Sales::whereDate('start_date', '<=', date('Y-m-d'))->where('status',0)->update(['status'=>1]);
    }
}
