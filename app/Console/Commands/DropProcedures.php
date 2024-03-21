<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DropProcedures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drop-procedures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_profile_address');
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_user_primary_links_views');

    }
}
