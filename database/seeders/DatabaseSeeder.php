<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PlayerTransactionTypeTableSeeder::class);
        $this->command->info('player_transaction_types table seeded!');

        $this->call(SystemSettingsTableSeeder::class);
        $this->command->info('System Settings table seeded!');
    }
}
