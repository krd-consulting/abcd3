<?php

use Illuminate\Database\Seeder;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\File::class, 50)->create();

        App\File::all()->each(function ($file) {
            $file->teams()->attach(rand(1,2));
        });
    }
}
