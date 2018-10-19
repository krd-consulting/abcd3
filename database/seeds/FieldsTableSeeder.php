<?php

use Illuminate\Database\Seeder;

class FieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // First Name
        DB::table('fields')->insert([
            'name' => 'first_name',
            'type' => 'text'
        ]);

        // Last Name
        DB::table('fields')->insert([
            'name' => 'last_name',
            'type' => 'text'
        ]);

        // Business Name
        DB::table('fields')->insert([
            'name' => 'business_name',
            'type' => 'text'
        ]);

        // Email Address
        DB::table('fields')->insert([
            'name' => 'email_address',
            'type' => 'text'
        ]);

        // Contact Number
        DB::table('fields')->insert([
            'name' => 'contact_number',
            'type' => 'text'
        ]);

        // Birth Date
        DB::table('fields')->insert([
            'name' => 'birth_date',
            'type' => 'text'
        ]);
    }
}
