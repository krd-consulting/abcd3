<?php

use Illuminate\Database\Seeder;

use App\RecordIdentity;
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
        $clientIdentity = RecordIdentity::where('name', 'Client')->first();
        $staffIdentity = RecordIdentity::where('name', 'Staff')->first();
        $volunteerIdentity = RecordIdentity::where('name', 'Volunteer')->first();
        $otherIdentity = RecordIdentity::where('name', 'Other')->first();

        // Participants
        $participants = new RecordType;
        $participants->name = 'Participants';
        $participants->slug = 'participants';
        $participants->identity_id = $clientIdentity->id;
        $participants->save();

        // Staff
        $staff = new RecordType;
        $staff->name = 'Staff';
        $staff->slug = 'staff';
        $staff->identity_id = $staffIdentity->id;
        $staff->userable = true;
        $staff->save();

        // Volunteers
        $volunteers = new RecordType;
        $volunteers->name = 'Volunteers';
        $volunteers->slug = 'volunteers';
        $volunteers->identity_id = $volunteerIdentity->id;
        $volunteers->save();

        $meals = new RecordType;
        $meals->name = 'Meals';
        $meals->slug = 'meals';
        $meals->identity_id = $otherIdentity->id;
        $meals->save();
    }
}
