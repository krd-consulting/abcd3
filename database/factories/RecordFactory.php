<?php

use Faker\Generator as Faker;

use App\Field;
use App\Record;
use App\RecordType;

$factory->define(Record::class, function (Faker $faker) {
    $recordType = RecordType::inRandomOrder()->first();
    $field3 = Field::find($recordType->field_3_id);
    $field3Value = '';

    switch($field3->name){
        case 'birth_date':
            $field3Value = $faker->date();
            break;

        case 'email_address':
            $field3Value = $faker->freeEmail;
            break;

        default:
            $field3Value = $faker->phoneNumber;
    }

    return [
        'record_type_id' => $recordType->id,
        'field_1_value' => $faker->firstName(),
        'field_2_value' => $faker->lastName(),
        'field_3_value' => $field3Value
    ];
});
