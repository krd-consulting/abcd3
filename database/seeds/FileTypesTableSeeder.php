<?php

use Illuminate\Database\Seeder;

use App\Field as Field;

class FileTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $field1 = Field::where('name', 'first_name')->first();
        $field2 = Field::where('name', 'last_name')->first();
        $field3 = Field::where('name', 'email_address')->first();

        // Participants
        DB::table('file_types')->insert([
            'name' => 'Participants',
            'description' => 'text',
            'field_1_id' => $field1->id,
            'field_2_id' => $field2->id,
            'field_3_id' => $field3->id
        ]);

        // Staff
        DB::table('file_types')->insert([
            'name' => 'Staff',
            'description' => 'text',
            'field_1_id' => $field1->id,
            'field_2_id' => $field2->id,
            'field_3_id' => $field3->id
        ]);

        // Volunteers
        DB::table('file_types')->insert([
            'name' => 'Volunteers',
            'description' => 'text',
            'field_1_id' => $field1->id,
            'field_2_id' => $field2->id,
            'field_3_id' => $field3->id
        ]);
    }
}
