<?php

use Illuminate\Database\Seeder;

use App\Field;
use App\RecordType;

class RecordTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firstName = Field::where('name', 'first_name')->first();
        $lastName = Field::where('name', 'last_name')->first();
        $business = Field::where('name', 'business_name')->first();
        $email = Field::where('name', 'email_address')->first();
        $contact = Field::where('name', 'contact_number')->first();
        $birth_date = Field::where('name', 'birth_date')->first();

        // Participants
        $participants = new RecordType;
        $participants->name = 'Participants';
        $participants->field_1_id = $firstName->id;
        $participants->field_2_id = $lastName->id;
        $participants->field_3_id = $birth_date->id;
        $participants->slug = 'participants';
        $participants->save();

        // Staff
        $staff = new RecordType;
        $staff->name = 'Staff';
        $staff->field_1_id = $firstName->id;
        $staff->field_2_id = $lastName->id;
        $staff->field_3_id = $email->id;
        $staff->slug = 'staff';
        $staff->save();

        // Volunteers
        $volunteers = new RecordType;
        $volunteers->name = 'Volunteers';
        $volunteers->field_1_id = $firstName->id;
        $volunteers->field_2_id = $lastName->id;
        $volunteers->field_3_id = $contact->id;
        $volunteers->slug = 'volunteers';
        $volunteers->save();
    }
}
