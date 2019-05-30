<?php

use Illuminate\Database\Seeder;

class ClientStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('client_statuses')->insert(config('app.program_client_statuses'));
    }
}
