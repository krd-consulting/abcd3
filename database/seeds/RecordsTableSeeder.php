<?php

use Illuminate\Database\Seeder;

use App\Program;
use App\Record;
use App\RecordType;
use App\Team;
use App\User;

class RecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roman = new Record;
        $roman->record_type_id = RecordType::where('name', 'Staff')->first()->id;
        $roman->field_1_value = 'Roman';
        $roman->field_2_value = 'Katsnelson';
        $roman->field_3_value = 'roman@hellokrd.net';
        $roman->user()->associate(User::find(1));
        $roman->save();

        $rupert = new Record;
        $rupert->record_type_id = RecordType::where('name', 'Staff')->first()->id;
        $rupert->field_1_value = 'Rupert';
        $rupert->field_2_value = 'Amodia';
        $rupert->field_3_value = 'rupert@hellokrd.net';
        $rupert->user()->associate(User::find(2));
        $rupert->save();
        $rupert->teams()->save(Team::inRandomOrder()->first());

        $gui = new Record;
        $gui->record_type_id = RecordType::where('name', 'Staff')->first()->id;
        $gui->field_1_value = 'Gui';
        $gui->field_2_value = 'Gramari';
        $gui->field_3_value = 'gui@hellokrd.net';
        $gui->user()->associate(User::find(3));
        $gui->save();
        $gui->teams()->save(Team::inRandomOrder()->first());

        $scott = new Record;
        $scott->record_type_id = RecordType::where('name', 'Staff')->first()->id;
        $scott->field_1_value = 'Scott';
        $scott->field_2_value = 'McCrae';
        $scott->field_3_value = 'scott@hellokrd.net';
        $scott->user()->associate(User::find(4));
        $scott->save();
        $scott->teams()->save(Team::inRandomOrder()->first());

        factory(Record::class, 500)
            ->create()
            ->each(function($record) {
                // Add record to a random team.
                $record
                    ->teams()
                    ->save(Team::inRandomOrder()->first());

                // Add record to a random program.
                rand(0,1) == 1
                    ? $record
                        ->programs()
                        ->attach(Program::inRandomOrder()->first(), [
                            'notes' => '',
                            'status' => 'active',
                            'status_updated_at' => now()
                        ])
                    : NULL;
            });
    }
}
