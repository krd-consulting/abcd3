<?php

use Illuminate\Database\Seeder;

use App\Field;
use App\RecordIdentity;

class RecordIdentitiesTableSeeder extends Seeder
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
        $clients = new RecordIdentity;
        $clients->name = 'Client';
        $clients->field_1_id = $firstName->id;
        $clients->field_2_id = $lastName->id;
        $clients->field_3_id = $birth_date->id;
        $clients->save();

        // Staff
        $staff = new RecordIdentity;
        $staff->name = 'Staff';
        $staff->field_1_id = $firstName->id;
        $staff->field_2_id = $lastName->id;
        $staff->field_3_id = $email->id;
        $staff->save();

        // Volunteers
        $volunteers = new RecordIdentity;
        $volunteers->name = 'Volunteer';
        $volunteers->field_1_id = $firstName->id;
        $volunteers->field_2_id = $lastName->id;
        $volunteers->field_3_id = $contact->id;
        $volunteers->save();

        // External
        $external = new RecordIdentity;
        $external->name = 'External';
        $external->field_1_id = $business->id;
        $external->field_2_id = $email->id;
        $external->field_3_id = $contact->id;

        $external->save();
    }
}
