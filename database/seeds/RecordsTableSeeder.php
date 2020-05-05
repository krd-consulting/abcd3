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
        $roman->active = true;
        $roman->user()->associate($user);
        $roman->save();

        $rupert = new Record;
        $rupert->record_type_id = RecordType::where('name', 'Staff')->first()->id;
        $rupert->field_1_value = 'Rupert';
        $rupert->field_2_value = 'Amodia';
        $rupert->field_3_value = 'rupert@hellokrd.net';
        $roman->active = true;
        $rupert->user()->associate(User::find(2));
        $rupert->save();
        $rupert->teams()->save(Team::inRandomOrder()->first());

        $isabel = new Record;
        $isabel->record_type_id = RecordType::where('name', 'Staff')->first()->id;
        $isabel->field_1_value = 'Isabel';
        $isabel->field_2_value = 'Everen';
        $isabel->field_3_value = 'isabel@hellokrd.net';
        $isabel->active = true;
        $isabel->user()->associate(User::find(3));
        $isabel->save();
        $isabel->teams()->save(Team::inRandomOrder()->first());

        $alanya = new Record;
        $alanya->record_type_id = RecordType::where('name', 'Staff')->first()->id;
        $alanya->field_1_value = 'Alanya';
        $alanya->field_2_value = 'Dhalla';
        $alanya->field_3_value = 'alanya@hellokrd.net';
        $alanya->active = true;
        $alanya->user()->associate(User::find(4));
        $alanya->save();
        $alanya->teams()->save(Team::inRandomOrder()->first());

        factory(Record::class, 500)
            ->create()
            ->each(function($record) use ($user) {
                // Add record to a random program.
                if(rand(0,1) == 1) {
                    $program = Program::inRandomOrder()->first();

                    $class = 'App\\Program' . $record->record_type->identity->model;

                    $programRecord = new $class();
                    $programRecord->program_id = $program->id;
                    $programRecord->record_id = $record->id;
                    $programRecord->enrolled_at = date_create('now');
                    $programRecord->save();
                }
            });
    }
}
