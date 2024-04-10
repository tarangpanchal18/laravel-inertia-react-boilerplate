<?php

namespace App\Console\Commands;

use App\Http\Controllers\InitController;
use Illuminate\Console\Command;

class InitAdmin extends Command
{
    protected $signature = 'initialize:admin';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $initializeAdmin = new InitController;
        $initializeAdmin->initialize();
        $this->info("Admin Pannel initialized successfully.");
    }
}
