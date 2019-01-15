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
        $this->call(FieldsTableSeeder::class);
        $this->call(ScopesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);

        $this->call(RecordTypesTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(ProgramsTableSeeder::class);
        $this->call(RecordsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
