<?php

use Illuminate\Database\Seeder;

use App\Program;
use App\ProgramClient;
use App\Record;
use App\RecordType;
use App\ProgramRecord;
use App\Team;
use App\User;

use App\Events\ProgramRecordCreated;

class RecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);

        $roman = new Record;
        $roman->record_type_id = RecordType::where('name', 'Staff')->first()->id;
        $roman->field_1_value = 'Roman';
        $roman->field_2_value = 'Katsnelson';
        $roman->field_3_value = 'roman@hellokrd.net';
        $roman->user()->associate($user);
        $roman->created_by = $user->id;
        $roman->updated_by = $user->id;
        $roman->save();

        $rupert = new Record;
        $rupert->record_type_id = RecordType::where('name', 'Staff')->first()->id;
        $rupert->field_1_value = 'Rupert';
        $rupert->field_2_value = 'Amodia';
        $rupert->field_3_value = 'rupert@hellokrd.net';
        $rupert->user()->associate(User::find(2));
        $rupert->created_by = $user->id;
        $rupert->updated_by = $user->id;
        $rupert->save();
        $rupert->teams()->save(Team::inRandomOrder()->first());

        $gui = new Record;
        $gui->record_type_id = RecordType::where('name', 'Staff')->first()->id;
        $gui->field_1_value = 'Gui';
        $gui->field_2_value = 'Gramari';
        $gui->field_3_value = 'gui@hellokrd.net';
        $gui->user()->associate(User::find(3));
        $gui->created_by = $user->id;
        $gui->updated_by = $user->id;
        $gui->save();
        $gui->teams()->save(Team::inRandomOrder()->first());

        $scott = new Record;
        $scott->record_type_id = RecordType::where('name', 'Staff')->first()->id;
        $scott->field_1_value = 'Scott';
        $scott->field_2_value = 'McCrae';
        $scott->field_3_value = 'scott@hellokrd.net';
        $scott->user()->associate(User::find(4));
        $scott->created_by = $user->id;
        $scott->updated_by = $user->id;
        $scott->save();
        $scott->teams()->save(Team::inRandomOrder()->first());

        factory(Record::class, 500)
            ->create()
            ->each(function($record) use ($user) {
                // Add record to a random program.
                if(rand(0,1) == 1) {
                    $program = Program::inRandomOrder()->first();

                    $programRecord = new ProgramRecord();
                    $programRecord->program_id = $program->id;
                    $programRecord->record_id = $record->id;
                    $programRecord->enrolled_at = date_create('now');
                    $programRecord->created_by = $user->id;
                    $programRecord->save();
                }
            });
    }
}
