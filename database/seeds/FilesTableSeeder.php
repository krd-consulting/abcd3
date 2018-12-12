<?php

use Illuminate\Database\Seeder;

use App\Team;

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
                $file
                    ->teams()
                    ->save(Team::inRandomOrder()->first());
            });
    }
}
