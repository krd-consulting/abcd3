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

        $this->call(FileTypesTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(FilesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
