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
        $this->call(EntityTypesTableSeeder::class);
        $this->call(RecordFieldsTableSeeder::class);
        $this->call(ScopesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ClientStatusTableSeeder::class);
        $this->call(FormTargetTypeSeeder::class);
        $this->call(CollectionsTableSeeder::class);

        $this->call(RecordIdentitiesTableSeeder::class);
        $this->call(RecordTypesTableSeeder::class);

        $this->call(UsersTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(ProgramsTableSeeder::class);
        $this->call(RecordsTableSeeder::class);
    }
}
