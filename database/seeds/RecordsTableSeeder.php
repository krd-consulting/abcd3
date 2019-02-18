<?php

use Illuminate\Database\Seeder;

use App\Team;
use App\Program;

class RecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Record::class, 2000)
            ->create()
            ->each(function($record) {
                // Add record to a random team.
                $record
                    ->teams()
                    ->save(Team::inRandomOrder()->first());

                // Add record to a random program.
                rand(0,1) == 1
                    ? $record
                        ->programs()
                        ->attach(Program::inRandomOrder()->first(), [
                            'notes' => '',
                            'status' => 'active',
                            'status_updated_at' => now()
                        ])
                    : NULL;
            });
    }
}
