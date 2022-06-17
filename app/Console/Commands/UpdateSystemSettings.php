<?php

namespace App\Console\Commands;

use App\Models\SystemSetting;
use Illuminate\Console\Command;

class UpdateSystemSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateSystemSettings {--week=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update system settings';

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
        $week = $this->option('week');
        $settings = SystemSetting::find(1);
        if ($settings) {
            $settings->week = $week;
            $settings->save();
            $this->info('System settings been updated successfully');
        } else {
            $this->error('No details found');
        }
    }
}
