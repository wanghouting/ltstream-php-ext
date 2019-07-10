<?php

namespace LTStream\Extension\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'ltstream:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install ltstream php extension for laravel';

    /**
     * Install directory.
     *
     * @var string
     */
    protected $directory = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->initExtension();

    }

    /**
     * Create tables and seed it.
     *
     * @return void
     */
    public function initExtension()
    {
        $this->call('vendor:publish', ['--provider'=> "LTTools\LTStream\LaravelServiceProvider"]);
        
    }


}
