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
        DB::table('client_statuses')->insert([
            [
                'name' => 'Waitlist',
                'value' => 0
            ],
            [
                'name' => 'Active',
                'value' => 1
            ],
            [
                'name' => 'On Leave',
                'value' => 2
            ],
            [
                'name' => 'Concluded',
                'value' => 3
            ],
            [
                'name' => 'Removed',
                'value' => -1
            ]
        ]);
    }
}
