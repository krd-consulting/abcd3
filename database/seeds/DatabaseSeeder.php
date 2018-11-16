<?php

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
        $this->call(ScopesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(TeamUserTableSeeder::class);
        $this->call(FieldsTableSeeder::class);
        $this->call(FileTypesTableSeeder::class);
        $this->call(FilesTableSeeder::class);
        $this->call(ProgramsTableSeeder::class);
    }
}
