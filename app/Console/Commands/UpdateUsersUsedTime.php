<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\package_users;

class UpdateUsersUsedTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateTime:user';

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
        package_users::query()->update(['usedTime' => 0, 'usedAutom' => 0]);
    }
}
