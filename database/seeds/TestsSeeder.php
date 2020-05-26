<?php

use Illuminate\Database\Seeder;

class TestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RecordFieldsTableSeeder::class);
        $this->call(ScopesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ClientStatusTableSeeder::class);
        $this->call(FormTargetTypeSeeder::class);

        $this->call(RecordIdentitiesTableSeeder::class);
        $this->call(RecordTypesTableSeeder::class);
    }
}
