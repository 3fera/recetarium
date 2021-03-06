<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\Providers\Cookidoo\Parser;

class ImportCookido extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:cookidoo';

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
        $parser = new Parser();
    }
}
