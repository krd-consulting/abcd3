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
        $externalIdentity = RecordIdentity::where('name', 'External')->first();

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
        $staff->save();

        // Volunteers
        $volunteers = new RecordType;
        $volunteers->name = 'Volunteers';
        $volunteers->slug = 'volunteers';
        $volunteers->identity_id = $volunteerIdentity->id;
        $volunteers->save();

        $funders = new RecordType;
        $funders->name = 'Funders';
        $funders->slug = 'funders';
        $funders->identity_id = $externalIdentity->id;
        $funders->save();
    }
}
