<?php

namespace Database\Seeders;

use App\Models\PlayerTransactionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerTransactionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('player_transaction_types')->delete();

//        PlayerTransactionType::create([
//            'name' => 'Drafted',
//            'code' => 'draft'
//        ]);

        PlayerTransactionType::create([
            'name' => 'Added',
            'code' => 'add',
        ]);

        PlayerTransactionType::create([
            'name' => 'Dropped',
            'code' => 'drop',
        ]);

        PlayerTransactionType::create([
            'name' => 'Traded',
            'code' => 'trade',
        ]);

        PlayerTransactionType::create([
            'name' => 'Watched',
            'code' => 'watch',
        ]);

        PlayerTransactionType::create([
            'name' => 'Claim Request',
            'code' => 'claim_request',
        ]);

        PlayerTransactionType::create([
            'name' => 'Claim Rejected',
            'code' => 'claim_reject',
        ]);

        PlayerTransactionType::create([
            'name' => 'Claim Approve',
            'code' => 'claim_approve',
        ]);

        PlayerTransactionType::create([
            'name' => 'Starter to Bench',
            'code' => 'starter_to_bench',
        ]);

        PlayerTransactionType::create([
            'name' => 'Bench to Starter',
            'code' => 'bench_to_starter',
        ]);

        PlayerTransactionType::create([
            'name' => 'Claim Cancelled',
            'code' => 'claim_cancelled',
        ]);
    }
}
