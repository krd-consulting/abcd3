<?php

use Illuminate\Database\Seeder;

use App\Team;
use App\Program;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\File::class, 50)
            ->create()
            ->each(function($file) {
                // Add file to a random team.
                $file
                    ->teams()
                    ->save(Team::inRandomOrder()->first());

                // Add file to a random program.
                rand(0,1) == 1
                    ? $file
                        ->programs()
                        ->save(Program::inRandomOrder()->first())
                    : NULL;
            });
    }
}
