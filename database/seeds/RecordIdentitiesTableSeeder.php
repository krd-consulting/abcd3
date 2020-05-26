<?php

use Illuminate\Database\Seeder;

use App\RecordField;
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
        $firstName = RecordField::where('slug', 'first_name')->first();
        $lastName = RecordField::where('slug', 'last_name')->first();
        $name = RecordField::where('slug', 'name')->first();
        $email = RecordField::where('slug', 'email_address')->first();
        $contact = RecordField::where('slug', 'contact_number')->first();
        $birth_date = RecordField::where('slug', 'birth_date')->first();

        // Clients
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

        // Other
        $other = new RecordIdentity;
        $other->name = 'Other';
        $other->field_1_id = $name->id;

        $other->save();
    }
}
