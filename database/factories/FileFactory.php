<?php

use Faker\Generator as Faker;

use App\Field;
use App\File;
use App\FileType;

$factory->define(File::class, function (Faker $faker) {
    $fileType = FileType::inRandomOrder()->first();
    $field3 = Field::find($fileType->field_3_id);
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
        'file_type_id' => $fileType->id,
        'field_1_value' => $faker->firstName(),
        'field_2_value' => $faker->lastName(),
        'field_3_value' => $field3Value
    ];
});
