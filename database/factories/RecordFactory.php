<?php

use Faker\Generator as Faker;

use App\Field;
use App\Record;
use App\RecordType;

$factory->define(Record::class, function (Faker $faker) {
    $recordType = RecordType::inRandomOrder()->first();

    $fields = array();
    $values = array();
    $fields[0] = Field::find($recordType->identity->field_1_id);
    $fields[1] = Field::find($recordType->identity->field_2_id);
    $fields[2] = Field::find($recordType->identity->field_3_id);

    foreach($fields as $index=>$field) {
        switch($field->name) {
            case 'first_name':
                $values[$index] = $faker->firstName();
                break;

            case 'last_name':
                $values[$index] = $faker->lastName();
                break;

            case 'business_name':
                $values[$index] = $faker->company;
                break;

            case 'email_address':
                $values[$index] = $faker->freeEmail;
                break;

            case 'birth_date':
                $values[$index] = $faker->date;
                break;

            default:
                $values[$index] = $faker->phoneNumber;
                break;
        }
    }

    return [
        'record_type_id' => $recordType->id,
        'field_1_value' => $values[0],
        'field_2_value' => $values[1],
        'field_3_value' => $values[2],
        'created_by' => 1,
        'updated_by' => 1
    ];
});
