<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_settings')->delete();

        SystemSetting::create([
            'season' => 2021,
            'season_type' => 1,
            'week' => 1,
            'waiver_period_enabled' => false,
        ]);
    }
}
